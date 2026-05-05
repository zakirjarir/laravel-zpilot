<?php

namespace ZakirJarir\LaravelZPilot\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use ZakirJarir\LaravelZPilot\Helpers\EnvironmentManager;
use ZakirJarir\LaravelZPilot\Helpers\RequirementsChecker;

class ZPilotController extends Controller
{
    protected $environmentManager;
    protected $requirementsChecker;

    public function __construct(EnvironmentManager $environmentManager, RequirementsChecker $requirementsChecker)
    {
        $this->environmentManager = $environmentManager;
        $this->requirementsChecker = $requirementsChecker;
        
        // Simple middleware-like check
        if (file_exists(storage_path('installed'))) {
            abort(404);
        }
    }

    public function welcome()
    {
        return view('zpilot::welcome');
    }

    public function requirements()
    {
        $dynamicRequirements = $this->requirementsChecker->getRequirements();
        $requirements = $this->requirementsChecker->check($dynamicRequirements);

        $permissions = $this->requirementsChecker->checkPermissions([
            'storage/framework/'     => '775',
            'storage/logs/'          => '775',
            'bootstrap/cache/'       => '775',
            'public/'                => '775',
        ]);

        return view('zpilot::requirements', compact('requirements', 'permissions'));
    }

    public function environment()
    {
        $envValues = $this->environmentManager->getEnvExampleValues();
        return view('zpilot::environment', compact('envValues'));
    }

    public function saveEnvironment(Request $request)
    {
        // Set dynamic config to attempt DB connection/creation
        $this->setDatabaseConfig($request);

        try {
            if ($request->has('DB_DATABASE')) {
                $this->createDatabaseIfNotExists($request->DB_DATABASE);
            }
        } catch (\Exception $e) {
            return back()->with(['message' => 'Database creation failed: ' . $e->getMessage()]);
        }

        $result = $this->environmentManager->saveFileWizard($request);
        
        if ($result === "Success") {
            return redirect()->route('zpilot.database');
        }

        return back()->with(['message' => $result]);
    }

    private function setDatabaseConfig($request)
    {
        config(['database.connections.setup' => [
            'driver' => $request->DB_CONNECTION ?? 'mysql',
            'host' => $request->DB_HOST ?? '127.0.0.1',
            'port' => $request->DB_PORT ?? '3306',
            'database' => null, // Connect without DB first
            'username' => $request->DB_USERNAME ?? 'root',
            'password' => $request->DB_PASSWORD ?? '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
        ]]);

        // Refresh connection with new config
        DB::purge('setup');
    }

    private function createDatabaseIfNotExists($dbName)
    {
        // Try to connect and execute creation
        $pdo = DB::connection('setup')->getPdo();
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    }

    public function database()
    {
        $detectedPackages = $this->detectSetupRequiredPackages();
        return view('zpilot::process', compact('detectedPackages'));
    }

    private function detectSetupRequiredPackages()
    {
        $commands = Artisan::all();
        $setupList = [];

        $packages = [
            'jwt:secret' => 'JWT Authentication',
            'passport:install' => 'Laravel Passport',
            'sanctum:install' => 'Laravel Sanctum',
            'telescope:install' => 'Laravel Telescope',
            'horizon:install' => 'Laravel Horizon',
            'filament:install' => 'Filament Admin',
        ];

        foreach ($packages as $command => $name) {
            if (array_key_exists($command, $commands)) {
                $setupList[] = ['command' => $command, 'name' => $name];
            }
        }

        return $setupList;
    }

    public function runInstallation(Request $request)
    {
        try {
            // 1. Ensure Database Exists (Fallback)
            $dbName = config('database.connections.' . config('database.default') . '.database');
            if ($dbName) {
                $this->ensureDatabaseExists($dbName);
            }

            // 2. Run Migrations
            if ($request->has('fresh_install')) {
                Artisan::call('migrate:fresh', ['--force' => true]);
            } else {
                Artisan::call('migrate', ['--force' => true]);
            }
            
            // 3. Run Seeders if requested
            if ($request->has('run_seed')) {
                Artisan::call('db:seed', ['--force' => true]);
            }

            // 4. Generate Application Key
            Artisan::call('key:generate', ['--force' => true]);

            // 5. Create Storage Link
            Artisan::call('storage:link');

            // 6. Run Detected Package Commands (JWT, Passport, etc.)
            if ($request->has('setup_packages')) {
                foreach ($request->setup_packages as $command) {
                    Artisan::call($command, ['--force' => true]);
                }
            }

            return redirect()->route('zpilot.finish');
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1] ?? null;
            if ($errorCode == 1062) {
                return back()->with(['message' => 'Installation failed: Data already exists (Duplicate Entry). Please clear your database manually or select "Fresh Installation" to wipe and re-run.']);
            }
            return back()->with(['message' => 'Database error: ' . $e->getMessage()]);
        } catch (\Exception $e) {
            return back()->with(['message' => 'Installation failed: ' . $e->getMessage()]);
        }
    }

    private function ensureDatabaseExists($dbName)
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            // If connection fails, try to create it using 'setup' connection pattern
            // We need to temporarily set the config without the database name to connect to the server
            $config = config('database.connections.' . config('database.default'));
            $setupConfig = $config;
            $setupConfig['database'] = null;
            
            config(['database.connections.setup_temp' => $setupConfig]);
            DB::purge('setup_temp');
            
            $pdo = DB::connection('setup_temp')->getPdo();
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
            DB::purge(config('database.default'));
        }
    }

    public function finish()
    {
        file_put_contents(storage_path('installed'), '');
        return view('zpilot::finish');
    }
}

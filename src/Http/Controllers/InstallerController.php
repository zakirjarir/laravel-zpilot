<?php

namespace ZakirJarir\LaravelInstaller\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use ZakirJarir\LaravelInstaller\Helpers\EnvironmentManager;
use ZakirJarir\LaravelInstaller\Helpers\RequirementsChecker;

class InstallerController extends Controller
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
        return view('installer::welcome');
    }

    public function requirements()
    {
        $dynamicRequirements = $this->requirementsChecker->getRequirements();
        $requirements = $this->requirementsChecker->check($dynamicRequirements);

        $permissions = $this->requirementsChecker->checkPermissions([
            'storage/framework/'     => '775',
            'storage/logs/'          => '775',
            'bootstrap/cache/'       => '775',
        ]);

        return view('installer::requirements', compact('requirements', 'permissions'));
    }

    public function environment()
    {
        $envValues = $this->environmentManager->getEnvExampleValues();
        return view('installer::environment', compact('envValues'));
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
            return redirect()->route('installer.database');
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
        return view('installer::process');
    }

    public function runInstallation(Request $request)
    {
        try {
            // 1. Run Migrations
            Artisan::call('migrate', ['--force' => true]);
            
            // 2. Run Seeders if requested
            if ($request->has('run_seed')) {
                Artisan::call('db:seed', ['--force' => true]);
            }

            return redirect()->route('installer.finish');
        } catch (\Exception $e) {
            return back()->with(['message' => 'Installation failed: ' . $e->getMessage()]);
        }
    }

    public function finish()
    {
        file_put_contents(storage_path('installed'), '');
        return view('installer::finish');
    }
}

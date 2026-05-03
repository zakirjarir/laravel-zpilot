<?php

namespace ZakirJarir\LaravelInstaller\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
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
        $requirements = $this->requirementsChecker->check([
            'php' => '8.1.0',
            'extensions' => [
                'openssl',
                'pdo',
                'mbstring',
                'tokenizer',
                'JSON',
                'cURL',
            ],
        ]);

        $permissions = $this->requirementsChecker->checkPermissions([
            'storage/framework/'     => '775',
            'storage/logs/'          => '775',
            'bootstrap/cache/'       => '775',
        ]);

        return view('installer::requirements', compact('requirements', 'permissions'));
    }

    public function environment()
    {
        $envContent = $this->environmentManager->getEnvContent();
        return view('installer::environment', compact('envContent'));
    }

    public function saveEnvironment(Request $request)
    {
        $result = $this->environmentManager->saveFileWizard($request);
        
        if ($result === "Success") {
            return redirect()->route('installer.database');
        }

        return back()->with(['message' => $result]);
    }

    public function database()
    {
        return view('installer::database');
    }

    public function runMigrations()
    {
        try {
            Artisan::call('migrate', ['--force' => true]);
            return redirect()->route('installer.seeder');
        } catch (\Exception $e) {
            return back()->with(['message' => $e->getMessage()]);
        }
    }

    public function seeder()
    {
        return view('installer::seeder');
    }

    public function runSeeders()
    {
        try {
            Artisan::call('db:seed', ['--force' => true]);
            return redirect()->route('installer.finish');
        } catch (\Exception $e) {
            return back()->with(['message' => $e->getMessage()]);
        }
    }

    public function finish()
    {
        file_put_contents(storage_path('installed'), '');
        return view('installer::finish');
    }
}

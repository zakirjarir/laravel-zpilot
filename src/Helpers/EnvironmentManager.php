<?php

namespace ZakirJarir\LaravelInstaller\Helpers;

use Exception;
use Illuminate\Http\Request;

class EnvironmentManager
{
    /**
     * @var string
     */
    private $envPath;

    /**
     * @var string
     */
    private $envExamplePath;

    /**
     * Set the .env and .env.example paths.
     */
    public function __construct()
    {
        $this->envPath = base_path('.env');
        $this->envExamplePath = base_path('.env.example');
    }

    /**
     * Get the content of the .env file.
     *
     * @return string
     */
    public function getEnvContent()
    {
        if (!file_exists($this->envPath)) {
            if (file_exists($this->envExamplePath)) {
                copy($this->envExamplePath, $this->envPath);
            } else {
                touch($this->envPath);
            }
        }

        return file_get_contents($this->envPath);
    }

    /**
     * Save the edited content to the .env file.
     *
     * @param Request $input
     * @return string
     */
    public function saveFileWizard(Request $input)
    {
        $envFileData =
            'APP_NAME="' . ($input->app_name ?? 'Laravel') . "\"\n" .
            'APP_ENV=' . ($input->app_env ?? 'local') . "\n" .
            'APP_KEY=base64:' . base64_encode(random_bytes(32)) . "\n" .
            'APP_DEBUG=' . ($input->app_debug ?? 'true') . "\n" .
            'APP_URL=' . ($input->app_url ?? 'http://localhost') . "\n\n" .
            'LOG_CHANNEL=stack' . "\n\n" .
            'DB_CONNECTION=' . ($input->database_connection ?? 'mysql') . "\n" .
            'DB_HOST=' . ($input->database_host ?? '127.0.0.1') . "\n" .
            'DB_PORT=' . ($input->database_port ?? '3306') . "\n" .
            'DB_DATABASE=' . ($input->database_name ?? 'laravel') . "\n" .
            'DB_USERNAME=' . ($input->database_username ?? 'root') . "\n" .
            'DB_PASSWORD="' . ($input->database_password ?? '') . "\"\n\n" .
            'BROADCAST_DRIVER=log' . "\n" .
            'CACHE_DRIVER=file' . "\n" .
            'QUEUE_CONNECTION=sync' . "\n" .
            'SESSION_DRIVER=file' . "\n" .
            'SESSION_LIFETIME=120' . "\n";

        try {
            file_put_contents($this->envPath, $envFileData);
        } catch (Exception $e) {
            return "Unable to save the .env file, please check permissions.";
        }

        return "Success";
    }
}

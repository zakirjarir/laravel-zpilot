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
     * Get the content of the .env.example file as an array of keys and values.
     *
     * @return array
     */
    public function getEnvExampleValues()
    {
        $path = $this->envExamplePath;
        if (!file_exists($path)) {
            return [];
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $values = [];

        foreach ($lines as $line) {
            if (str_starts_with($line, '#') || !str_contains($line, '=')) {
                continue;
            }

            list($key, $value) = explode('=', $line, 2);
            $values[trim($key)] = trim($value, '"\' ');
        }

        return $values;
    }

    /**
     * Save the edited content to the .env file dynamically.
     *
     * @param Request $input
     * @return string
     */
    public function saveFileWizard(Request $input)
    {
        $data = $input->except(['_token']);
        $envContent = "";

        foreach ($data as $key => $value) {
            // Special handling for keys that might need quotes or generation
            if ($key === 'APP_KEY' && empty($value)) {
                $value = 'base64:' . base64_encode(random_bytes(32));
            }

            if (str_contains($value, ' ') || str_contains($value, '#')) {
                $value = '"' . $value . '"';
            }

            $envContent .= "{$key}={$value}\n";
        }

        try {
            file_put_contents($this->envPath, $envContent);
        } catch (Exception $e) {
            return "Unable to save the .env file, please check permissions.";
        }

        return "Success";
    }
}

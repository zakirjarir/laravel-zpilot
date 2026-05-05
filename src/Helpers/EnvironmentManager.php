<?php

namespace ZakirJarir\LaravelZPilot\Helpers;

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
     * Ensure .env file exists.
     */
    public function ensureEnvExists()
    {
        if (!file_exists($this->envPath)) {
            if (file_exists($this->envExamplePath)) {
                copy($this->envExamplePath, $this->envPath);
            } else {
                // Generate a basic default .env if example is also missing
                $defaultEnv = "APP_NAME=Laravel\nAPP_ENV=local\nAPP_KEY=base64:".base64_encode(random_bytes(32))."\nAPP_DEBUG=true\nAPP_URL=http://localhost\n\nDB_CONNECTION=mysql\nDB_HOST=127.0.0.1\nDB_PORT=3306\nDB_DATABASE=laravel\nDB_USERNAME=root\nDB_PASSWORD=\n\nSESSION_DRIVER=file\nCACHE_STORE=file\n";
                file_put_contents($this->envPath, $defaultEnv);
            }
        }
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
            if (strpos($line, '#') === 0 || strpos($line, '=') === false) {
                continue;
            }

            list($key, $value) = explode('=', $line, 2);
            $values[trim($key)] = trim($value, '"\' ');
        }

        return $values;
    }

    /**
     * Save the edited content to the .env file dynamically.
     * This method is non-destructive and preserves existing comments and formatting.
     *
     * @param Request $input
     * @return string
     */
    public function saveFileWizard(Request $input)
    {
        $data = $input->except(['_token']);
        
        try {
            $content = $this->getEnvContent();
            
            foreach ($data as $key => $value) {
                $key = strtoupper($key);
                
                // Special handling for APP_KEY if empty
                if ($key === 'APP_KEY' && empty($value)) {
                    $value = 'base64:' . base64_encode(random_bytes(32));
                }

                // Handle quotes for values with spaces or special characters
                if ($value !== null && (strpos($value, ' ') !== false || strpos($value, '#') !== false)) {
                    $value = '"' . str_replace('"', '\"', $value) . '"';
                }

                $keyValue = "{$key}={$value}";

                $pattern = "/^" . preg_quote($key, '/') . "=.*/m";

                if (preg_match("/^" . preg_quote($key, '/') . "=/m", $content)) {
                    $content = preg_replace($pattern, $keyValue, $content);
                } else {
                    $content .= "\n{$keyValue}";
                }
            }

            file_put_contents($this->envPath, trim($content) . "\n");
        } catch (Exception $e) {
            return "Unable to save the .env file: " . $e->getMessage();
        }

        return "Success";
    }
}

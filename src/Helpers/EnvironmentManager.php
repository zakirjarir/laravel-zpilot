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
        $appName = $input->app_name ?? 'Laravel';
        $appUrl = $input->app_url ?? 'http://localhost';
        $dbConn = $input->database_connection ?? 'mysql';
        $dbHost = $input->database_host ?? '127.0.0.1';
        $dbPort = $input->database_port ?? '3306';
        $dbName = $input->database_name ?? 'laravel';
        $dbUser = $input->database_username ?? 'root';
        $dbPass = $input->database_password ?? '';
        $appKey = 'base64:' . base64_encode(random_bytes(32));

        $envFileData = 
"APP_NAME=\"{$appName}\"
APP_ENV=local
APP_KEY={$appKey}
APP_DEBUG=true
APP_URL={$appUrl}

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
# APP_MAINTENANCE_STORE=database

# PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION={$dbConn}
DB_HOST={$dbHost}
DB_PORT={$dbPort}
DB_DATABASE={$dbName}
DB_USERNAME={$dbUser}
DB_PASSWORD={$dbPass}

SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
# CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS=\"hello@example.com\"
MAIL_FROM_NAME=\"\${APP_NAME}\"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME=\"\${APP_NAME}\"
";

        try {
            file_put_contents($this->envPath, $envFileData);
        } catch (Exception $e) {
            return "Unable to save the .env file, please check permissions.";
        }

        return "Success";
    }
}

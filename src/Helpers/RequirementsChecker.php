<?php

namespace ZakirJarir\LaravelInstaller\Helpers;

class RequirementsChecker
{
    /**
     * Minimum PHP version.
     *
     * @var string
     */
    private $minPhpVersion = '8.1.0';

    /**
     * Check for the server requirements.
     *
     * @param array $requirements
     * @return array
     */
    public function check(array $requirements)
    {
        $results = [];

        foreach ($requirements as $type => $requirement) {
            switch ($type) {
                // Check PHP version
                case 'php':
                    $results['php'] = [
                        'full' => phpversion(),
                        'current' => phpversion(),
                        'minimum' => $this->minPhpVersion,
                        'supported' => version_compare(phpversion(), $this->minPhpVersion, '>='),
                    ];
                    break;

                // Check PHP extensions
                case 'extensions':
                    foreach ($requirement as $extension) {
                        $results['extensions'][$extension] = extension_loaded($extension);
                    }
                    break;
            }
        }

        return $results;
    }

    /**
     * Check permissions.
     *
     * @param array $permissions
     * @return array
     */
    public function checkPermissions(array $permissions)
    {
        $results = [];

        foreach ($permissions as $path => $permission) {
            $fullPath = base_path($path);
            $results['permissions'][$path] = [
                'isSet' => is_writable($fullPath),
                'permission' => $permission,
            ];
        }

        return $results;
    }
}

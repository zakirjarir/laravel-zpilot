<?php

namespace ZakirJarir\LaravelZPilot\Helpers;

class RequirementsChecker
{
    /**
     * Minimum PHP version.
     *
     * @var string
     */
    private $minPhpVersion = '7.4.0';

    /**
     * Get requirements from composer.json.
     *
     * @return array
     */
    public function getRequirements()
    {
        $composerPath = base_path('composer.json');
        if (!file_exists($composerPath)) {
            return [
                'php' => '7.4.0',
                'extensions' => ['openssl', 'pdo', 'mbstring', 'tokenizer', 'JSON', 'cURL']
            ];
        }

        $composer = json_decode(file_get_contents($composerPath), true);
        $requires = $composer['require'] ?? [];
        
        $phpVersion = '7.4.0';
        $extensions = ['openssl', 'pdo', 'mbstring', 'tokenizer', 'JSON', 'cURL'];

        foreach ($requires as $package => $version) {
            if ($package === 'php') {
                $phpVersion = str_replace(['^', '>=', '>'], '', $version);
            } elseif (strpos($package, 'ext-') === 0) {
                $extensions[] = str_replace('ext-', '', $package);
            }
        }

        return [
            'php' => $phpVersion,
            'extensions' => array_unique($extensions)
        ];
    }

    /**
     * Check for the server requirements.
     *
     * @param array $requirements
     * @return array
     */
    public function check(array $requirements)
    {
        $results = [];
        $minPhp = $requirements['php'] ?? '7.4.0';

        $results['php'] = [
            'full' => phpversion(),
            'current' => phpversion(),
            'minimum' => $minPhp,
            'supported' => version_compare(phpversion(), $minPhp, '>='),
        ];

        foreach ($requirements['extensions'] as $extension) {
            $results['extensions'][$extension] = extension_loaded($extension);
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

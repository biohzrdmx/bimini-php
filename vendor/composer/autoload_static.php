<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc3a3a5baa79339d0fe5c7016c655abe4
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'Bimini\\Tests\\' => 13,
            'Bimini\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Bimini\\Tests\\' => 
        array (
            0 => __DIR__ . '/../..' . '/tests',
        ),
        'Bimini\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc3a3a5baa79339d0fe5c7016c655abe4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc3a3a5baa79339d0fe5c7016c655abe4::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc3a3a5baa79339d0fe5c7016c655abe4::$classMap;

        }, null, ClassLoader::class);
    }
}

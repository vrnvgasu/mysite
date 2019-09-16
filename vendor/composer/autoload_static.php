<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf15b67f67a56c974f4fb16f22ebdb71b
{
    public static $prefixLengthsPsr4 = array (
        'i' => 
        array (
            'ishop\\' => 6,
        ),
        'a' => 
        array (
            'app\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ishop\\' => 
        array (
            0 => __DIR__ . '/..' . '/ishop/core',
        ),
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf15b67f67a56c974f4fb16f22ebdb71b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf15b67f67a56c974f4fb16f22ebdb71b::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
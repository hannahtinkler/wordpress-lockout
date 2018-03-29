<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit20dacdecb6c49a3aacb22cbe1b030a84
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'CmsLockout\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'CmsLockout\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static $classMap = array (
        'CmsLockout\\Core' => __DIR__ . '/../..' . '/core.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit20dacdecb6c49a3aacb22cbe1b030a84::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit20dacdecb6c49a3aacb22cbe1b030a84::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit20dacdecb6c49a3aacb22cbe1b030a84::$classMap;

        }, null, ClassLoader::class);
    }
}

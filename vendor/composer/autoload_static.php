<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7ff3a7ffc22ce4b868b37925ae168dc1
{
    public static $files = array (

    );

    public static $prefixLengthsPsr4 = array (
       
        'L' => 
        array (
            'Latecka\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Latecka\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static $prefixesPsr0 = array (

    );

    public static $classMap = array (
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7ff3a7ffc22ce4b868b37925ae168dc1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7ff3a7ffc22ce4b868b37925ae168dc1::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit7ff3a7ffc22ce4b868b37925ae168dc1::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit7ff3a7ffc22ce4b868b37925ae168dc1::$classMap;

        }, null, ClassLoader::class);
    }
}
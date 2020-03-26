<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit58736051796ff5afe8ffe33ab87979e4
{
    public static $prefixLengthsPsr4 = array (
        'H' => 
        array (
            'HSession\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'HSession\\' => 
        array (
            0 => __DIR__ . '/..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit58736051796ff5afe8ffe33ab87979e4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit58736051796ff5afe8ffe33ab87979e4::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

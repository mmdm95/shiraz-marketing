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

    public static $classMap = array (
        'HSession\\Security\\Crypt\\Crypt' => __DIR__ . '/..' . '/src/crypt/Crypt.php',
        'HSession\\Security\\Crypt\\CryptException' => __DIR__ . '/..' . '/src/crypt/CryptException.php',
        'HSession\\Security\\Crypt\\CryptInterface' => __DIR__ . '/..' . '/src/crypt/CryptInterface.php',
        'HSession\\Session\\Session' => __DIR__ . '/..' . '/src/Session.php',
        'HSession\\Session\\SessionInterface' => __DIR__ . '/..' . '/src/SessionInterface.php',
        'HSession\\Traits\\GeneralTrait' => __DIR__ . '/..' . '/src/traits/GeneralTrait.php',
        'HSession\\Traits\\InstantiatorTrait' => __DIR__ . '/..' . '/src/traits/InstantiatorTrait.php',
        'HSession\\Traits\\ValidatorTrait' => __DIR__ . '/..' . '/src/traits/ValidatorTrait.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit58736051796ff5afe8ffe33ab87979e4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit58736051796ff5afe8ffe33ab87979e4::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit58736051796ff5afe8ffe33ab87979e4::$classMap;

        }, null, ClassLoader::class);
    }
}

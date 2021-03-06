<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9f183127e523fdab65eac5ba260fa7dc
{
    public static $prefixLengthsPsr4 = array (
        'H' => 
        array (
            'HConvert\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'HConvert\\' => 
        array (
            0 => __DIR__ . '/..' . '/src',
        ),
    );

    public static $classMap = array (
        'HConvert\\Converter\\NumberConverter' => __DIR__ . '/..' . '/src/NumberConverter.php',
        'HConvert\\Traits\\GeneralTrait' => __DIR__ . '/..' . '/src/traits/GeneralTrait.php',
        'HConvert\\Traits\\InstantiatorTrait' => __DIR__ . '/..' . '/src/traits/InstantiatorTrait.php',
        'HConvert\\Traits\\ValidatorTrait' => __DIR__ . '/..' . '/src/traits/ValidatorTrait.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9f183127e523fdab65eac5ba260fa7dc::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9f183127e523fdab65eac5ba260fa7dc::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9f183127e523fdab65eac5ba260fa7dc::$classMap;

        }, null, ClassLoader::class);
    }
}

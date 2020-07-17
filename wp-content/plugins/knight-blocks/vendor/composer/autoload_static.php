<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0418468f08e4949480bb589090759924
{
    public static $prefixLengthsPsr4 = array (
        'K' => 
        array (
            'Knight_Blocks\\' => 14,
        ),
        'D' => 
        array (
            'Dealerdirect\\Composer\\Plugin\\Installers\\PHPCodeSniffer\\' => 55,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Knight_Blocks\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Dealerdirect\\Composer\\Plugin\\Installers\\PHPCodeSniffer\\' => 
        array (
            0 => __DIR__ . '/..' . '/dealerdirect/phpcodesniffer-composer-installer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0418468f08e4949480bb589090759924::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0418468f08e4949480bb589090759924::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

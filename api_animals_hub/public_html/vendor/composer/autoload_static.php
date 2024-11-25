<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdc5108315c693b07ecbfcead9a3ebeca
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdc5108315c693b07ecbfcead9a3ebeca::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdc5108315c693b07ecbfcead9a3ebeca::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

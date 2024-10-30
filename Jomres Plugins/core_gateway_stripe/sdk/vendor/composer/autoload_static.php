<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit291580ceacf7dc8b58eb0a789c9d713e
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__. '/..' . '/stripe/stripe-php/lib',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit291580ceacf7dc8b58eb0a789c9d713e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit291580ceacf7dc8b58eb0a789c9d713e::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

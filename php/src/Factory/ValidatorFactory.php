<?php

namespace App\Factory;

use Illuminate\Validation\Factory;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;

class ValidatorFactory
{
    public static function create(): Factory
    {
        $fileLoader = new FileLoader(
            new Filesystem(),
            getenv('ROOT_FOLDER') . '/translations'
        );
        $factory = new Factory(
            new Translator($fileLoader, 'en')
        );

        return $factory;
    }
}

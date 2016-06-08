<?php

namespace eLife\Patterns\Mustache;

use Mustache_Loader_FilesystemLoader;

final class PatternLabLoader extends Mustache_Loader_FilesystemLoader
{
    public function load($name)
    {
        $parts = explode('-', $name);
        if (count($parts) > 1) {
            array_shift($parts);
        }
        $name = implode('-', $parts);

        return parent::load($name);
    }
}

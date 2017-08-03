<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

final class PictureSource implements CastsToArray
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $srcset;
    private $type;
    private $media;

    public function __construct(string $path1x, string $path2x = null, MediaType $type = null, string $media = null)
    {
        if ($path2x) {
            $this->srcset = "{$path2x} 2x, ${path1x} 1x";
        } else {
            $this->srcset = $path1x;
        }

        if ($type) {
            $this->type = $type['forMachine'];
        }

        $this->media = $media;
    }
}

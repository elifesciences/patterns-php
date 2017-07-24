<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

final class ContentHeaderImage implements CastsToArray
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $fallback;
    private $sources;
    private $pictureClasses;
    private $credit;

    public function __construct(Picture $picture, string $credit = null)
    {
        $this->fallback = $picture['fallback'];
        $this->sources = $picture['sources'];
        $this->pictureClasses = $picture['pictureClasses'];
        if ($credit) {
            $this->credit = [
                'text' => $credit,
                'elementId' => hash('crc32', uniqid('', true)),
            ];
        }
    }
}

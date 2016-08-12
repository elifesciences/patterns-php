<?php

namespace tests\eLife\Patterns\ViewModel\Partials;

use eLife\Patterns\ViewModel\TeaserImage;

trait TeaserImageFromData
{
    abstract public function srcsetToArray($data);

    public function teaserImageFromData($data, $size = TeaserImage::STYLE_SMALL)
    {
        $data = array_merge([
            'defaultPath' => null,
            'altText' => null,
            'url' => null,
            'srcset' => null,
        ], $data);
        $data['srcset'] = $this->srcsetToArray($data['srcset']);
        $params = array_values($data);
        switch ($size) {
            case TeaserImage::STYLE_BIG:
                return TeaserImage::big(...$params);
            case TeaserImage::STYLE_SMALL:
                return TeaserImage::small(...$params);
            case TeaserImage::STYLE_PROMINENT:
                return TeaserImage::prominent(...$params);
        }
    }
}

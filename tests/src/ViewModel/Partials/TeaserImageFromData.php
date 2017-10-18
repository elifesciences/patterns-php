<?php

namespace tests\eLife\Patterns\ViewModel\Partials;

use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Picture;
use eLife\Patterns\ViewModel\TeaserImage;

trait TeaserImageFromData
{
    abstract public function srcsetToArray($data);

    public function teaserImageFromData($data, $size = TeaserImage::STYLE_SMALL)
    {
        $image = array_merge([
            'defaultPath' => null,
            'srcset' => null,
            'altText' => null,
        ], $data['fallback']);
        $image['srcset'] = $this->srcsetToArray($image['srcset']);
        $picture = new Picture([], new Image(...array_values($image)));
        switch ($size) {
            case TeaserImage::STYLE_BIG:
                return TeaserImage::big($picture);
            case TeaserImage::STYLE_SMALL:
                return TeaserImage::small($picture);
            case TeaserImage::STYLE_PROMINENT:
                return TeaserImage::prominent($picture);
        }
    }
}

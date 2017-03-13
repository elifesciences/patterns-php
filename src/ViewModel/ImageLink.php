<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class ImageLink implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $url;
    private $image;

    public function __construct(string $url, Picture $image)
    {
        $this->url = $url;
        $this->image = FlexibleViewModel::fromViewModel($image)->withProperty('pictureClasses', 'image-link__picture');
        $this->image = $this->image->withProperty('fallback', ['classes' => 'image-link__img'] + $this->image['fallback']);
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/image-link.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/image-link.css';
    }
}

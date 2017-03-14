<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class BlockLink implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $text;
    private $url;
    private $behaviour;
    private $backgroundImage;

    public function __construct(Link $link, BackgroundImage $backgroundImage = null)
    {
        $this->text = $link['name'];
        $this->url = $link['url'];
        if ($backgroundImage) {
            $this->behaviour = 'BackgroundImage';
            $this->backgroundImage = $backgroundImage;
        }
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/block-link.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield 'resources/assets/css/block-link.css';
    }
}

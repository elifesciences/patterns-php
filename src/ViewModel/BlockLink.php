<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class BlockLink implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $text;
    private $url;
    private $behaviour;
    private $backgroundImage = false;
    private $lowResImageSource;
    private $highResImageSource;
    private $thresholdWidth;

    public function __construct(Link $link, BackgroundImage $backgroundImage = null)
    {
        $this->text = $link['name'];
        $this->url = $link['url'];
        if ($backgroundImage) {
            $this->behaviour = 'BackgroundImage';
            $this->backgroundImage = true;
            $this->lowResImageSource = $backgroundImage['lowResImageSource'];
            $this->highResImageSource = $backgroundImage['highResImageSource'];
            $this->thresholdWidth = $backgroundImage['thresholdWidth'];
        }
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/block-link.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/block-link.css';
    }
}

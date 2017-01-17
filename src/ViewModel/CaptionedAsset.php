<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use InvalidArgumentException;
use Traversable;

final class CaptionedAsset implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $captionText;
    private $picture;
    private $video;
    private $table;
    private $image;
    private $doi;
    private $download;

    public function __construct(
        IsCaptioned $figure,
        CaptionText $captionText,
        Doi $doi = null,
        Link $download = null
    ) {
        $this->captionText = $captionText;
        $this->setFigure($figure);
        if ($doi !== null) {
            $doi = FlexibleViewModel::fromViewModel($doi);
            $this->doi = $doi->withProperty('variant', Doi::ASSET);
        }
        if ($download) {
            $this->download = [
                'link' => $download['url'],
                'filename' => $download['name'],
            ];
        }
    }

    private function setFigure($figure)
    {
        // Reverse switch (i.e. which evaluates to true)
        switch (true) {
            case $figure instanceof Image:
                $this->image = $figure;
                break;

            case $figure instanceof Picture:
                $this->picture = $figure;
                break;

            case $figure instanceof Video:
                $this->video = $figure;
                break;

            case $figure instanceof Table:
                $this->table = $figure;
                break;

            default:
                throw new InvalidArgumentException('Unknown figure type '.get_class($figure));
        }
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/captioned-asset.css';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/captioned-asset.mustache';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->captionText;
        yield $this->picture;
        yield $this->doi;
        yield $this->video;
        yield $this->table;
    }
}

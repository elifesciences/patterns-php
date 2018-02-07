<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class Download implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $text;
    private $buttonCollection;

    public function __construct(string $text, ButtonCollection $buttonCollection)
    {
        Assertion::notBlank($text);

        if (!$buttonCollection['centered']) {
            $buttonCollection = FlexibleViewModel::fromViewModel($buttonCollection)
                ->withProperty('centered', true);
        }

        $this->text = $text;
        $this->buttonCollection = $buttonCollection;
    }

    protected function getLocalStyleSheets() : Traversable
    {
        yield 'resources/assets/css/download.css';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->buttonCollection;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/download.mustache';
    }
}

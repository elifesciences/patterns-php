<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class Doi implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $uri;
    private $classNames;

    public function __construct(string $uri, array $classNames = [])
    {
        Assertion::notBlank($uri);

        $this->uri = $uri;
        if ($classNames) {
            $this->classNames = implode(' ', $classNames);
        }
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/doi.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/doi.css';
    }
}

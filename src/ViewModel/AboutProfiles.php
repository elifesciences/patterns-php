<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class AboutProfiles implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $_heading;
    private $heading;
    private $compact;
    private $items;

    public function __construct(array $items, ListHeading $heading = null, bool $compact = false)
    {
        Assertion::notEmpty($items);
        Assertion::allIsInstanceOf($items, AboutProfile::class);

        if ($heading) {
            $this->_heading = $heading;
            $this->heading = $heading['heading'];
        }
        if ($compact) {
            $this->compact = $compact;
        }
        $this->items = $items;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/about-profiles.mustache';
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield 'resources/assets/css/about-profiles.css';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield from $this->items;
        yield $this->_heading;
    }
}

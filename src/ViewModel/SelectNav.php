<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class SelectNav implements ViewModel
{

    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $route;
    private $select;
    private $button;

    public function __construct(string $route, Select $select, Button $button)
    {
        Assertion::notBlank($route);

        $this->route = $route;
        $this->select = $select;
        $this->button = $button;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/select-nav.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/select-nav.css';
    }
}

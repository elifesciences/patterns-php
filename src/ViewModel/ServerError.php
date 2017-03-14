<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class ServerError implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $button;

    public function __construct(Button $button = null)
    {
        $this->button = $button;
    }

    protected function getLocalStyleSheets() : Traversable
    {
        yield 'resources/assets/css/errors.css';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->button;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/server-error.mustache';
    }
}

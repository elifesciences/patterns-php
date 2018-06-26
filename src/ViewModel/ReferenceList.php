<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class ReferenceList implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $references;

    public function __construct(ReferenceListItem ...$references)
    {
        Assertion::notEmpty($references);

        $this->references = $references;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/reference-list.mustache';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield from $this->references;
    }
}

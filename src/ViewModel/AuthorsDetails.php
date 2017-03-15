<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class AuthorsDetails implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $authorDetails;

    public function __construct(AuthorDetails ...$authorDetails)
    {
        Assertion::notBlank($authorDetails);

        $this->authorDetails = $authorDetails;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/authors-details.mustache';
    }

    protected function getLocalStyleSheets() : Traversable
    {
        yield 'resources/assets/css/authors-details.css';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield from $this->authorDetails;
    }
}

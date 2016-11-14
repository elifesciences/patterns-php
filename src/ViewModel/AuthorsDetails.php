<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\ViewModel;
use Traversable;

final class AuthorsDetails implements ViewModel
{
    use ArrayFromProperties;
    use ComposedAssets;
    use ReadOnlyArrayAccess;

    private $authorDetails;

    public function __construct(AuthorDetails ...$authorDetails)
    {
        Assertion::notBlank($authorDetails);

        $this->authorDetails = $authorDetails;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/authors-details.mustache';
    }

    protected function getLocalStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/authors-details.css';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield from $this->authorDetails;
    }
}

<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class ReferenceAuthorList implements CastsToArray
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $authors;
    private $suffix;

    public function __construct(array $authors, string $suffix)
    {
        Assertion::notEmpty($authors);
        Assertion::allIsInstanceOf($authors, Author::class);
        Assertion::notBlank($suffix);

        $this->authors = $authors;
        $this->suffix = $suffix;
    }
}

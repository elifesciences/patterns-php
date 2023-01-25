<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

final class ContentAsideStatus implements CastsToArray
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $title;
    private $description;
    private $link;

    public function __construct(string $title, string $description = null, Link $link = null)
    {
        Assertion::notBlank($title);
        Assertion::nullOrNotBlank($description);

        $this->title = $title;
        $this->description = $description;
        $this->link = $link;
    }
}

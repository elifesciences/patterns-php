<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

final class ArticleDownloadLink implements CastsToArray
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $primary;
    private $secondary;

    public function __construct(Link $primary, Link $secondary = null)
    {
        $this->primary = $primary;
        $this->secondary = $secondary;
    }
}

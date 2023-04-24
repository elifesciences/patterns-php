<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

final class ArticleDownloadLink implements CastsToArray
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $primary;
    private $secondary;
    private $checkPMC;

    public function __construct(PrimaryLink $primary, Link $secondary = null)
    {
        $this->primary = $primary;
        $this->secondary = $secondary;
    }
}

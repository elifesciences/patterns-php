<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class SortControlOption implements CastsToArray
{
    use ReadOnlyArrayAccess;
    use ArrayFromProperties;

    const ASC = 'ascending';
    const DESC = 'descending';

    private $option;
    private $url;
    private $sorting;

    public function __construct(Link $link, string $sorting)
    {
        Assertion::inArray($sorting, [self::ASC, self::DESC]);

        $this->option = $link['name'];
        $this->url = $link['url'];
        $this->sorting = $sorting;
    }
}

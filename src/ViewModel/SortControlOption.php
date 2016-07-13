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

    public function __construct(string $option, string $url, string $sorting)
    {
        Assertion::notBlank($option);
        Assertion::notBlank($url);
        Assertion::inArray($sorting, [self::ASC, self::DESC]);

        $this->option = $option;
        $this->url = $url;
        $this->sorting = $sorting;
    }
}

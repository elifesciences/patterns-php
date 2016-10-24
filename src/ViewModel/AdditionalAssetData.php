<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class AdditionalAssetData implements CastsToArray
{
    use ReadOnlyArrayAccess;

    private $headingPart1;
    private $headingPart2;
    private $nonDoiLink;
    private $doi = null;
    private $textPart;
    private $downloadLink;

    private function __construct(
        string $headingPart1,
        string $headingPart2 = null,
        string $nonDoiLink = null,
        Doi $doi = null,
        string $textPart = null,
        DownloadLink $downloadLink = null
    ) {
        Assertion::notBlank($headingPart1);

        $this->headingPart1 = $headingPart1;
        $this->headingPart2 = $headingPart2;
        $this->nonDoiLink = $nonDoiLink;
        $this->doi = $doi;
        $this->textPart = $textPart;
        $this->downloadLink = $downloadLink;
    }

    public static function withDoi(
        string $headingPart1,
        string $headingPart2 = null,
        Doi $doi,
        string $textPart = null,
        DownloadLink $downloadLink = null
    ) {
        return new static($headingPart1, $headingPart2, null, $doi, $textPart, $downloadLink);
    }

    public static function withoutDoi(
        string $headingPart1,
        string $headingPart2 = null,
        string $uri,
        string $textPart = null,
        DownloadLink $downloadLink = null
    ) {
        return new static($headingPart1, $headingPart2, $uri, null, $textPart, $downloadLink);
    }

    final public function toArray() : array
    {
        $vars = [];

        foreach (get_object_vars($this) as $key => $value) {
            if ('_' === substr($key, 0, 1)) {
                continue;
            }
            // @todo fix this DOI null bug.
            if ($key === 'doi' && $value === null) {
                $vars[$key] = null;
            }

            $value = $this->handleValue($value);

            if (null !== $value && [] !== $value) {
                $vars[$key] = $value;
            }
        }

        return $vars;
    }

    private function handleValue($value)
    {
        if (is_array($value)) {
            foreach ($value as $subKey => $subValue) {
                $value[$subKey] = $this->handleValue($subValue);
            }
        }

        if ($value instanceof CastsToArray) {
            return $value->toArray();
        }

        return $value;
    }
}

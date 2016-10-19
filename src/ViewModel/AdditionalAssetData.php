<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

class AdditionalAssetData implements CastsToArray
{
    use ReadOnlyArrayAccess;

    private $headingPart;
    private $nonDoiLink;
    private $doi = null;
    private $textPart;
    private $downloadLink;

    private function __construct(
        string $headingPart,
        string $nonDoiLink = null,
        Doi $doi = null,
        string $textPart = null,
        DownloadLink $downloadLink = null
    ) {
        Assertion::notBlank($headingPart);

        $this->headingPart = $headingPart;
        $this->nonDoiLink = $nonDoiLink;
        $this->doi = $doi;
        $this->textPart = $textPart;
        $this->downloadLink = $downloadLink;
    }

    public static function withDoi(string $text, Doi $doi, string $textPart = null, DownloadLink $downloadLink = null)
    {
        return new static($text, null, $doi, $textPart, $downloadLink);
    }

    public static function withoutDoi(string $text, string $nonDoiLink, string $textPart = null, DownloadLink $downloadLink = null)
    {
        Assertion::notBlank($nonDoiLink);

        return new static($text, $nonDoiLink, null, $textPart, $downloadLink);
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

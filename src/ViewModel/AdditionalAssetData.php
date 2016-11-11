<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class AdditionalAssetData implements CastsToArray
{
    use ReadOnlyArrayAccess;

    private $assetId;
    private $headingPart1;
    private $headingPart2;
    private $nonDoiLink;
    private $doi = null;
    private $textPart;
    private $downloadLink;

    private function __construct(
        string $id,
        string $headingPart1,
        DownloadLink $downloadLink,
        string $headingPart2 = null,
        string $nonDoiLink = null,
        Doi $doi = null,
        string $textPart = null
    ) {
        Assertion::notBlank($id);
        Assertion::notBlank($headingPart1);

        if ($doi) {
            $doi = FlexibleViewModel::fromViewModel($doi)
                ->withProperty('variant', Doi::ASSET);
        }

        $this->assetId = $id;
        $this->headingPart1 = $headingPart1;
        $this->headingPart2 = $headingPart2;
        $this->nonDoiLink = $nonDoiLink;
        $this->doi = $doi;
        $this->textPart = $textPart;
        $this->downloadLink = $downloadLink;
    }

    public static function withDoi(
        string $id,
        string $headingPart1,
        DownloadLink $downloadLink,
        string $headingPart2 = null,
        Doi $doi,
        string $textPart = null
    ) {
        return new static($id, $headingPart1, $downloadLink, $headingPart2, null, $doi, $textPart);
    }

    public static function withoutDoi(
        string $id,
        string $headingPart1,
        DownloadLink $downloadLink,
        string $headingPart2 = null,
        string $uri,
        string $textPart = null
    ) {
        return new static($id, $headingPart1, $downloadLink, $headingPart2, $uri, null, $textPart);
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

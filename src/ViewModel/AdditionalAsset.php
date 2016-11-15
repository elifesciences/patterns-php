<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\ViewModel;
use Traversable;

final class AdditionalAsset implements ViewModel
{
    use ArrayFromProperties;
    use ComposedAssets;
    use ReadOnlyArrayAccess;

    private $assetId;
    private $headingPart1;
    private $headingPart2;
    private $nonDoiLink;
    private $doi;
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

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/additional-asset.mustache';
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/additional-asset.css';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->doi;
    }
}

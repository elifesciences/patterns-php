<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromNullProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\ViewModel;
use Traversable;

final class AdditionalAssets implements ViewModel
{
    use ArrayFromNullProperties;
    use ComposedAssets;
    use ReadOnlyArrayAccess;

    private $heading;
    private $data;

    public function __construct(
        string $heading,
        array $data
    ) {
        Assertion::notBlank($heading);
        Assertion::notEmpty($data);
        Assertion::allIsInstanceOf($data, AdditionalAssetData::class);

        $this->heading = $heading;
        $this->data = $data;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/additional-assets.mustache';
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/additional-assets.css';
    }

    protected function getComposedViewModels() : Traversable
    {
        foreach ($this->data as $assetData) {
            yield $assetData['doi'];
        }
    }
}

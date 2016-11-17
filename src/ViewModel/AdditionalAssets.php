<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\ViewModel;
use Traversable;

final class AdditionalAssets implements ViewModel
{
    use ArrayFromProperties;
    use ComposedAssets;
    use ReadOnlyArrayAccess;

    private $heading;
    private $assets;

    public function __construct(
        string $heading = null,
        array $assets
    ) {
        Assertion::notEmpty($assets);
        Assertion::allIsInstanceOf($assets, AdditionalAsset::class);

        $this->heading = $heading;
        $this->assets = $assets;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/additional-assets.mustache';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield from $this->assets;
    }
}

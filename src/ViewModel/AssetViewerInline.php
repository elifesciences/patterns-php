<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class AssetViewerInline implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $id;
    private $variant;
    private $isSupplement;
    private $supplementOrdinal;
    private $parentId;
    private $label;
    private $figuresPageFragLink;
    private $captionedAsset;
    private $additionalAssets;

    private function __construct(
        string $id,
        int $supplementOrdinal = null,
        string $parentId = null,
        string $label,
        CaptionedAsset $captionedAsset,
        array $additionalAssets = []
    ) {
        Assertion::notBlank($id);
        Assertion::nullOrMin($supplementOrdinal, 1);
        Assertion::nullOrNotBlank($parentId);
        Assertion::notBlank($label);
        Assertion::allIsInstanceOf($additionalAssets, AdditionalAsset::class);

        $this->id = $id;
        if ($supplementOrdinal) {
            $this->isSupplement = true;
            $this->variant = 'supplement';
        } elseif ($captionedAsset['image']) {
            $this->variant = 'figure';
        } elseif ($captionedAsset['video']) {
            $this->variant = 'video';
        } elseif ($captionedAsset['table']) {
            $this->variant = 'table';
        }
        $this->supplementOrdinal = $supplementOrdinal;
        $this->parentId = $parentId;
        $this->label = $label;
        $this->figuresPageFragLink = '#'.$id;
        $this->captionedAsset = $captionedAsset;
        if (!empty($additionalAssets)) {
            $this->additionalAssets = [new AdditionalAssets(null, $additionalAssets)];
        } else {
            $this->additionalAssets = [];
        }
    }

    public static function primary(
        string $id,
        string $label,
        CaptionedAsset $captionedAsset,
        array $additionalAssets = []
    ) : AssetViewerInline {
        return new self($id, null, null, $label, $captionedAsset, $additionalAssets);
    }

    public static function supplement(
        string $id,
        int $ordinal,
        string $parentId,
        string $label,
        CaptionedAsset $captionedAsset,
        array $additionalAssets = []
    ) : AssetViewerInline {
        return new self($id, $ordinal, $parentId, $label, $captionedAsset, $additionalAssets);
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield 'resources/assets/css/asset-viewer-inline.css';
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/asset-viewer-inline.mustache';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->captionedAsset;
        yield from $this->additionalAssets;
    }
}

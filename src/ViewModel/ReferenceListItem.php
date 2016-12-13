<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\HasAssets;
use Traversable;

final class ReferenceListItem implements CastsToArray, HasAssets
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $bibId;
    private $reference;

    public function __construct(string $id, int $ordinal, Reference $reference)
    {
        Assertion::notBlank($id);
        Assertion::min($ordinal, 1);

        $this->bibId = [
            'full' => $id,
            'ordinal' => $ordinal,
        ];
        $this->reference = $reference;
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->reference;
    }
}

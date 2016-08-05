<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class ReferenceListItem implements CastsToArray
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $bibId;
    private $reference;

    public function __construct(string $id, int $ordinal, Reference $reference)
    {
        Assertion::notBlank($id);
        Assertion::true($ordinal > 0);

        $this->bibId = [
            'full' => $id,
            'ordinal' => $ordinal,
        ];
        $this->reference = $reference;
    }
}

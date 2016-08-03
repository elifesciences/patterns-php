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

    public function __construct(string $full_id, int $ordinal_id, Reference $reference)
    {
        Assertion::notBlank($full_id);

        $this->bibId = [
            'full' => $full_id,
            'ordinal' => $ordinal_id,
        ];
        $this->reference = $reference;
    }
}

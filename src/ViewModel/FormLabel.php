<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class FormLabel implements CastsToArray
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $labelText;
    private $for;
    private $isVisuallyHidden;

    public function __construct(string $labelText, string $for, bool $isVisuallyHidden = false)
    {
        $this->labelText = $labelText;
        $this->for = $for;
        $this->isVisuallyHidden = $isVisuallyHidden;
    }
}

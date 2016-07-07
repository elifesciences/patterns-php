<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class SelectLabel implements CastsToArray
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $labelText;
    private $isVisuallyHidden;

    public function __construct($labelText, $isVisuallyHidden = false)
    {
        $this->labelText = $labelText;
        $this->isVisuallyHidden = $isVisuallyHidden;
    }
}

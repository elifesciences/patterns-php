<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class ClientError implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $button;

    public function __construct(Button $button = null)
    {
        $this->button = $button;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/client-error.mustache';
    }
}

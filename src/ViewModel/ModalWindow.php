<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class ModalWindow implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $smallDeviceOnly;
    private $title;
    private $closeBtnText;
    private $body;

    private function __construct(bool $smallDeviceOnly, string $title, string $body, string $closeBtnText = null)
    {
        Assertion::notBlank($title);
        Assertion::notBlank($body);
        Assertion::nullOrNotBlank($closeBtnText);

        $this->smallDeviceOnly = $smallDeviceOnly;
        $this->title = $title;
        $this->body = $body;
        $this->closeBtnText = $closeBtnText;
    }

    public static function main(string $title, string $body, string $closeBtnText = null) : ModalWindow
    {
        return new self(false, $title, $body, $closeBtnText);
    }

    public static function small(string $title, string $body, string $closeBtnText = null) : ModalWindow
    {
        return new self(true, $title, $body, $closeBtnText);
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/modal-window.mustache';
    }
}

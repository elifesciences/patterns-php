<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class FormFieldInfoLink implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $name;
    private $url;
    private $alignLeft;

    private function __construct(
        string $name,
        string $url,
        bool $alignLeft = false
    ) {
        Assertion::notBlank($name);
        Assertion::notBlank($url);

        $this->name = $name;
        $this->url = $url;
        if ($alignLeft) {
            $this->alignLeft = $alignLeft;
        }
    }

    public static function alignedLeft(string $name, string $url) : FormFieldInfoLink
    {
        return new static($name, $url, true);
    }

    public static function alignedRight(string $text, string $url) : FormFieldInfoLink
    {
        return new static($text, $url);
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield 'resources/assets/css/form-field-info-link.css';
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/form-field-info-link.mustache';
    }
}

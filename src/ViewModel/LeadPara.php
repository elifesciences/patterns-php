<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class LeadPara implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    protected $text;

    public function __construct(string $text)
    {
        Assertion::notBlank($text);

        $this->text = $text;
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/lead-para.css';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/lead-para.mustache';
    }
}

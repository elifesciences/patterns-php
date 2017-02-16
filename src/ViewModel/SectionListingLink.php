<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class SectionListingLink implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $text;
    private $targetFragmentId;

    public function __construct(string $text, string $targetFragmentId)
    {
        Assertion::notBlank($text);
        Assertion::notBlank($targetFragmentId);

        $this->text = $text;
        $this->targetFragmentId = $targetFragmentId;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/section-listing-link.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/section-listing-link.css';
    }
}

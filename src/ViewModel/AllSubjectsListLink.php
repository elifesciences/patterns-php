<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class AllSubjectsListLink implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $targetFragmentId;

    public function __construct(string $targetFragmentId)
    {
        Assertion::notBlank($targetFragmentId);

        $this->targetFragmentId = $targetFragmentId;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/all-subjects-list-link.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/all-subjects-list-link.css';
    }
}

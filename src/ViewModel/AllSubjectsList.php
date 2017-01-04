<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class AllSubjectsList implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $subjects;
    private $labelledBy;

    public function __construct(array $subjects, string $labelledBy = null)
    {
        Assertion::allIsInstanceOf($subjects, Link::class);
        Assertion::notEmpty($subjects);

        $this->subjects = $subjects;
        $this->labelledBy = $labelledBy;
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/all-subjects-list.css';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/all-subjects-list.mustache';
    }
}

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

    public function __construct(Link ...$subjects)
    {
        Assertion::notEmpty($subjects);

        $this->subjects = $subjects;
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

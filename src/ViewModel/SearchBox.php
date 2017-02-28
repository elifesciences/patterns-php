<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class SearchBox implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $compactForm;
    private $subjectFilter;

    public function __construct(CompactForm $compactForm, SubjectFilter $subjectFilter = null)
    {
        $this->compactForm = $compactForm;
        $this->subjectFilter = $subjectFilter;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/search-box.mustache';
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/search-box.css';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->compactForm;
    }
}

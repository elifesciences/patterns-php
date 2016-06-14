<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class SearchBox implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

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

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/search-box.css';
        yield $this->compactForm->getStyleSheets();
    }
}

<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class ContentAside implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $status;
    private $actionButtons;
    private $metrics;
    private $timeline;
    private $related;

    public function __construct(
        ContentAsideStatus $status = null,
        ButtonCollection $actionButtons = null,
        ContextualData $metrics = null,
        DefinitionList $timeline = null,
        ListingTeasers $related = null
    ) {
        $this->status = $status;
        $this->actionButtons = $actionButtons;
        $this->metrics = $metrics;
        $this->timeline = $timeline;
        $this->related = $related;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/content-aside.mustache';
    }
}

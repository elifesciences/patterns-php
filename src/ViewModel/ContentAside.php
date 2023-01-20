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
    private $contextualData;
    private $timeline;
    private $related;

    public function __construct(
        ContentAsideStatus $status,
        ButtonCollection $actionButtons = null,
        ContextualData $contextualData = null,
        DefinitionList $timeline = null,
        ListingTeasers $related = null
    ) {
        $this->status = $status;
        $this->actionButtons = $actionButtons;
        $this->contextualData = $contextualData;
        $this->timeline = $timeline;
        $this->related = $related;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/content-aside.mustache';
    }
}

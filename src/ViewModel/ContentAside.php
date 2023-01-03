<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
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

    public function __construct(
        string $title,
        string $description = null,
        Link $link = null,
        ButtonCollection $actionButtons = null,
        ContextualData $contextualData = null,
        DefinitionList $timeline = null
    ) {
        Assertion::notBlank($title);

        $this->status['title'] = $title;
        if ($description) {
            $this->status['description'] = $description;
        }

        if ($link) {
            $this->status['link'] = $link['name'];
            $this->status['url'] = $link['url'];
        }

        $this->actionButtons = $actionButtons;
        $this->contextualData = $contextualData;
        $this->timeline = $timeline;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/content-aside.mustache';
    }
}

<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

class LinkCard implements CastsToArray
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    /**
     * @var string
     */
    private $text;
    /**
     * @var Link
     */
    private $link;

    public function __construct(Link $link, string $text)
    {
        $this->text = $text;
        $this->link = $link;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/link-card.mustache';
    }
}
<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class LinkCard implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    /**
     * @var string
     */
    private $body;
    /**
     * @var Link
     */
    private $link;

    public function __construct(Link $link, string $body)
    {
        Assertion::notBlank($body);

        $this->body = $body;
        $this->link = $link;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/link-card.mustache';
    }
}
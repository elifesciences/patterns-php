<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class LinkCardCollection implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $linkCards;

    public function __construct(array $linkCards)
    {
        Assertion::notEmpty($linkCards);
        Assertion::allIsInstanceOf($linkCards, LinkCard::class);

        $this->linkCards = $linkCards;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/link-card-collection.mustache';
    }
}

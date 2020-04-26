<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class Tweet implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $url;
    private $accountId;
    private $accountLabel;
    private $text;
    private $date;
    private $hideConversaion;
    private $hideCards;

    public function __construct(string $url, string $accountId, string $accountLabel, array $text, Date $date, bool $hideConversaion = false, bool $hideCards = false)
    {
        Assertion::notBlank($url);
        Assertion::notBlank($accountId);
        Assertion::notBlank($accountLabel);
        Assertion::notEmpty($text);
        Assertion::allIsInstanceOf($text, Paragraph::class);
        if ($date instanceof Date) {
            Assertion::false($date['isExpanded']);
        }

        $this->url = $url;
        $this->accountId = $accountId;
        $this->accountLabel = $accountLabel;
        $this->text = $text;
        $this->date = $date;
        $this->hideConversaion = $hideConversaion;
        $this->hideCards = $hideCards;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/tweet.mustache';
    }
}

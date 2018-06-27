<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class PersonalisedCoverDownload implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $text;
    private $buttonCollection;

    public function __construct(array $text, ButtonCollection $buttonCollection)
    {
        Assertion::notEmpty($text);
        Assertion::allIsInstanceOf($text, Paragraph::class);

        if (!$buttonCollection['centered']) {
            $buttonCollection = FlexibleViewModel::fromViewModel($buttonCollection)
                ->withProperty('centered', true);
        }

        $this->text = $text;
        $this->buttonCollection = $buttonCollection;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/personalised-cover-download.mustache';
    }
}

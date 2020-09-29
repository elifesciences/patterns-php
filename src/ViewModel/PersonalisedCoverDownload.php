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
    private $picture;
    private $a4ListHeading;
    private $a4ButtonCollection;
    private $letterListHeading;
    private $letterButtonCollection;

    public function __construct(array $text, Picture $picture, ListHeading $a4ListHeading, ButtonCollection $a4ButtonCollection, ListHeading $letterListHeading, ButtonCollection $letterButtonCollection)
    {
        Assertion::notEmpty($text);
        Assertion::allIsInstanceOf($text, Paragraph::class);

        if (!$a4ButtonCollection['centered']) {
            $a4ButtonCollection = FlexibleViewModel::fromViewModel($a4ButtonCollection)
                ->withProperty('centered', true);
        }

        if (!$letterButtonCollection['centered']) {
            $letterButtonCollection = FlexibleViewModel::fromViewModel($letterButtonCollection)
                ->withProperty('centered', true);
        }

        $a4ButtonCollection = FlexibleViewModel::fromViewModel($a4ButtonCollection)
            ->withProperty('classes', 'button-collection--a4');

        $letterButtonCollection = FlexibleViewModel::fromViewModel($letterButtonCollection)
            ->withProperty('classes', 'button-collection--letter');

        $this->text = $text;
        $this->picture = $picture;
        $this->a4ListHeading = $a4ListHeading;
        $this->a4ButtonCollection = $a4ButtonCollection;
        $this->letterListHeading = $letterListHeading;
        $this->letterButtonCollection = $letterButtonCollection;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/personalised-cover-download.mustache';
    }
}

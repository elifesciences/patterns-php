<?php

namespace eLife\Patterns\ViewModel;


use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;

class DecisionLetterProfile implements ViewModel
{

    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $mainText;
    private $profileSnippet;

    public function __construct(string $mainText, ProfileSnippet $profileSnippet)
    {
        Assertion::notBlank($mainText);

        $this->profileSnippet = $profileSnippet;
        $this->mainText = $mainText;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/decision-letter-profile.mustache';
    }
}

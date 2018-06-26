<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class DecisionLetterHeader implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $mainText;
    private $hasProfiles;
    private $profiles;

    public function __construct(string $mainText, array $profiles = [])
    {
        Assertion::notBlank($mainText);
        Assertion::allIsInstanceOf($profiles, ProfileSnippet::class);

        $this->hasProfiles = !empty($profiles) ? true : null;
        $this->profiles = $profiles;

        $this->mainText = $mainText;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/decision-letter-header.mustache';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield from $this->profiles;
    }
}

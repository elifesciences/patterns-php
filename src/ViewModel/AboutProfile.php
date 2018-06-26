<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;

final class AboutProfile implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $name;
    private $role;
    private $image;
    private $profile;

    public function __construct(string $name, string $role = null, Picture $image = null, string $profile = null)
    {
        Assertion::notBlank($name);

        $this->name = $name;
        $this->role = $role;
        $this->image = $image;
        $this->profile = $profile;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/about-profile.mustache';
    }
}

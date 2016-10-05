<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class MediaSourceFallback implements CastsToArray
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $content;
    private $isExternal;
    private $classes;

    public function __construct(string $content, bool $isExternal = false, $classes = [])
    {
        Assertion::notBlank($content);

        $this->content = $content;
        $this->isExternal = $isExternal;
        $this->classes = implode(' ', $classes);
    }
}

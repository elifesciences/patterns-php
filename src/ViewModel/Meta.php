<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class Meta implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $type;
    private $date;
    private $typeLink;

    public function __construct(string $type, Date $date, string $typeLink = null)
    {
        Assertion::notBlank($type);
        Assertion::false(is_array($date['forHuman']));

        $this->type = $type;
        $this->date = $date;
        $this->typeLink = $typeLink;
    }

    public function getStyleSheets() : Traversable
    {
        yield $this->date->getStyleSheets();
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/meta.mustache';
    }
}

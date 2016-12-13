<?php

namespace eLife\Patterns\ViewModel;

use DateTimeImmutable;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class Date implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $isExpanded;
    private $forHuman;
    private $forMachine;

    public function __construct(DateTimeImmutable $date, bool $isExpanded = false)
    {
        $this->isExpanded = $isExpanded;
        $this->forHuman = [
            'dayOfMonth' => (int) $date->format('j'),
            'month' => $date->format('M'),
            'year' => (int) $date->format('Y'),
        ];
        $this->forMachine = $date->format('Y-m-d');
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/date.css';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/date.mustache';
    }
}

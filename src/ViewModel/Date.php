<?php

namespace eLife\Patterns\ViewModel;

use DateTimeImmutable;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class Date implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $forHuman;
    private $forMachine;

    public function __construct(DateTimeImmutable $date, bool $isExpanded = false)
    {
        if ($isExpanded) {
            $this->forHuman = [
                'dayOfMonth' => ltrim($date->format('d'), '0'),
                'month' => $date->format('M'),
                'year' => $date->format('Y'),
            ];
        } else {
            $this->forHuman = $date->format('M j, Y');
        }
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

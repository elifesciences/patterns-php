<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class InfoBar implements ViewModel
{
    const TYPE_ATTENTION = 'attention';
    const TYPE_INFO = 'info';
    const TYPE_SUCCESS = 'success';

    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $text;
    private $type;

    public function __construct(string $text, string $type = self::TYPE_INFO)
    {
        Assertion::notBlank($text);
        Assertion::choice($type, [self::TYPE_ATTENTION, self::TYPE_INFO, self::TYPE_SUCCESS]);

        $this->text = $text;
        $this->type = $type;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/info-bar.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/info-bars.css';
    }
}

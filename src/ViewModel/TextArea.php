<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class TextArea implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $label;
    private $name;
    private $id;
    private $value;

    public function __construct(
        FormLabel $label,
        string $id,
        string $name,
        string $value = null
    ) {
        Assertion::same($id, $label['for']);

        $this->label = $label;
        $this->name = $name;
        $this->id = $id;
        $this->value = $value;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/text-area.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/text-fields.css';
    }
}

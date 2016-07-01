<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class LeadParas implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    /** @var LeadPara[] */
    protected $paras;

    public function __construct($leadParas)
    {
        Assertion::notEmpty($leadParas);
        Assertion::allIsInstanceOf($leadParas, LeadPara::class);

        $this->paras = $leadParas;
    }

    public function getStyleSheets() : Traversable
    {
        yield $this->paras[0]->getStyleSheets();
        yield '/elife/patterns/assets/css/lead-paras.css';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/lead-paras.mustache';
    }
}

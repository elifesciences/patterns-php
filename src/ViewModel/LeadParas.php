<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class LeadParas implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use ComposedAssets;

    protected $paras;

    /**
     * @param $leadParas LeadPara[]
     */
    public function __construct(array $leadParas)
    {
        Assertion::notEmpty($leadParas);
        Assertion::allIsInstanceOf($leadParas, LeadPara::class);

        $this->paras = $leadParas;
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/lead-paras.css';
    }


    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/lead-paras.mustache';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield from $this->paras;
    }
}

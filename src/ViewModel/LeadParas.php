<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class LeadParas implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
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

    public function getTemplateName() : string
    {
        return 'resources/templates/lead-paras.mustache';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield from $this->paras;
    }
}

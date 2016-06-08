<?php

namespace tests\eLife\Patterns;

use Puli\Repository\Api\ResourceRepository;

trait PuliAwareTestCase
{
    /**
     * @var ResourceRepository
     */
    protected $puli;

    /**
     * @before
     */
    final public function setUpPuli()
    {
        $factoryClass = PULI_FACTORY_CLASS;
        $factory = new $factoryClass();

        $this->puli = $factory->createRepository();
    }
}

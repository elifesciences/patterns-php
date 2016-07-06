<?php

namespace tests\eLife\Patterns\ViewModel;


use eLife\Patterns\ViewModel\Doi;

final class DoiTest extends ViewModelTest
{

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = array (
            'uri' => 'http://dx.doi.org/10.7554/eLife.10181.001',
            'classNames' => 'class1 class2',
        );
        $doi = new Doi($data['uri'], explode(' ', $data['classNames']));

        $this->assertSame($data['uri'], $doi['uri']);
        $this->assertSame($data['classNames'], $doi['classNames']);
        $this->assertSame($data, $doi->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'with class names' => [ new Doi('http://dx.doi.org/10.7554/eLife.10181.001', ['class1', 'class2']) ],
            'without class names' => [ new Doi('http://dx.doi.org/10.7554/eLife.10181.001') ]
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/doi.mustache';
    }
}

<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Pager;

final class PagerTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'previousPage' => [
                'classes' => 'button--default',
                'path' => 'previous-url',
                'text' => 'previous',
            ],
            'nextPage' => [
                'classes' => 'button--default',
                'path' => 'next-url',
                'text' => 'next',
            ],
        ];

        $pager = new Pager(new Link('previous', 'previous-url'), new Link('next', 'next-url'));

        $this->assertSame($data['previousPage'], $pager['previousPage']->toArray());
        $this->assertSame($data['nextPage'], $pager['nextPage']->toArray());
        $this->assertSame($data, $pager->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'both' => [new Pager(new Link('previous', 'previous-url'), new Link('next', 'next-url'))],
            'previous only' => [new Pager(new Link('previous', 'previous-url'))],
            'next only' => [new Pager(null, new Link('next', 'next-url'))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/pager.mustache';
    }
}

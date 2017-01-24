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
            'nextPage' => [
                'classes' => 'button--default button--full',
                'path' => 'next-url',
                'text' => 'next',
            ],
            'targetId' => 'targetId',
        ];

        $pager = Pager::firstPage(new Link('next', 'next-url'), 'targetId');

        $this->assertSame($data['nextPage'], $pager['nextPage']->toArray());
        $this->assertSame($data['targetId'], $pager['targetId']);
        $this->assertSame($data, $pager->toArray());

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
            'targetId' => 'targetId',
        ];

        $pager = Pager::subsequentPage(new Link('previous', 'previous-url'), new Link('next', 'next-url'), 'targetId');

        $this->assertSame($data['previousPage'], $pager['previousPage']->toArray());
        $this->assertSame($data['nextPage'], $pager['nextPage']->toArray());
        $this->assertSame($data['targetId'], $pager['targetId']);
        $this->assertSame($data, $pager->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'both' => [Pager::subsequentPage(new Link('previous', 'previous-url'), new Link('next', 'next-url')), 'targetId'],
            'previous only' => [Pager::subsequentPage(new Link('previous', 'previous-url'))],
            'next only' => [Pager::firstPage(new Link('next', 'next-url'))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/pager.mustache';
    }
}

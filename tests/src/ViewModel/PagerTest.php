<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\LoadMore;
use eLife\Patterns\ViewModel\Pager;
use InvalidArgumentException;
use Traversable;

final class PagerTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'previousPage' => [
                'name' => 'previous',
                'url' => 'previous-url',
            ],
            'nextPage' => [
                'name' => 'next',
                'url' => 'next-url',
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
            'active' => [new Pager(new Link('previous', 'previous-url'), new Link('next', 'next-url'))],
            'inactive' => [new Pager(new Link('previous'), new Link('next'))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/pager.mustache';
    }
}

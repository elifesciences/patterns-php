<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\LoadMore;
use InvalidArgumentException;
use Traversable;

final class LoadMoreTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'name' => 'name',
            'url' => 'url',
        ];

        $button = new LoadMore(new Link('name', 'url'));

        $this->assertSame($data['name'], $button['name']);
        $this->assertSame($data['url'], $button['url']);
        $this->assertSame($data, $button->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [new LoadMore(new Link('name', 'url'))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/load-more.mustache';
    }
}

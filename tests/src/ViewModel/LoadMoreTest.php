<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\LoadMore;

final class LoadMoreTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'classes' => 'button--default button--full',
            'path' => 'url',
            'text' => 'name',
        ];
        $button = new LoadMore(new Link('name', 'url'));
        $this->assertSame($data['classes'], $button['classes']);
        $this->assertSame($data['path'], $button['path']);
        $this->assertSame($data['text'], $button['text']);
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

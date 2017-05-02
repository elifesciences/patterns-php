<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ContentHeaderReadMore;
use eLife\Patterns\ViewModel\ReadMoreItem;

final class ReadMoreItemTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'item' => [
                'title' => 'some title',
                'url' => '#',
            ],
            'content' => '<p>Some content</p>',
        ];

        $model = new ReadMoreItem(new ContentHeaderReadMore($data['item']['title'], $data['item']['url']), $data['content']);

        $this->assertSameWithoutOrder($data, $model->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'Read more item without content' => [
                new ReadMoreItem(new ContentHeaderReadMore('some title', '#')),
            ],
            'Read more item with content' => [
                new ReadMoreItem(new ContentHeaderReadMore('some title', '#'), '<p>Some content</p>'),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/read-more-item.mustache';
    }
}

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
                    'behaviour' => 'ContentHeaderArticle',
                    'title' => 'some title',
                    'titleClass' => 'content-header__title--large',
                ],
            'content' => '<p>Some content</p>',
        ];

        $model = new ReadMoreItem(new ContentHeaderReadMore($data['item']['title'], '#'), $data['content']);

        $this->assertSameWithoutOrder($data, $model->toArray());
    }

    public function viewModelProvider(): array
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

    protected function expectedTemplate(): string
    {
        return '/elife/patterns/templates/read-more-item.mustache';
    }
}

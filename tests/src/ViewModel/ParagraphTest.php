<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Paragraph;

final class ParagraphTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'text' => 'some text',
        ];
        $paragraph = new Paragraph($data['text']);

        $this->assertSame($data['text'], $paragraph['text']);
        $this->assertSame($data, $paragraph->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [new Paragraph('some text')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/paragraph.mustache';
    }
}

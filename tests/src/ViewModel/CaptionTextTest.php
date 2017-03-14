<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\CaptionText;
use InvalidArgumentException;

final class CaptionTextTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'heading' => 'heading',
            'standfirst' => 'standfirst',
            'text' => 'text',
        ];

        $captionText = new CaptionText(...array_values($data));

        $this->assertSame($data['heading'], $captionText['heading']);
        $this->assertSame($data['standfirst'], $captionText['standfirst']);
        $this->assertSame($data['text'], $captionText['text']);
        $this->assertSame($data, $captionText->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_a_heading()
    {
        $this->expectException(InvalidArgumentException::class);

        new CaptionText('');
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [new CaptionText('heading')],
            'complete' => [new CaptionText('heading', 'stand first', 'text')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/caption-text.mustache';
    }
}

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

        $captionText = CaptionText::withHeading(...array_values($data));

        $this->assertSame($data['heading'], $captionText['heading']);
        $this->assertSame($data['standfirst'], $captionText['standfirst']);
        $this->assertSame($data['text'], $captionText['text']);
        $this->assertSame($data, $captionText->toArray());

        $data = [
            'standfirst' => 'standfirst',
            'text' => 'text',
        ];

        $captionText = CaptionText::withOutHeading($data['text'], $data['standfirst']);

        $this->assertSame($data['text'], $captionText['text']);
        $this->assertSame($data['standfirst'], $captionText['standfirst']);
        $this->assertSame($data, $captionText->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_a_heading()
    {
        $this->expectException(InvalidArgumentException::class);

        CaptionText::withHeading('');
    }

    /**
     * @test
     */
    public function it_must_have_text()
    {
        $this->expectException(InvalidArgumentException::class);

        CaptionText::withOutHeading('');
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum with heading' => [CaptionText::withHeading('heading')],
            'complete with heading' => [CaptionText::withHeading('heading', 'stand first', 'text')],
            'minimum without heading' => [CaptionText::withOutHeading('text')],
            'complete without heading' => [CaptionText::withOutHeading('text', 'stand first')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/caption-text.mustache';
    }
}

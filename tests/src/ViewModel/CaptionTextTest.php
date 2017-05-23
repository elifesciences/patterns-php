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

        $captionText = CaptionText::withStandFirst($data['standfirst'], $data['text']);

        $this->assertSame($data['standfirst'], $captionText['standfirst']);
        $this->assertSame($data['text'], $captionText['text']);
        $this->assertSame($data, $captionText->toArray());

        $data = [
            'text' => 'text',
        ];

        $captionText = CaptionText::withText($data['text']);

        $this->assertSame($data['text'], $captionText['text']);
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
    public function it_must_have_a_standfirst()
    {
        $this->expectException(InvalidArgumentException::class);

        CaptionText::withStandFirst('');
    }

    /**
     * @test
     */
    public function it_must_have_text()
    {
        $this->expectException(InvalidArgumentException::class);

        CaptionText::withText('');
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum with heading' => [CaptionText::withHeading('heading')],
            'complete with heading' => [CaptionText::withHeading('heading', 'stand first', 'text')],
            'minimum with stand first' => [CaptionText::withStandFirst('stand first')],
            'complete with stand first' => [CaptionText::withStandFirst('stand first', 'text')],
            'with text' => [CaptionText::withText('text')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/caption-text.mustache';
    }
}

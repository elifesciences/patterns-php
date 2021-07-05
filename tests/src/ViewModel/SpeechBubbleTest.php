<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\SpeechBubble;

final class SpeechBubbleTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'text' => '<span aria-hidden="true"><span data-visible-annotation-count>+</span></span><span class="visuallyhidden"> Open annotations. The current annotation count on this page is <span data-hypothesis-annotation-count>being calculated</span>.</span>',
            'isWrapped' => true,
            'prefix' => 'Add a comment',
            'hasPlaceholder' => true,
            'behaviour' => 'HypothesisOpener',
        ];

        $hypothesisOpener = SpeechBubble::forArticleBody();
        $this->assertSame($data['text'], $hypothesisOpener['text']);
        $this->assertSame($data['isWrapped'], $hypothesisOpener['isWrapped']);
        $this->assertSame($data['prefix'], $hypothesisOpener['prefix']);
        $this->assertSame($data['hasPlaceholder'], $hypothesisOpener['hasPlaceholder']);
        $this->assertSame($data['behaviour'], $hypothesisOpener['behaviour']);
        $this->assertSame($data, $hypothesisOpener->toArray());

        $data = [
            'text' => '<span aria-hidden="true"><span data-visible-annotation-count></span></span><span class="visuallyhidden"> Open annotations. The current annotation count on this page is <span data-hypothesis-annotation-count>being calculated</span>.</span>',
            'isSmall' => true,
            'behaviour' => 'HypothesisOpener',
        ];

        $hypothesisOpener = SpeechBubble::forContextualData();
        $this->assertSame($data['text'], $hypothesisOpener['text']);
        $this->assertSame($data['isSmall'], $hypothesisOpener['isSmall']);
        $this->assertSame($data['behaviour'], $hypothesisOpener['behaviour']);
        $this->assertSame($data, $hypothesisOpener->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'for article body' => [SpeechBubble::forArticleBody()],
            'for contextual data' => [SpeechBubble::forContextualData()],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/speech-bubble.mustache';
    }
}

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
            'text' => '<span aria-hidden="true"><span data-visible-annotation-count>&#8220;</span> </span><span class="visuallyhidden">Open annotations (there are currently <span data-hypothesis-annotation-count>0</span> annotations on this page). </span>',
            'hasPlaceholder' => true,
            'behaviour' => 'HypothesisOpener',
        ];

        $hypothesisOpener = SpeechBubble::forArticleBody();
        $this->assertSame($data['text'], $hypothesisOpener['text']);
        $this->assertSame($data['hasPlaceholder'], $hypothesisOpener['hasPlaceholder']);
        $this->assertSame($data['behaviour'], $hypothesisOpener['behaviour']);
        $this->assertSame($data, $hypothesisOpener->toArray());

        $data = [
            'text' => '<span aria-hidden="true"><span data-visible-annotation-count>0</span> </span><span class="visuallyhidden">Open annotations (there are currently <span data-hypothesis-annotation-count>0</span> annotations on this page). </span>',
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

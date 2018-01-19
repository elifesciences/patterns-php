<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\HypothesisOpener;

final class HypothesisOpenerTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'button' => [
                'text' => '<span aria-hidden="true"><span data-visible-annotation-count>&#8220;</span> </span><span class="visuallyhidden">Open annotations (there are currently <span data-hypothesis-annotation-count>0</span> annotations on this page). </span>',
                'type' => 'button',
            ],
        ];

        $hypothesisAffordance = HypothesisOpener::forArticleBody();
        $this->assertSameWithoutOrder($data, $hypothesisAffordance->toArray());
    }

    /**
     * @test
     */
    public function for_contextual_data_shows_zero_when_no_annotations()
    {
        $data = [
            'button' => [
                'text' => '<span aria-hidden="true"><span data-visible-annotation-count>0</span> </span><span class="visuallyhidden">Open annotations (there are currently <span data-hypothesis-annotation-count>0</span> annotations on this page). </span>',
                'type' => 'button',
            ],
        ];

        $hypothesisOpener = HypothesisOpener::forContextualData();
        $this->assertSameWithoutOrder($data, $hypothesisOpener->toArray());
    }

    /**
     * @test
     */
    public function for_article_body_shows_double_quote_when_no_annotations()
    {
        $data = [
            'button' => [
                'text' => '<span aria-hidden="true"><span data-visible-annotation-count>&#8220;</span> </span><span class="visuallyhidden">Open annotations (there are currently <span data-hypothesis-annotation-count>0</span> annotations on this page). </span>',
                'type' => 'button',
            ],
        ];

        $hypothesisOpener = HypothesisOpener::forArticleBody();
        $this->assertSameWithoutOrder($data, $hypothesisOpener->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'for article body' => [HypothesisOpener::forArticleBody()],
            'for contextual data' => [HypothesisOpener::forContextualData()],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/hypothesis-opener.mustache';
    }
}

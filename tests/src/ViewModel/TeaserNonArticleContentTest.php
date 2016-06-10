<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Date;
use DateTimeImmutable;
use eLife\Patterns\ViewModel\TeaserNonArticleContent;

final class TeaserNonArticleContentTest extends ViewModelTest
{

    /**
     * @test
     */
    public function it_has_data()
    {
        $link = 'linklinklink';
        $viewModel = new TeaserNonArticleContent('hello, i am the content', new Date(new DateTimeImmutable()), '', $link);
        $this->assertSame($link, $viewModel['link']);
    }

    public function viewModelProvider() : array
    {
        return [
          'complete' => [new TeaserNonArticleContent('hello, i am the content', new Date(new DateTimeImmutable()), 'HEADER TEXT!', 'linklinklink')],
//      'missing header' => [new TeaserNonArticleContent('hello, i am the content', new Date(new DateTimeImmutable()), '', 'linklinklink')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/teaser--non-article-content.mustache';
    }
}

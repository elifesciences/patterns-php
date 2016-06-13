<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Date;
use DateTimeImmutable;
use eLife\Patterns\ViewModel\TeaserNonArticleContent;
use LengthException;

final class TeaserNonArticleContentTest extends ViewModelTest
{

    /**
     * @test
     */
    public function it_must_have_headerText()
    {
        $this->expectException(LengthException::class);
        $this->expectExceptionMessage('$headerText argument must not be an empty string');
        new TeaserNonArticleContent('content', new Date(new DateTimeImmutable()), '', 'link');
    }

    /**
     * @test
     */
    public function it_must_have_a_link()
    {
        $this->expectException(LengthException::class);
        $this->expectExceptionMessage('$link argument must not be an empty string');
        new TeaserNonArticleContent('content', new Date(new DateTimeImmutable()), 'Header text', '');
    }

    /**
     * @test
     */
    public function it_must_have_content()
    {
        $this->expectException(LengthException::class);
        $this->expectExceptionMessage('$content argument must not be an empty string');
        new TeaserNonArticleContent('', new Date(new DateTimeImmutable()), 'Header text', 'link');
    }

    /**
     * @test
     */
    public function a_supplied_subheader_must_not_be_empty()
    {
        $this->expectException(LengthException::class);
        $this->expectExceptionMessage('if supplied, the optional $subHeader argument must not be an empty string');
        new TeaserNonArticleContent('content', new Date(new DateTimeImmutable()), 'Header text', 'link', '');
    }

    /**
     * @test
     */
    public function a_supplied_footertext_must_not_be_empty()
    {
        $this->expectException(LengthException::class);
        $this->expectExceptionMessage('if supplied, the optional $footerText argument must not be an empty string');
        new TeaserNonArticleContent('content', new Date(new DateTimeImmutable()), 'Header text', 'link', 'subheading', '');
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $link = 'linklinklink';
        $content = 'i am the content';
        $headerText = 'Header Text';
        $viewModel = new TeaserNonArticleContent($content, new Date(new DateTimeImmutable()), $headerText, $link);
        $this->assertSame($link, $viewModel['link']);
        $this->assertSame($content, $viewModel['content']);
        $this->assertSame($headerText, $viewModel['headerText']);
    }

    public function viewModelProvider() : array
    {
        return [
          'minimal' => [new TeaserNonArticleContent('i am the content', new Date(new DateTimeImmutable()),
                                                    'HEADER TEXT!', 'linklinklink')],
          'with: subheading' => [new TeaserNonArticleContent('i am the content', new Date(new DateTimeImmutable()),
                                                    'HEADER TEXT!', 'linklinklink', 'subheading', null)],
          'with: footer text' => [new TeaserNonArticleContent('i am the content', new Date(new DateTimeImmutable()),
            'HEADER TEXT!', 'linklinklink', null, 'footer text')],
          'with: footer text, subheading' => [new TeaserNonArticleContent('i am the content', new Date(new DateTimeImmutable()),
            'HEADER TEXT!', 'linklinklink', 'subheading', 'footer text')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/teaser--non-article-content.mustache';
    }
}

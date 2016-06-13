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
    public function it_must_have_headertext()
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
        new TeaserNonArticleContent('content', new Date(new DateTimeImmutable()), 'Header text', 'link', null, '');
    }

    /**
     * @test
     */
    public function a_supplied_downloadsrc_must_not_be_empty()
    {
        $this->expectException(LengthException::class);
        $this->expectExceptionMessage('if supplied, the optional $downloadSrc argument must not be an empty string');
        new TeaserNonArticleContent('content', new Date(new DateTimeImmutable()), 'Header text', 'link', null, null, '');
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $link = 'link';
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
            'Header Text', 'link')],

          'with: subheading' => [new TeaserNonArticleContent('i am the content', new Date(new DateTimeImmutable()),
            'Header Text', 'link', 'subheading', null)],

          'with: footer text' => [new TeaserNonArticleContent('i am the content', new Date(new DateTimeImmutable()),
            'Header Text', 'link', null, 'footer text')],

          'with: download source' => [new TeaserNonArticleContent('i am the content', new Date(new DateTimeImmutable()),
            'Header Text', 'link', null, null, 'download source')],

          'with: subheading, footer text' => [new TeaserNonArticleContent('i am the content',
            new Date(new DateTimeImmutable()), 'Header Text', 'link', 'subheading', 'footer text')],

          'with: subheading, footer text, download source' => [new TeaserNonArticleContent('i am the content',
            new Date(new DateTimeImmutable()), 'Header Text', 'link', 'subheading', 'footer text',
            'download source')],

          'with: subheading, download source' => [new TeaserNonArticleContent('i am the content',
            new Date(new DateTimeImmutable()), 'Header Text', 'link', 'subheading', null, 'download source')],

          'with: footer text, download source' => [new TeaserNonArticleContent('i am the content',
            new Date(new DateTimeImmutable()), 'Header Text', 'link', null, 'footer text', 'download source')],

        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/teaser--non-article-content.mustache';
    }
}

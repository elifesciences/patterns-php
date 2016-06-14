<?php

namespace tests\eLife\Patterns\ViewModel;

use DateTimeImmutable;
use eLife\Patterns\ViewModel\Date;
use eLife\Patterns\ViewModel\TeaserNonArticleContent;
use InvalidArgumentException;

final class TeaserNonArticleContentTest extends ViewModelTest
{
    protected $content;
    protected $date;
    protected $headerText;
    protected $link;
    protected $subHeader;
    protected $footerText;
    protected $downloadSrc;

    protected function setUp()
    {
        $this->content = 'i am the content';
        $this->date = new Date(new DateTimeImmutable());
        $this->headerText = 'Header Text';
        $this->link = 'link';
        $this->subHeader = 'sub header';
        $this->footerText = 'footer text';
        $this->downloadSrc = 'download source';
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $viewModel = new TeaserNonArticleContent($this->content, $this->date, $this->headerText, $this->link,
          $this->subHeader, $this->footerText, $this->downloadSrc);

        $this->assertSame($this->content, $viewModel['content']);
        $this->assertSame($this->date, $viewModel['date']);
        $this->assertSame($this->headerText, $viewModel['headerText']);
        $this->assertSame($this->link, $viewModel['link']);
        $this->assertSame($this->subHeader, $viewModel['subHeader']);
        $this->assertSame($this->footerText, $viewModel['footerText']);
        $this->assertSame($this->downloadSrc, $viewModel['downloadSrc']);
    }

    /**
     * @test
     */
    public function it_must_not_have_empty_content()
    {
        $this->expectException(InvalidArgumentException::class);
        new TeaserNonArticleContent('', $this->date, $this->headerText, $this->link, $this->subHeader,
          $this->footerText, $this->downloadSrc);
    }

    /**
     * @test
     */
    public function it_must_not_have_empty_headertext()
    {
        $this->expectException(InvalidArgumentException::class);
        new TeaserNonArticleContent($this->content, $this->date, '', $this->link, $this->subHeader,
          $this->footerText, $this->downloadSrc);
    }

    /**
     * @test
     */
    public function it_must_not_have_an_empty_link()
    {
        $this->expectException(InvalidArgumentException::class);
        new TeaserNonArticleContent($this->content, $this->date, $this->headerText, '', $this->subHeader,
          $this->footerText, $this->downloadSrc);
    }

    /**
     * @test
     */
    public function it_must_not_have_an_empty_optional_subheader()
    {
        $this->expectException(InvalidArgumentException::class);
        new TeaserNonArticleContent($this->content, $this->date, $this->headerText, $this->link, '',
          $this->footerText, $this->downloadSrc);
    }

    /**
     * @test
     */
    public function it_must_not_have_an_empty_optional_footerText()
    {
        $this->expectException(InvalidArgumentException::class);
        new TeaserNonArticleContent($this->content, $this->date, $this->headerText, $this->link, $this->subHeader,
          '', $this->downloadSrc);
    }

    /**
     * @test
     */
    public function it_must_not_have_an_empty_optional_downloadsrc()
    {
        $this->expectException(InvalidArgumentException::class);
        new TeaserNonArticleContent($this->content, $this->date, $this->headerText, $this->link, $this->subHeader,
          $this->footerText, '');
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

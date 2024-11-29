<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ContentHeaderReadMore;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Meta;
use InvalidArgumentException;
use tests\eLife\Patterns\ViewModel\Partials\MetaFromData;

class ContentHeaderReadMoreTest extends ViewModelTest
{
    use MetaFromData;

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'title' => 'title',
            'url' => 'url',
        ];

        $contentHeader = new ContentHeaderReadMore(
            $data['title'],
            $data['url']
        );

        $this->assertSame($data['title'], $contentHeader['title']);
        $this->assertSame($data['url'], $contentHeader['url']);
        $this->assertSame($data, $contentHeader->toArray());

        $data = [
            'title' => 'titletitletitletitle',
            'longTitle' => true,
            'url' => 'url',
            'hasSubjects' => true,
            'subjects' => [['name' => 'subject', 'url' => false]],
            'authorLine' => 'author line',
            'meta' => [
                'url' => false,
                'text' => 'Research article',
            ],
        ];

        $contentHeader = new ContentHeaderReadMore(
            $data['title'],
            $data['url'],
            array_map(function (array $item) {
                return new Link($item['name']);
            }, $data['subjects']),
            $data['authorLine'],
            Meta::withText($data['meta']['text'])
        );

        $this->assertSame($data['title'], $contentHeader['title']);
        $this->assertSame($data['longTitle'], $contentHeader['longTitle']);
        $this->assertSame($data['url'], $contentHeader['url']);
        $this->assertSame($data['hasSubjects'], $contentHeader['hasSubjects']);
        $this->assertSameWithoutOrder($data['subjects'], $contentHeader['subjects']);
        $this->assertSame($data['authorLine'], $contentHeader['authorLine']);
        $this->assertSameWithoutOrder($data['meta'], $contentHeader['meta']);
        $this->assertSame($data, $contentHeader->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_a_title()
    {
        $this->expectException(InvalidArgumentException::class);

        new ContentHeaderReadMore('', 'url');
    }

    /**
     * @test
     */
    public function it_must_have_a_url()
    {
        $this->expectException(InvalidArgumentException::class);

        new ContentHeaderReadMore('title', '');
    }

    /**
     * @test
     */
    public function subjects_must_be_a_links()
    {
        $this->expectException(InvalidArgumentException::class);

        new ContentHeaderReadMore('title', 'url', ['foo']);
    }

    public function viewModelProvider(): array
    {
        return [
            'minimum' => [new ContentHeaderReadMore('some title', 'url')],
            'full' => [
                new ContentHeaderReadMore('title', 'url', [new Link('subject')], 'author line', Meta::withText('meta')),
            ],
        ];
    }

    protected function expectedTemplate(): string
    {
        return 'resources/templates/content-header-read-more.mustache';
    }
}

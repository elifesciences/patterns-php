<?php

namespace tests\eLife\Patterns\ViewModel;

use DateTimeImmutable;
use eLife\Patterns\ViewModel\Author;
use eLife\Patterns\ViewModel\AuthorList;
use eLife\Patterns\ViewModel\ContentHeaderReadMore;
use eLife\Patterns\ViewModel\Date;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Meta;
use eLife\Patterns\ViewModel\SubjectList;
use tests\eLife\Patterns\ViewModel\Partials\MetaFromData;

class ContentHeaderReadMoreTest extends ViewModelTest
{
    use MetaFromData;

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = ContentHeaderFixtures::readMoreFixture();
        $magazine = new ContentHeaderReadMore(
            $data['title'],
            $data['url'],
            $data['strapline'],
            $data['authorLine'],
            new SubjectList(...array_map(function ($item) {
                return new Link($item['name']);
            }, $data['subjects']['list'])),
            $this->metaFromData($data['meta'])
        );
        $this->assertSameWithoutOrder($data, $magazine->toArray());
    }

    public function viewModelProvider(): array
    {
        return [
            'content header read more with minimum' => [new ContentHeaderReadMore('some title', "#")],
            'content header read more with full' => [
                new ContentHeaderReadMore(
                    'some title',
                    "#",
                    'strap line',
                    'Someone',
                    new SubjectList(new Link('biology')),
                    Meta::withText(
                        'Something meta',
                        Date::simple(new DateTimeImmutable())
                    )
                ),
            ],
        ];
    }

    protected function expectedTemplate(): string
    {
        return '/elife/patterns/templates/content-header-read-more.mustache';
    }
}

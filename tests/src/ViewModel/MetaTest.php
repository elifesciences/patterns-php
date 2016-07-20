<?php

namespace tests\eLife\Patterns\ViewModel;

use DateTimeImmutable;
use eLife\Patterns\ViewModel\Date;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Meta;

final class MetaTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'url' => '#',
            'text' => 'Research article',
            'date' => [
                'isExpanded' => false,
                'forHuman' => [
                    'dayOfMonth' => 15,
                    'month' => 'May',
                    'year' => 2015,
                ],
                'forMachine' => '2015-05-15',
            ],
        ];
        $meta = Meta::withLink(new Link($data['text'], $data['url']), new Date(new DateTimeImmutable('2015-05-15')));

        $this->assertSame($data, $meta->toArray());
        $this->assertSame($data['url'], $meta['url']);
        $this->assertSame($data['text'], $meta['text']);
        $this->assertSame($data['date'], $meta['date']->toArray());
    }

    public static function getDateStub()
    {
        return new Date(new DateTimeImmutable(), false);
    }

    public function viewModelProvider() : array
    {
        return [
            'link' => [Meta::withLink(new Link('foo', '#'), self::getDateStub())],
            'link and date' => [Meta::withLink(new Link('foo', '#'), self::getDateStub())],
            'text' => [Meta::withText('foo', self::getDateStub())],
            'text and date' => [Meta::withText('foo', self::getDateStub())],
            'date' => [Meta::withDate(self::getDateStub())],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/meta.mustache';
    }
}

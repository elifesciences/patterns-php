<?php

namespace tests\eLife\Patterns\ViewModel;

use DateTimeImmutable;
use eLife\Patterns\ViewModel\Date;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\MetaNew;
use InvalidArgumentException;

final class MetaNewTest extends ViewModelTest
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
                'isUpdated' => false,
                'forHuman' => [
                    'dayOfMonth' => 15,
                    'month' => 'May',
                    'year' => 2015,
                ],
                'forMachine' => '2015-05-15',
            ],
        ];
        $meta = MetaNew::withLink(new Link($data['text'], $data['url']), Date::simple(new DateTimeImmutable('2015-05-15')));

        $this->assertSame($data, $meta->toArray());
        $this->assertSame($data['url'], $meta['url']);
        $this->assertSame($data['text'], $meta['text']);
        $this->assertSame($data['date'], $meta['date']->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_an_expanded_date()
    {
        $this->expectException(InvalidArgumentException::class);

        MetaNew::withDate(Date::expanded(new DateTimeImmutable()));
    }

    public static function getDateStub()
    {
        return Date::simple(new DateTimeImmutable());
    }

    public function viewModelProvider() : array
    {
        return [
            'link' => [MetaNew::withLink(new Link('foo', '#'), self::getDateStub())],
            'link and date' => [MetaNew::withLink(new Link('foo', '#'), self::getDateStub())],
            'text' => [MetaNew::withText('foo', self::getDateStub())],
            'text and date' => [MetaNew::withText('foo', self::getDateStub())],
            'date' => [MetaNew::withDate(self::getDateStub())],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/meta-journal.mustache';
    }
}

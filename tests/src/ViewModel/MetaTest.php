<?php

namespace tests\eLife\Patterns\ViewModel;

use DateTimeImmutable;
use eLife\Patterns\ViewModel\Date;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Meta;
use InvalidArgumentException;

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
                'isUpdated' => false,
                'forHuman' => [
                    'dayOfMonth' => 15,
                    'month' => 'May',
                    'year' => 2015,
                ],
                'forMachine' => '2015-05-15',
            ],
            'articleStatus' => 'Not yet revised',
            'articleStatusColorClass' => 'not-revised',
            'version' => 'Reviewed Preprint v1',
        ];
        $meta = Meta::withLink(new Link($data['text'], $data['url']), Date::simple(new DateTimeImmutable('2015-05-15')),
        $data['articleStatus'], $data['articleStatusColorClass'], $data['version']);

        $this->assertSame($data, $meta->toArray());
        $this->assertSame($data['url'], $meta['url']);
        $this->assertSame($data['text'], $meta['text']);
        $this->assertSame($data['date'], $meta['date']->toArray());
        $this->assertSame($data['articleStatus'], $meta['articleStatus']);
        $this->assertSame($data['articleStatusColorClass'], $meta['articleStatusColorClass']);
        $this->assertSame($data['version'], $meta['version']);
    }

    /**
     * @test
     */
    public function it_must_have_an_expanded_date()
    {
        $this->expectException(InvalidArgumentException::class);

        Meta::withDate(Date::expanded(new DateTimeImmutable()));
    }

    /**
     * @test
     */
    public function it_must_have_a_valid_article_status()
    {
        $this->expectException(InvalidArgumentException::class);

        Meta::withLink(new Link('foo', '#'), self::getDateStub(), 'Not valid status', 'revised', 'bar');
    }

    /**
     * @test
     */
    public function it_must_have_a_valid_article_status_color_class()
    {
        $this->expectException(InvalidArgumentException::class);

        Meta::withLink(new Link('foo', '#'), self::getDateStub(), 'revised', 'Not valid status color class', 'bar');
    }

    public static function getDateStub()
    {
        return Date::simple(new DateTimeImmutable());
    }

    public function viewModelProvider() : array
    {
        return [
            'link' => [Meta::withLink(new Link('foo', '#'), self::getDateStub())],
            'link and date' => [Meta::withLink(new Link('foo', '#'), self::getDateStub())],
            'text' => [Meta::withText('foo', self::getDateStub())],
            'text and date' => [Meta::withText('foo', self::getDateStub())],
            'date' => [Meta::withDate(self::getDateStub())],
            'all' => [Meta::withLink(new Link('foo', '#'), self::getDateStub()), 'Revised', 'revised', 'bar'],
            'version' => [Meta::withVersion('Reviewed preprint v2', self::getDateStub(), 'Revised', 'revised')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/meta.mustache';
    }
}

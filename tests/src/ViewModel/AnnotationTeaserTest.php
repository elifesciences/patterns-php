<?php

namespace tests\eLife\Patterns\ViewModel;

use DateTimeImmutable;
use eLife\Patterns\ViewModel\AnnotationTeaser;
use eLife\Patterns\ViewModel\Date;
use InvalidArgumentException;

final class AnnotationTeaserTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'document' => 'the document',
            'highlight' => 'this highlight',
            'content' => 'the content',
            'meta' => [
                'text' => 'Only me',
                'date' => [
                    'isExpanded' => false,
                    'isUpdated' => false,
                    'forHuman' => [
                        'dayOfMonth' => 21,
                        'month' => 'Dec',
                        'year' => 2017,
                    ],
                    'forMachine' => '2017-12-21',
                ],
            ],
            'url' => '#the-url',
            'isRestricted' => true,
        ];

        $annotationTeaser = AnnotationTeaser::full(
            $data['document'],
            Date::simple(new DateTimeImmutable('2017-12-21')),
            $data['url'],
            $data['highlight'],
            $data['content'],
            $data['isRestricted']);
        $this->assertSame($data['document'], $annotationTeaser['document']);
        $this->assertSame($data['highlight'], $annotationTeaser['highlight']);
        $this->assertSame($data['content'], $annotationTeaser['content']);
        $this->assertSame($data['url'], $annotationTeaser['url']);
        $this->assertSame($data['meta'], $annotationTeaser['meta']->toArray());

        unset($data['isRestricted']);
        $this->assertSameWithoutOrder($data, $annotationTeaser);
    }

    /**
     * @test
     */
    public function it_must_have_a_document()
    {
        $this->expectException(InvalidArgumentException::class);

        AnnotationTeaser::full('');
    }

    /**
     * @test
     */
    public function it_must_have_a_date()
    {
        $this->expectException(InvalidArgumentException::class);

        AnnotationTeaser::full('the document', null);
    }

    /**
     * @test
     */
    public function it_must_have_a_url()
    {
        $this->expectException(InvalidArgumentException::class);

        AnnotationTeaser::full(
            'the document',
            Date::simple(new DateTimeImmutable('2017-12-21')),
            ''
        );
    }

    /**
     * @test
     */
    public function a_full_version_must_have_a_highlight()
    {
        $this->expectException(InvalidArgumentException::class);

        AnnotationTeaser::full(
            'the document',
            Date::simple(new DateTimeImmutable('2017-12-21')),
            '#the-url',
            ''
        );
    }

    /**
     * @test
     */
    public function a_full_version_must_have_content()
    {
        $this->expectException(InvalidArgumentException::class);

        AnnotationTeaser::full('the document',
            Date::simple(new DateTimeImmutable('2017-12-21')),
            '#the-url',
            'highlight',
            ''
        );
    }

    /**
     * @test
     */
    public function a_highlight_must_have_a_highlight()
    {
        $this->expectException(InvalidArgumentException::class);

        AnnotationTeaser::highlight(
            'the document',
            Date::simple(new DateTimeImmutable('2017-12-21')),
            '#the-url',
            ''
        );
    }

    /**
     * @test
     */
    public function a_page_note_must_have_content()
    {
        $this->expectException(InvalidArgumentException::class);

        AnnotationTeaser::pageNote('the document',
            Date::simple(new DateTimeImmutable('2017-12-21')),
            '#the-url',
            ''
        );
    }

    /**
     * @test
     */
    public function a_reply_must_have_content()
    {
        $this->expectException(InvalidArgumentException::class);

        AnnotationTeaser::reply(
            'the document',
            Date::simple(new DateTimeImmutable('2017-12-21')),
            '#the-url',
            ''
        );
    }

    /**
     * @test
     */
    public function a_reply_must_have_isReply_set_to_true()
    {
        $annotationTeaser = AnnotationTeaser::reply(
            'the document',
            Date::simple(new DateTimeImmutable('2017-12-21')),
            '#the-url',
            'the content'
        );
        $this->assertTrue($annotationTeaser['isReply']);
    }

    public function viewModelProvider() : array
    {
        return [
            'highlight' => [
                AnnotationTeaser::highlight('document', Date::simple(new DateTimeImmutable('2017-12-21')), '#the-url', 'highlight'),
            ],
            'restricted highlight' => [
                AnnotationTeaser::highlight('document', Date::simple(new DateTimeImmutable('2017-12-21')), '#the-url', 'highlight', AnnotationTeaser::RESTRICTED_ACCESS),
            ],
            'page note' => [
                AnnotationTeaser::pageNote('document', Date::simple(new DateTimeImmutable('2017-12-21')), '#the-url', 'content'),
            ],
            'restricted page note' => [
                AnnotationTeaser::pageNote('document', Date::simple(new DateTimeImmutable('2017-12-21')), '#the-url', 'content', AnnotationTeaser::RESTRICTED_ACCESS),
            ],
            'reply' => [
                AnnotationTeaser::reply('document', Date::simple(new DateTimeImmutable('2017-12-21')), '#the-url', 'content'),
            ],
            'restricted reply' => [
                AnnotationTeaser::reply('document', Date::simple(new DateTimeImmutable('2017-12-21')), '#the-url', 'content', AnnotationTeaser::RESTRICTED_ACCESS),
            ],
            'full' => [
                AnnotationTeaser::full('document', Date::simple(new DateTimeImmutable('2017-12-21')), '#the-url', 'highlight', 'content'),
            ],
            'restricted full' => [
                AnnotationTeaser::full('document', Date::simple(new DateTimeImmutable('2017-12-21')), '#the-url', 'highlight', 'content', AnnotationTeaser::RESTRICTED_ACCESS),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/annotation-teaser.mustache';
    }
}

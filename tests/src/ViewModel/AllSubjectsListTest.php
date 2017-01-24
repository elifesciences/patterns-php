<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\AllSubjectsList;
use eLife\Patterns\ViewModel\Link;
use InvalidArgumentException;

final class AllSubjectsListTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'id' => 'id',
            'subjects' => [
                [
                    'name' => 'subject 1',
                    'url' => '#',
                ],
                [
                    'name' => 'subject 2',
                    'url' => '#',
                ],
            ],
            'labelledBy' => 'labelledBy',
        ];

        $siteLinksList = new AllSubjectsList(
            $data['id'],
            [
                new Link($data['subjects'][0]['name'], $data['subjects'][0]['url']),
                new Link($data['subjects'][1]['name'], $data['subjects'][1]['url']),
            ],
            $data['labelledBy']
        );

        $this->assertSame($data, $siteLinksList->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_an_id()
    {
        $this->expectException(InvalidArgumentException::class);

        new AllSubjectsList('', [new Link('subject', 'url')]);
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [new AllSubjectsList('id', [new Link('subject', 'url')])],
            'complete' => [new AllSubjectsList('id', [new Link('subject', 'url')], 'labelledBy')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/all-subjects-list.mustache';
    }
}

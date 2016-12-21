<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\AllSubjectsList;
use eLife\Patterns\ViewModel\Link;

final class AllSubjectsListTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
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
        ];

        $siteLinksList = new AllSubjectsList(
            new Link($data['subjects'][0]['name'], $data['subjects'][0]['url']),
            new Link($data['subjects'][1]['name'], $data['subjects'][1]['url'])
        );

        $this->assertSame($data, $siteLinksList->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new AllSubjectsList(
                    new Link('subject', 'url')
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/all-subjects-list.mustache';
    }
}

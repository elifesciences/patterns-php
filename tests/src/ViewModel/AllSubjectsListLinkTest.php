<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\AllSubjectsListLink;
use InvalidArgumentException;

final class AllSubjectsListLinkTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'targetFragmentId' => 'id',
        ];

        $subjectsListLink = new AllSubjectsListLink($data['targetFragmentId']);

        $this->assertSame($data['targetFragmentId'], $subjectsListLink['targetFragmentId']);
        $this->assertSame($data, $subjectsListLink->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_a_target_fragment_id()
    {
        $this->expectException(InvalidArgumentException::class);

        new AllSubjectsListLink('');
    }

    public function viewModelProvider() : array
    {
        return [
            [new AllSubjectsListLink('id')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/all-subjects-list-link.mustache';
    }
}

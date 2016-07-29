<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Teaser;

final class TeaserTest extends ViewModelTest
{


    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'title' => 'the title'
        ];
        $teaser = Teaser::basic($data['title']);
        $this->assertSameWithoutOrder($data, $teaser);
    }

    public function viewModelProvider() : array
    {
        return [
            [
                Teaser::basic('wat')
            ]
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/teaser.mustache';
    }
}

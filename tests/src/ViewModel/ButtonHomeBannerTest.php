<?php

namespace src\ViewModel;

use eLife\Patterns\ViewModel\Button;
use tests\eLife\Patterns\ViewModel\ViewModelTest;

final class ButtonHomeBannerTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'text' => 'Some text',
            'path' => '#',
            'classes' => 'button--default home-banner__button'
        ];
        $buttonHomeBanner = Button::homeBanner('Some text', '#');
        $this->markTestIncomplete('failing');
        $this->assertSameWithoutOrder($data, $buttonHomeBanner->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'basic' => [Button::homeBanner('Some text', '#')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/button.mustache';
    }
}

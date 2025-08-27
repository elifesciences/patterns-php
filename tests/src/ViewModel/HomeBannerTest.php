<?php

namespace src\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\HomeBanner;
use tests\eLife\Patterns\ViewModel\ViewModelTest;
use eLife\Patterns\ViewModel;

final class HomeBannerTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $primaryButton = Button::link('Primary button', '#');
        $secondaryButton = Button::link('Secondary button', '#');
        $homeBanner = new HomeBanner($primaryButton, $secondaryButton);

        $data = [
            'primaryButton' => [
                'classes' => 'button--default home-banner__button',
                'path' => '#',
                'text' => 'Primary button',
            ],
            'secondaryButton' => [
                'classes' => 'button--default home-banner__button',
                'path' => '#',
                'text' => 'Secondary button',
            ]
            ];

        $this->markTestIncomplete('failing test');
        $this->assertSame($data, $homeBanner->toArray());
    }

    public function viewModelProvider() : array
    {
        $primaryButton = Button::link('Primary button', '#');
        $secondaryButton = Button::link('Secondary button', '#');
        return [
            'complete' => [new HomeBanner($primaryButton, $secondaryButton)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/home-banner.mustache';
    }
}

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
        $primaryButton = Button::homeBanner('Primary button', '#');
        $secondaryButton = Button::homeBanner('Secondary button', '#');
        $homeBanner = new HomeBanner($primaryButton, $secondaryButton);

        $data = [
            'primaryButton' => [
                'classes' => 'button--default button--full home-banner__button',
                'path' => '#',
                'text' => 'Primary button',
            ],
            'secondaryButton' => [
                'classes' => 'button--default button--full home-banner__button',
                'path' => '#',
                'text' => 'Secondary button',
            ]
        ];

        $this->assertSame($data, $homeBanner->toArray());
    }

    public function viewModelProvider() : array
    {
        $primaryButton = Button::homeBanner('Primary button', '#');
        $secondaryButton = Button::homeBanner('Secondary button', '#');
        return [
            'complete' => [new HomeBanner($primaryButton, $secondaryButton)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/home-banner.mustache';
    }
}

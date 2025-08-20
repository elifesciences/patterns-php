<?php

namespace src\ViewModel;

use eLife\Patterns\ViewModel\HomeBanner;
use tests\eLife\Patterns\ViewModel\ViewModelTest;

final class HomeBannerTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $homeBanner = new HomeBanner();

        $this->assertSame([], $homeBanner->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'complete' => [new HomeBanner()],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/home-banner.mustache';
    }
}

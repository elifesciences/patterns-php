<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\SiteHeaderLogo;
use InvalidArgumentException;

final class SiteHeaderLogoTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $siteHeaderLogo = new SiteHeaderLogo('/home/page/path');
        $this->assertSame('/home/page/path', $siteHeaderLogo['homePagePath']);
    }

    /**
     * @test
     */
    public function home_page_path_must_not_be_blank()
    {
        $this->expectException(InvalidArgumentException::class);
        new SiteHeaderLogo('');
    }

    public function viewModelProvider() : array
    {
        return [
            [new SiteHeaderLogo('/home/page/path')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/site-header-logo.mustache';
    }
}

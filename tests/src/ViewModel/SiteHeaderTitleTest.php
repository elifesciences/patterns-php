<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\SiteHeaderTitle;
use InvalidArgumentException;

final class SiteHeaderTitleTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $siteHeaderLogo = new SiteHeaderTitle('/home/page/path');
        $this->assertSame('/home/page/path', $siteHeaderLogo['homePagePath']);
    }

    /**
     * @test
     */
    public function home_page_path_must_not_be_blank()
    {
        $this->expectException(InvalidArgumentException::class);
        new SiteHeaderTitle('');
    }

    /**
     * @test
     */
    public function it_can_be_set_as_home_page()
    {
        $titleDefault = new SiteHeaderTitle('#', false, false);
        $this->assertArrayNotHasKey('isHomePage', $titleDefault->toArray());

        $titleHomePage = (new SiteHeaderTitle('#', false, false))->isHomePage();
        $this->assertTrue($titleHomePage->toArray()['isHomePage']);
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [new SiteHeaderTitle('/home/page/path')],
            'complete' => [(new SiteHeaderTitle('/home/page/path', true, true))->isHomePage()],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/site-header-title.mustache';
    }
}

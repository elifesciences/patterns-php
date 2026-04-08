<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\SiteHeaderTitle;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;

final class SiteHeaderTitleTest extends ViewModelTest
{
    #[Test]
    public function it_has_data()
    {
        $siteHeaderLogo = new SiteHeaderTitle('/home/page/path');
        $this->assertSame('/home/page/path', $siteHeaderLogo['homePagePath']);
    }

    #[Test]
    public function home_page_path_must_not_be_blank()
    {
        $this->expectException(InvalidArgumentException::class);
        new SiteHeaderTitle('');
    }

    #[Test]
    public function it_can_be_set_for_the_home_page()
    {
        $titleDefault = new SiteHeaderTitle('#', false, false);
        $this->assertArrayNotHasKey('isHomePage', $titleDefault->toArray());

        $titleHomePage = (new SiteHeaderTitle('#', false, false))->setForHomePage();
        $this->assertTrue($titleHomePage->toArray()['isHomePage']);
    }

    public static function viewModelProvider() : array
    {
        return [
            'minimum' => [new SiteHeaderTitle('/home/page/path')],
            'complete' => [(new SiteHeaderTitle('/home/page/path', true, true))->setForHomePage()],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/site-header-title.mustache';
    }
}

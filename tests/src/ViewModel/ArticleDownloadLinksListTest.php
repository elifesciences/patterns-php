<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ArticleDownloadsLinksList;

class ArticleDownloadLinksListTest extends ViewModelTest
{


    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'dlLinkArticle' => '#1',
            'dlLinkFigure' => '#2',
            'dlLinkCitsBibtex' => '#3',
            'dlLinkCitsEndnote' => '#4',
            'dlLinkCitsEndnote8' => '#5',
            'dlLinkCitsRefworks' => '#6',
            'dlLinkCitsRIS' => '#7',
            'dlLinkCitsMedlars' => '#8',
            'linkCitsMendeley' => '#9',
            'linkCitsReadCube' => '#10',
            'linkCitsPapers' => '#11',
            'linkCitsCiteULike' => '#12',
        ];

        $downloadList = new ArticleDownloadsLinksList(
            $data['dlLinkArticle'],
            $data['dlLinkFigure'],
            $data['dlLinkCitsBibtex'],
            $data['dlLinkCitsEndnote'],
            $data['dlLinkCitsEndnote8'],
            $data['dlLinkCitsRefworks'],
            $data['dlLinkCitsRIS'],
            $data['dlLinkCitsMedlars'],
            $data['linkCitsMendeley'],
            $data['linkCitsReadCube'],
            $data['linkCitsPapers'],
            $data['linkCitsCiteULike']
        );

        $this->assertSame($data['dlLinkArticle'], $downloadList['dlLinkArticle']);
        $this->assertSame($data['dlLinkFigure'], $downloadList['dlLinkFigure']);
        $this->assertSame($data['dlLinkCitsBibtex'], $downloadList['dlLinkCitsBibtex']);
        $this->assertSame($data['dlLinkCitsEndnote'], $downloadList['dlLinkCitsEndnote']);
        $this->assertSame($data['dlLinkCitsEndnote8'], $downloadList['dlLinkCitsEndnote8']);
        $this->assertSame($data['dlLinkCitsRefworks'], $downloadList['dlLinkCitsRefworks']);
        $this->assertSame($data['dlLinkCitsRIS'], $downloadList['dlLinkCitsRIS']);
        $this->assertSame($data['dlLinkCitsMedlars'], $downloadList['dlLinkCitsMedlars']);
        $this->assertSame($data['linkCitsMendeley'], $downloadList['linkCitsMendeley']);
        $this->assertSame($data['linkCitsReadCube'], $downloadList['linkCitsReadCube']);
        $this->assertSame($data['linkCitsPapers'], $downloadList['linkCitsPapers']);
        $this->assertSame($data['linkCitsCiteULike'], $downloadList['linkCitsCiteULike']);
        $this->assertSame($data, $downloadList->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [new ArticleDownloadsLinksList('#1', '#2', '#3', '#4', '#5', '#6', '#7', '#8', '#9', '#10', '#11', '#12')]
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/article-download-links-list.mustache';
    }
}

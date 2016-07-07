<?php

namespace tests\eLife\Patterns\ViewModel;


use eLife\Patterns\ViewModel\ArticleDownloadLinksList;
use eLife\Patterns\ViewModel\ArticleSection;

class ArticleSectionTest extends ViewModelTest
{

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'id' => 'id',
            'title' => 'some title',
            'downloadLinks' =>
                [
                    'dlLinkArticle' => '#01',
                    'dlLinkFigure' => '#02',
                    'dlLinkCitsBibtex' => '#03',
                    'dlLinkCitsEndnote' => '#04',
                    'dlLinkCitsEndnote8' => '#05',
                    'dlLinkCitsRefworks' => '#06',
                    'dlLinkCitsRIS' => '#07',
                    'dlLinkCitsMedlars' => '#08',
                    'linkCitsMendeley' => '#09',
                    'linkCitsReadCube' => '#10',
                    'linkCitsPapers' => '#11',
                    'linkCitsCiteULike' => '#12',
                ],
            'body' =>
                [

                    [
                        'content' => '<p>para 1</p>',
                    ],

                    [
                        'content' => '<b>Something else</b>',
                    ],
                ],
        ];

        $actionSection = new ArticleSection('id', 'some title', ['<p>para 1</p>', '<b>Something else</b>'], self::getDownloadLinksList());

        $this->assertSame($data['id'], $actionSection['id']);
        $this->assertSame($data['title'], $actionSection['title']);
        $this->assertSame($data['body'], $actionSection['body']);
        $this->assertSame($data['downloadLinks'], $actionSection['downloadLinks']->toArray());

        $this->assertSame($data, $actionSection->toArray());
    }

    static function getDownloadLinksList()
    {
        return new ArticleDownloadLinksList('#01', '#02', '#03', '#04', '#05', '#06', '#07', '#08', '#09', '#10', '#11', '#12');
    }

    public function viewModelProvider() : array
    {
        return [
            [ new ArticleSection('id', 'some title', ['<p>para 1</p>', '<b>Something else</b>'], self::getDownloadLinksList()) ]
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/article-section.mustache';
    }
}

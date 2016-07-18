<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\CastsToArray;
use eLife\Patterns\ViewModel\Author;
use eLife\Patterns\ViewModel\AuthorList;
use eLife\Patterns\ViewModel\ContentHeaderMagazineArticle;
use eLife\Patterns\ViewModel\Date;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Institution;
use eLife\Patterns\ViewModel\InstitutionList;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Meta;
use eLife\Patterns\ViewModel\Picture;
use eLife\Patterns\ViewModel\SiteLinks;
use eLife\Patterns\ViewModel\SiteLinksList;
use DateTimeImmutable;

class ContentHeaderMagazineArticleTest extends ViewModelTest
{

    /**
     * @test
     */
    public function it_works()
    {
        $data = self::magazineFixture();

        $magazine = ContentHeaderMagazineArticle::magazine(
            $data['title'],
            $data['strapline'],
            $data['articleType'],
            new AuthorList(array_map(function ($item) {
                return new Author($item['name']);
            }, $data['authors']['list'])),
            new Picture([
                [
                    "srcset" => "../../assets/img/icons/download-full.svg",
                    "media" => "(min-width: 35em)",
                    "type" => "image/svg+xml"
                ],
                [
                    "srcset" => "../../assets/img/icons/download-full-1x.png",
                    "media" => "(min-width: 35em)"
                ],
                [
                    "srcset" => "../../assets/img/icons/download.svg",
                    "type" => "image/svg+xml"
                ]
            ], new Image(
                    '../../assets/img/icons/download-full-1x.png',
                [500 => '/path/to/image/500/wide'], 'Download icon')
            ),
            new Link($data['subject']['name'], $data['subject']['url']), // <-- @todo change to url.
            new Meta(
                'Insight', new Date(new DateTimeImmutable('2015-12-15')), '#'
            )
        );
//        var_dump($data);
//        var_dump($magazine->toArray());
//        $this->assertSame($data, $magazine);

        foreach ($data as $k => $d) {
            $to_assert = $magazine[$k] instanceof CastsToArray ? $magazine[$k]->toArray() : $magazine[$k];
            $this->assertSame($to_assert, $d, "asserting key: " . $k);
//            if ($magazine[$k] == $d) {
//                unset($data[$k]);
//            }
//            if ($magazine[$k] instanceof CastsToArray) {
//                if ($magazine[$k]->toArray() == $d) {
//                    unset($data[$k]);
//                }
//            }
        }
        $this->assertSameWithoutOrder($data, $magazine->toArray());
//        if ($magazine['download']->toArray()['fallback'] == $data['download']['fallback']) {
//            var_dump('yay!');exit;
//        }
//        var_dump($magazine['download']->toArray()['fallback']);
//        var_dump($data['download']['fallback']);
//        $d = array_diff_assoc(
//            $data,
//            $magazine->toArray()
//        );
//        var_dump($d);
//        $d = array_intersect((array) $data, (array) $magazine->toArray());
//        var_dump($d);
    }

    public function assertSameWithoutOrder($actual, $expected) {
        foreach ($actual as $k => $d) {
            if ($expected[$k] instanceof CastsToArray || is_array($expected[$k])) {
                $this->assertSameWithoutOrder($d, $expected[$k]);
                continue;
            }
            $this->assertSame($expected[$k], $d, "asserting key: " . $k);
        }
    }

    public static function magazineFixture()
    {
        return json_decode('
        {
          "rootClasses": "content-header-article content-header-article-magazine",
          "behaviour": "ContentHeaderArticle",
          "title": "Planarian \'kidneys\' go with the flow",
          "titleClass": "content-header__title--medium",
          "strapline": "Flatworms have organs called protonephridia that could be used as a model system for the study of kidney disease.",
          "subject": {
            "name": "Developmental Biology and Stem Cells",
            "url": "#"
          },
          "articleType": "Insight",
          "authors": {
            "list": [
              {"name": "Melanie Issigonis"},
              {"name": "Phillip A Newmark"}
            ]
          },
          "download": {
            "fallback": {
              "altText": "Download icon",
              "defaultPath": "../../assets/img/icons/download-full-1x.png",
              "srcset": "/path/to/image/500/wide 500w",
              "classes": "content-header__download_icon"
            },
            "sources": [
              {
                "srcset": "../../assets/img/icons/download-full.svg",
                "media": "(min-width: 35em)",
                "type": "image/svg+xml"
              },
              {
                "srcset": "../../assets/img/icons/download-full-1x.png",
                "media": "(min-width: 35em)"
              },
              {
                "srcset": "../../assets/img/icons/download.svg",
                "type": "image/svg+xml"
              }
            ]
          },

          "meta": {
            "type": "Insight",
            "date": {
              "forHuman": "Dec 15, 2015",
              "forMachine": "2015-12-15"
            },
            "typeLink": "#"
          }
        }', true);
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [];
    }

    public function viewModelProvider() : array
    {
        $data = self::magazineFixture();
        return [
            'Magazine' => [
                ContentHeaderMagazineArticle::magazine(
                    $data['title'],
                    $data['strapline'],
                    $data['articleType'],
                    new AuthorList(array_map(function ($item) {
                        return new Author($item['name']);
                    }, $data['authors']['list'])),
                    new Picture([
                        [
                            "srcset" => "../../assets/img/icons/download-full.svg",
                            "media" => "(min-width: 35em)",
                            "type" => "image/svg+xml"
                        ],
                        [
                            "srcset" => "../../assets/img/icons/download-full-1x.png",
                            "media" => "(min-width: 35em)"
                        ],
                        [
                            "srcset" => "../../assets/img/icons/download.svg",
                            "type" => "image/svg+xml"
                        ]
                    ], new Image(
                            '../../assets/img/icons/download-full-1x.png',
                            [500 => '/path/to/image/500/wide'], 'Download icon')
                    ),
                    new Link($data['subject']['name'], $data['subject']['url']), // <-- @todo change to url.
                    new Meta(
                        'Insight', new Date(new DateTimeImmutable('2015-12-15')), '#'
                    )
                )
            ],
//            'Research' => [
//                ContentHeaderMagazineArticle::research(
//                    'title',
//                    ContentHeaderMagazineArticle::TITLE_SMALL,
//                    new Link('subject', '#'),
//                    'article type',
//                    new AuthorList([
//                        new Author('Mr someone'),
//                        new Author('Ms someone else'),
//                    ]),
//                    new InstitutionList([
//                        new Institution('Some institution'),
//                        new Institution('Another institution'),
//                    ]),
//                    new Picture([], new Image('#', [])),
//                    new Meta('type', new Date(new DateTimeImmutable()))
//                )
//            ]
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/content-header-article.mustache';
    }
}

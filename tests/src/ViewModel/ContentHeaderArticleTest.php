<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Author;
use eLife\Patterns\ViewModel\AuthorList;
use eLife\Patterns\ViewModel\ContentHeaderArticle;
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

class ContentHeaderArticleTest extends ViewModelTest
{

    /**
     * @test
     */
    public function it_works()
    {
        $data = self::magazineFixture();

        $magazine = ContentHeaderArticle::magazine(
            $data['title'],
            $data['titleClass'],
            new Link($data['subject']['name'], $data['subject']['href']), // <-- @todo change to url.
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
            new Meta(
                'Insight', new Date(new DateTimeImmutable('2015-12-15')), '#'
            )
        );
        var_dump($data);
        var_dump($magazine->toArray());
        $this->assertSame($data, $magazine);
//        $d = array_diff_assoc(
//            $data,
//            $magazine->toArray()
//        );
//        var_dump($d);
//        $d = array_intersect((array) $data, (array) $magazine->toArray());
//        var_dump($d);
    }

    public static function magazineFixture()
    {
        return json_decode('
        {
          "rootClasses": "content-header-article content-header-article-magazine",
          "behaviour": "ContentHeaderArticle",
          "title": "Planarian \'kidneys\' go with the flow",
          "titleClass": "content-header__title--small",
          "strapline": "Flatworms have organs called protonephridia that could be used as a model system for the study of kidney disease.",
          "subject": {
            "name": "Developmental Biology and Stem Cells",
            "href": "#"
          },
          "articleType": "Insight",
          "authors": {
            "list": [
              {"name": "Melanie Issigonis"},
              {"name": "Phillip A Newmark"}
            ]
          },
          "download": {
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
            ],
            "fallback": {
              "defaultPath": "../../assets/img/icons/download-full-1x.png",
              "classes": "content-header__download_icon",
              "altText": "Download icon"
            }
          },

          "meta": {
            "typeLink": "#",
            "type": "Insight",
            "date": {
              "forHuman": "Dec 15, 2015",
              "forMachine": "2015-12-15"
            }
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
        return [
            'Magazine' => [
                ContentHeaderArticle::magazine(
                    $data['title'],
                    $data['titleClass'],
                    new Link($data['subject']['name'], $data['subject']['href']), // <-- @todo change to url.
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
                    new Meta(
                        'Insight', new Date(new DateTimeImmutable('2015-12-15')), '#'
                    )
                )
            ],
//            'Research' => [
//                ContentHeaderArticle::research(
//                    'title',
//                    ContentHeaderArticle::TITLE_SMALL,
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
        // TODO: Implement expectedTemplate() method.
    }
}

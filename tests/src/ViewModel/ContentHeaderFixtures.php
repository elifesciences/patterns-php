<?php

namespace tests\eLife\Patterns\ViewModel;

final class ContentHeaderFixtures
{
    public static function magazineFixture()
    {
        // @note
        // Changed titleClass from small to medium
        // Changed subject.href -> subject.url
        $magazine = <<<JSON
        {
          "rootClasses": "content-header-article content-header-article-magazine",
          "behaviour": "ContentHeaderArticle",
          "title": "Planarian 'kidneys' go with the flow",
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
              "defaultPath": "../../assets/img/icons/download-full-1x.png",
              "classes": "content-header__download_icon",
              "srcset": "/path/to/image/500/wide 500w",
              "altText": "Download icon"
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
            "typeLink": "#",
            "type": "Insight",
            "date": {
              "forHuman": {
                "dayOfMonth": 15,
                "month": "Dec",
                "year": 2015
              },
              "forMachine": "2015-12-15"
            }
          }
        }
JSON;

        return json_decode($magazine, true);
    }

    public static function magazineBackgroundFixture()
    {
        $fixture = <<<JSON
        {
          "rootClasses": "content-header-article content-header-article-magazine content-header-article-magazine--background",
          "behaviour": "ContentHeaderArticle",
          "title": "Planarian 'kidneys' go with the flow",
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
            "sources": [
              {
                "srcset": "../../assets/img/icons/download-full-reverse.svg",
                "media": "(min-width: 35em)",
                "type": "image/svg+xml"
              },
              {
                "srcset": "../../assets/img/icons/download-full-reverse-1x.png",
                "media": "(min-width: 35em)"
              },
              {
                "srcset": "../../assets/img/icons/download-reverse.svg",
                "type": "image/svg+xml"
              }
            ],
            "fallback": {
              "defaultPath": "../../assets/img/icons/download-full-reverse-1x.png",
              "classes": "content-header__download_icon",
              "srcset": "/path/to/image/500/wide 500w",
              "altText": "Download icon"
            }
          },

          "meta": {
            "typeLink": "#",
            "type": "Insight",
            "date": {
              "forHuman": {
                "dayOfMonth": 15,
                "month": "Dec",
                "year": 2015
              },
              "forMachine": "2015-12-15"
            }
          }
        }
JSON;

        return json_decode($fixture, true);
    }

    public static function magazineBackgroundImageFixture()
    {
        $fixture = <<<JSON
        {
          "rootClasses": "content-header-article content-header-article-magazine content-header-article-magazine--background content-header--background-image",
          "behaviour": "ContentHeaderArticle ContentHeaderBackgroundImage",
          "title": "Planarian 'kidneys' go with the flow",
          "titleClass": "content-header__title--small",
          "strapline": "Flatworms have organs called protonephridia that could be used as a model system for the study of kidney disease.",
          "subject": {
            "name": "Developmental Biology and Stem Cells",
            "href": "#"
          },
          "articleType": "Insight",
          "authors": {
            "list": [
              {
                "name": "Melanie Issigonis"
              },
              {
                "name": "Phillip A Newmark"
              }
            ]
          },
          "download": {
            "sources": [
              {
                "srcset": "../../assets/img/icons/download-full-reverse.svg",
                "media": "(min-width: 35em)",
                "type": "image/svg+xml"
              },
              {
                "srcset": "../../assets/img/icons/download-full-reverse-1x.png",
                "media": "(min-width: 35em)"
              },
              {
                "srcset": "../../assets/img/icons/download-reverse.svg",
                "type": "image/svg+xml"
              }
            ],
            "fallback": {
              "defaultPath": "../../assets/img/icons/download-full-reverse-1x.png",
              "classes": "content-header__download_icon",
              "altText": "Download icon"
            }
          },
          "backgroundImage": {
            "images": {
              "hires": "http://unsplash.it/1800/900/",
              "lores": "http://unsplash.it/950/400"
            }
          },
          "meta": {
            "typeLink": "#",
            "type": "Insight",
            "date": {
              "forHuman": {
                "dayOfMonth": 15,
                "month": "Dec",
                "year": 2015
              },
              "forMachine": "2015-12-15"
            }
          }
        }

JSON;

        return json_decode($fixture, true);
    }

    public static function researchFixture()
    {

        // @note
        // Change subject.href -> subject.url
        // Added srcset to fallback image
        $fixture = <<<JSON
        {
          "rootClasses": "content-header-article content-header-article-research",
          "behaviour": "ContentHeaderArticle",
          "title": "<i>Homo naledi</i>, a new species of the genus <i>Homo</i> from the Dinaledi Chamber, South Africa",
          "subject": {
            "name": "Epidemiology and global health",
            "url": "#"
          },
          "articleType": "Research article",
          "authors": {
            "list": [
              {"name": "Lee R Berger"},
              {"name": "John Hawks"},
              {"name": "Darryl J de Ruiter"},
              {"name": "Steven E Churchill"},
              {"name": "Peter Schmid"},
              {"name": "Lucas K Delezene"},
              {"name": "Tracy L Kivell"},
              {"name": "Heather M Garvin"},
              {"name": "Scott A Williams"},
              {"name": "Jeremy M DeSilva"},
              {"name": "Matthew M Skinner"},
              {"name": "Charles M Musiba"},
              {"name": "Noel Cameron"},
              {"name": "Trenton W Holliday"},
              {"name": "William Harcourt-Smith"},
              {"name": "Rebecca R Ackermann"},
              {"name": "Markus Bastir"},
              {"name": "Barry Bogin"},
              {"name": "Debra Bolter"},
              {"name": "Juliet Brophy"},
              {"name": "Zachary D Cofran"},
              {"name": "Kimberly A Congdon"},
              {"name": "Andrew S Deane"},
              {"name": "Mana Dembo"},
              {"name": "Michelle Drapeau"},
              {"name": "Marina C Elliott"},
              {"name": "Elen M Feuerriegel"},
              {"name": "Daniel Garcia-Martinez"},
              {"name": "David J Green"},
              {"name": "Alia Gurtov"},
              {"name": "Joel D Irish"},
              {"name": "Ashley Kruger"},
              {"name": "Myra F Laird"},
              {"name": "Damiano Marchi"},
              {"name": "Marc R Meyer"},
              {"name": "Shahed Nalla"},
              {"name": "Enquye W Negash"},
              {"name": "Caley M Orr"},
              {"name": "Davorka Radovcic"},
              {"name": "Lauren Schroeder"},
              {"name": "Jill E Scott"},
              {"name": "Zachary Throckmorton"},
              {"name": "Caroline VanSickle"},
              {"name": "Christopher S Walker"},
              {"name": "Pianpian Wei"},
              {"name": "Bernhard Zipfel"}
            ]
          },
          "institutions" : {
            "list": [
              {"name": "University of the Witwatersrand, South Africa"},
              {"name": "University of Wisconsin-Madison, United States"},
              {"name": "Texas A&M University, United States"},
              {"name": "Duke University, United States"},
              {"name": "University of Zurich, Switzerland"},
              {"name": "University of Arkansas, United States"},
              {"name": "University of Kent, United Kingdom"},
              {"name": "Max Planck Institute for Evolutionary Anthropology, Germany"},
              {"name": "Mercyhurst University, United States"},
              {"name": "New York University, United States"},
              {"name": "New York Consortium in Evolutionary Primatology, United States"},
              {"name": "Dartmouth College, United States"},
              {"name": "University of Colorado Denver, United States"},
              {"name": "Loughborough University, United Kingdom"},
              {"name": "Tulane University, United States"},
              {"name": "Lehman College, United States"},
              {"name": "American Museum of Natural History, United States"},
              {"name": "University of Cape Town, South Africa"},
              {"name": "Museo Nacional de Ciencias Naturales, Spain"},
              {"name": "Modesto Junior College, United States"},
              {"name": "Louisiana State University, United States"},
              {"name": "Nazarbayev University, Kazakhstan"},
              {"name": "University of Missouri, United States"},
              {"name": "University of Kentucky College of Medicine, United States"},
              {"name": "Simon Fraser University, Canada"},
              {"name": "Universit&eacute; de Montr&eacute;al, Canada"},
              {"name": "Australian National University, Australia"},
              {"name": "Biology Department, Universidad Autònoma de Madrid, Spain"},
              {"name": "Midwestern University, United States"},
              {"name": "Liverpool John Moores University, United Kingdom"},
              {"name": "University of Pisa, Italy"},
              {"name": "Chaffey College, United States"},
              {"name": "University of Johannesburg, South Africa"},
              {"name": "George Washington University, United States"},
              {"name": "University of Colorado School of Medicine, United States"},
              {"name": "Croatian Natural History Museum, Croatia"},
              {"name": "University of Iowa, United States"},
              {"name": "Lincoln Memorial University, United States"},
              {"name": "Smithsonian Institution, United States"}
            ]
          },

          "titleClass": "content-header__title--extra-small",

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
              "srcset": "/path/to/image/500/wide 500w",
              "classes": "content-header__download_icon",
              "altText": "Download icon"
            }
          },

          "meta": {
            "typeLink": "#",
            "type": "Research article",
            "date": {
              "forHuman": {
                "dayOfMonth": 10,
                "month": "Sep",
                "year": 2015
              },
              "forMachine": "2015-09-10"
            }
          }
        }

JSON;

        return json_decode($fixture, true);
    }

    public static function researchReadMoreFixture()
    {
        // @note
        // Changed href -> url
        // Removed `images` field (see below.)
        /*
         "images": {
            "download": {
              "svg": "../../assets/img/icons/download.svg",
              "svgFull": "../../assets/img/icons/download-full.svg",
              "bitmap": "../../assets/img/icons/download-1x.png",
              "bitmapFull": "../../assets/img/icons/download-full-1x.png"
            }
          },
         */
        $fixture = <<<JSON
            {
              "rootClasses": "content-header-article content-header-article-research content-header-article-research--readmore",
              "title": "<i>Homo naledi</i>, a new species of the genus <i>Homo</i> from the Dinaledi Chamber, South Africa",
              "titleClass": "content-header__title--extra-small",
              "subject": {
                "name": "Epidemiology and global health",
                "url": "#"
              },
              "articleType": "Research article",
              "authors": {
                "firstAuthorOnly": "Lee R Berger",
                "hasEtAl": true
              },
              "meta": {
                "typeLink": "#",
                "type": "Research article",
                "date": {
                  "forHuman": {
                    "dayOfMonth": 10,
                    "month": "Sep",
                    "year": 2015
                  },
                  "forMachine": "2015-09-10"
                }
              }
            }
JSON;

        return json_decode($fixture, true);
    }
}

<?php

namespace tests\eLife\Patterns\ViewModel;

final class ContentHeaderFixtures
{
    public static function magazineFixture()
    {
        // @note
        // Changed titleClass from small to medium
        $magazine = <<<JSON
        {
          "rootClasses": "content-header-article content-header-article-magazine",
          "behaviour": "ContentHeaderArticle",
          "title": "Planarian 'kidneys' go with the flow",
          "titleClass": "content-header__title--medium",
          "strapline": "Flatworms have organs called protonephridia that could be used as a model system for the study of kidney disease.",
          "subjects": {
            "list": [
              {
                "name": "Cell Biology",
                "url": "#"
              },
              {
                "name": "Epidemiology and global health",
                "url": "#"
              }
            ]
          },
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
              "srcset": "../../assets/img/icons/download-full-2x.png 88w, ../../assets/img/icons/download-full-1x.png 44w",
              "classes": "content-header__download_icon",
              "altText": "Download icon"
            }
          },
          "meta": {
            "url": "#",
            "text": "Insight",
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
    public static function magazineBackgroundImageFixture()
    {
        $fixture = <<<JSON
        {
          "rootClasses": "content-header-article content-header-article-magazine content-header-article-magazine--background",
          "behaviour": "ContentHeaderArticle ContentHeaderBackgroundImage",
          "title": "Planarian 'kidneys' go with the flow",
          "titleClass": "content-header__title--medium",
          "strapline": "Flatworms have organs called protonephridia that could be used as a model system for the study of kidney disease.",
          "subjects": {
            "list": [
              {
                "name": "Cell Biology",
                "url": "#"
              },
              {
                "name": "Epidemiology and global health",
                "url": "#"
              }
            ]
          },
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
              "srcset": "../../assets/img/icons/download-full-reverse-2x.png 88w, ../../assets/img/icons/download-full-reverse-1x.png 44w",
              "classes": "content-header__download_icon",
              "altText": "Download icon"
            }
          },
          "backgroundImage": {
            "lowResImageSource": "http://unsplash.it/950/400",
            "highResImageSource": "http://unsplash.it/1900/800"
          },

          "meta": {
            "url": "#",
            "text": "Insight",
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
    public static function magazineBackgroundFixture()
    {
        $fixture = <<<JSON
        {
          "rootClasses": "content-header-article content-header-article-magazine content-header-article-magazine--background",
          "behaviour": "ContentHeaderArticle",
          "title": "Planarian 'kidneys' go with the flow",
          "titleClass": "content-header__title--medium",
          "strapline": "Flatworms have organs called protonephridia that could be used as a model system for the study of kidney disease.",
          "subjects": {
            "list": [
              {
                "name": "Cell Biology",
                "url": "#"
              },
              {
                "name": "Epidemiology and global health",
                "url": "#"
              }
            ]
          },
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
              "srcset": "../../assets/img/icons/download-full-reverse-2x.png 88w, ../../assets/img/icons/download-full-reverse-1x.png 44w",
              "classes": "content-header__download_icon",
              "altText": "Download icon"
            }
          },

          "meta": {
            "url": "#",
            "text": "Insight",
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
        $fixture = <<<JSON
        {
          "rootClasses": "content-header-article content-header-article-research",
          "behaviour": "ContentHeaderArticle",
          "title": "<i>Homo naledi</i>, a new species of the genus <i>Homo</i> from the Dinaledi Chamber, South Africa",
          "subjects": {
            "list": [
              {
                "name": "Cell Biology",
                "url": "#"
              },
              {
                "name": "Epidemiology and global health",
                "url": "#"
              }
            ]
          },
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
              "srcset": "../../assets/img/icons/download-full-2x.png 88w, ../../assets/img/icons/download-full-1x.png 44w",
              "classes": "content-header__download_icon",
              "altText": "Download icon"
            }
          },

          "meta": {
            "url": "#",
            "text": "Research article",
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
        $fixture = <<<JSON
            {
              "rootClasses": "content-header-article content-header-article-research content-header-article-research--readmore",
              "title": "<i>Homo naledi</i>, a new species of the genus <i>Homo</i> from the Dinaledi Chamber, South Africa",
              "titleClass": "content-header__title--extra-small",
              "subjects": {
                "list": [
                  {
                    "name": "Cell Biology",
                    "url": "#"
                  },
                  {
                    "name": "Epidemiology and global health",
                    "url": "#"
                  }
                ]
              },
              "authors": {
                "firstAuthorOnly": "Lee R Berger",
                "hasEtAl": true
              },

              "meta": {
                "url": "#",
                "text": "Research article",
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
    public static function nonArticleBasicFixture()
    {
        $fixture = <<<JSON
            {
              "rootClasses": "content-header-nonarticle content-header-nonarticle--background",
              "title": "About <i>eLife</i>",
              "titleClass": "content-header__title--large"
            }
JSON;

        return json_decode($fixture, true);
    }
    public static function nonArticleBasicWithStraplineFixture()
    {
        $fixture = <<<JSON
            {
              "rootClasses": "content-header-nonarticle",
              "title": "About <i>eLife</i>",
              "titleClass": "content-header__title--large",
              "strapline": "<i>eLife</i> publishes outstanding research in the life sciences and biomedicine, from the most fundamental and theoretical work, through to translational, applied, and clinical research."
            }

JSON;

        return json_decode($fixture, true);
    }
    public static function nonArticleBasicWithStraplineBackgroundFixture()
    {
        $fixture = <<<JSON
            {
              "rootClasses": "content-header-nonarticle content-header-nonarticle--background",
              "title": "About <i>eLife</i>",
              "titleClass": "content-header__title--large",
              "strapline": "<i>eLife</i> publishes outstanding research in the life sciences and biomedicine, from the most fundamental and theoretical work, through to translational, applied, and clinical research."
            }
JSON;

        return json_decode($fixture, true);
    }
    public static function nonArticleBasicWithStraplineBackgroundCtaMetaFixture()
    {
        $fixture = <<<JSON
            {
              "rootClasses": "content-header-nonarticle content-header-nonarticle--background",
              "behaviour": "ContentHeaderBackgroundImage",
              "title": "About <i>eLife</i>",
              "titleClass": "content-header__title--large",
              "strapline": "<i>eLife</i> publishes outstanding research in the life sciences and biomedicine, from the most fundamental and theoretical work, through to translational, applied, and clinical research.",
              "hasCtaOrMeta": true,
              "button": {
                "text": "Subscribe",
                "path": "#",
                "classes": "button--small button--outline"
              },
              "meta": {
                "url": "#",
                "text": "Collection",
                "date": {
                  "forHuman": {
                    "dayOfMonth": 29,
                    "month": "Feb",
                    "year": 2016
                  },
                  "forMachine": "2016-02-29"
                }
              },

              "backgroundImage": {
                "lowResImageSource": "http://unsplash.it/950/400",
                "highResImageSource": "http://unsplash.it/1900/800"
              }
            }
JSON;

        return json_decode($fixture, true);
    }
    public static function nonArticleCuratedContent()
    {
        $fixture = <<<JSON
            {
              "rootClasses": "content-header-nonarticle content-header-nonarticle--background",
              "behaviour": "ContentHeaderBackgroundImage",
              "title": "About <i>eLife</i>",
              "titleClass": "content-header__title--large",
              "strapline": "<i>eLife</i> publishes outstanding research in the life sciences and biomedicine, from the most fundamental and theoretical work, through to translational, applied, and clinical research.",
              "hasProfile": true,
              "profile": {
                "name": "Prabhat Jha",
                "link": "#",
                "avatar": {
                  "x1": "./assets/img/avatars/pjha1.png",
                  "x2": "./assets/img/avatars/pjha2.png"
                }
              },
              "hasCtaOrMeta": true,
              "button": {
                "text": "Subscribe",
                "path": "#",
                "classes": "button--small button--outline"
              },
              "meta": {
                "url": "#",
                "text": "Collection",
                "date": {
                  "forHuman": {
                    "dayOfMonth": 29,
                    "month": "Feb",
                    "year": 2016
                  },
                  "forMachine": "2016-02-29"
                }
              },
              "backgroundImage": {
                "lowResImageSource": "http://unsplash.it/950/400",
                "highResImageSource": "http://unsplash.it/1900/800"
              }
            }

JSON;

        return json_decode($fixture, true);
    }
    public static function nonArticleSubject()
    {
        $fixture = <<<JSON
            {
              "rootClasses": "content-header-nonarticle content-header-nonarticle--background",
              "behaviour": "ContentHeaderBackgroundImage",
              "title": "About <i>eLife</i>",
              "titleClass": "content-header__title--large",
              "hasCtaOrMeta": true,
              "button": {
                "text": "Subscribe",
                "path": "#",
                "classes": "button--small button--outline"
              },
              "backgroundImage": {
                "lowResImageSource": "http://unsplash.it/950/400",
                "highResImageSource": "http://unsplash.it/1900/800"
              }
            }


JSON;

        return json_decode($fixture, true);
    }
    public static function nonArticlePodcastFixture()
    {
        $fixture = <<<JSON
        {
          "rootClasses": "content-header-nonarticle content-header-nonarticle--background",
          "behaviour": "ContentHeaderBackgroundImage",
          "title": "Multicellular life, potato blight and Hepatitis B",
          "strapline": "Episode 21",
          "titleClass": "content-header__title--medium",
          "hasCtaOrMeta": true,
          "meta": {
            "text": "Podcast",
            "date": {
              "forHuman": {
                "dayOfMonth": 29,
                "month": "Feb",
                "year": 2016
              },
              "forMachine": "2016-02-29"
            }
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
              "srcset": "../../assets/img/icons/download-full-reverse-2x.png 88w, ../../assets/img/icons/download-full-reverse-1x.png 44w",
              "classes": "content-header__download_icon",
              "altText": "Download icon"
            }
          },
          "backgroundImage": {
            "lowResImageSource": "http://unsplash.it/950/400",
            "highResImageSource": "http://unsplash.it/1900/800"
          }
        }

JSON;

        return json_decode($fixture, true);
    }
    public static function nonArticleArchiveFixture()
    {
        $fixture = <<<JSON
            {
              "rootClasses": "content-header-nonarticle content-header-nonarticle--background",
              "behaviour": "ContentHeaderSelectNav ContentHeaderBackgroundImage",
              "title": "Archive",
              "titleClass": "content-header__title--large",
              "hasCtaOrMeta": true,
              "selectNav": {
                "route": "/path/to/archive",
                "select": {
                  "id": "archiveYear",
                  "label": {
                    "labelText": "Archive year",
                    "for": "archiveYear",
                    "isVisuallyHidden": true
                  },
                  "options": [
                    {
                      "value": "2016",
                      "displayValue": "2016"
                    },
                    {
                      "value": "2015",
                      "displayValue": "2015"
                    },
                    {
                      "value": "2014",
                      "displayValue": "2014"
                    }
                  ]
                },
                "button": {
                  "text": "Go",
                  "type": "submit",
                  "classes": "button--outline button--extra-small"
                }
              },
              "backgroundImage": {
                "lowResImageSource": "http://unsplash.it/950/400",
                "highResImageSource": "http://unsplash.it/1900/800"
              }
            }



JSON;

        return json_decode($fixture, true);
    }
}

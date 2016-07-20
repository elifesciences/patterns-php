<?php

namespace tests\eLife\Patterns\ViewModel;


final class ContentHeaderFixtures
{
    public static function magazineFixture()
    {
        // @note
        // Changed titleClass from small to medium
        // Changed subject.href -> subject.url
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
', true);
    }
}

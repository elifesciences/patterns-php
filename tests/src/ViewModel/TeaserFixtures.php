<?php

namespace tests\eLife\Patterns\ViewModel;


use Assert\Assertion;

final class TeaserFixtures
{

    const MAIN = 'teaser~05-main.json';
    const MAIN_SMALL_IMAGE = 'teaser~10-main-small-image.json';
    const MAIN_BIG_IMAGE = 'teaser~15-main-big-image.json';
    const SECONDARY = 'teaser~20-secondary.json';
    const SECONDARY_SMALL_IMAGE = 'teaser~25-secondary-small-image.json';
    const SECONDARY_BIG_IMAGE = 'teaser~30-secondary-big-image.json';
    const RELATED_ITEM = 'teaser~35-related-item.json';
    const BASIC = 'teaser~40-basic.json';
    const MAIN_EVENT = 'teaser~45-main-event.json';
    const SECONDARY_EVENT = 'teaser~50-secondary-event.json';
    const CHAPTER_LISTING_ITEM = 'teaser~52-chapter-listing-item.json';
    const GRID_STYLE_LABS = 'teaser~55-gird-style--labs.json';
    const GRID_STYLE_PODCAST = 'teaser~60-grid-style--podcast.json';


    public static function load(string $const) {
        Assertion::inArray($const, [
            self::MAIN,
            self::MAIN_SMALL_IMAGE,
            self::MAIN_BIG_IMAGE,
            self::SECONDARY,
            self::SECONDARY_SMALL_IMAGE,
            self::SECONDARY_BIG_IMAGE,
            self::RELATED_ITEM,
            self::BASIC,
            self::MAIN_EVENT,
            self::SECONDARY_EVENT,
            self::CHAPTER_LISTING_ITEM,
            self::GRID_STYLE_LABS,
            self::GRID_STYLE_PODCAST
        ]);
        $json = file_get_contents(__DIR__ . '/teasers/'.$const);
        return json_decode($json, true);

    }

}

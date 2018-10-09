<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class ContentHeader implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $title;
    private $titleLength;
    private $image;
    private $impactStatement;
    private $header;
    private $authors;
    private $institutions;
    private $download;
    private $socialMediaSharers;
    private $selectNav;
    private $meta;
    private $licence;
    private $audioPlayer;

    const XX_SHORT = 'xx-short';
    const X_SHORT = 'x-short';
    const SHORT = 'short';
    const MEDIUM = 'medium';
    const LONG = 'long';
    const X_LONG = 'x-long';
    const XX_LONG = 'xx-long';

    public function __construct(
        string $title,
        ContentHeaderImage $image = null,
        string $impactStatement = null,
        bool $header = false,
        array $subjects = [],
        Profile $profile = null,
        array $authors = [],
        array $institutions = [],
        string $download = null,
        SocialMediaSharers $socialMediaSharers = null,
        SelectNav $selectNav = null,
        Meta $meta = null,
        string $licence = null,
        AudioPlayer $audioPlayer = null
    ) {
        Assertion::notBlank($title);
        Assertion::allIsInstanceOf($subjects, Link::class);
        Assertion::allIsInstanceOf($authors, Author::class);
        Assertion::allIsInstanceOf($institutions, Institution::class);

        $this->title = $title;
        $this->titleLength = $this->designateTitleLength();

        $this->image = $image;
        $this->impactStatement = $impactStatement;
        if ($header) {
            $this->header = ['possible' => true];
            if ($subjects) {
                $this->header['hasSubjects'] = true;
                $this->header['subjects'] = $subjects;
            }
            if ($profile) {
                $this->header['hasProfile'] = true;
                $this->header['profile'] = $profile;
            }
        }
        if ($authors) {
            $this->authors = ['list' => $authors];
            if ($institutions) {
                $this->institutions = ['list' => $institutions];
            }
        }
        $this->download = $download;
        $this->socialMediaSharers = $socialMediaSharers;
        $this->selectNav = $selectNav;
        $this->meta = $meta;
        $this->licence = $licence;
        $this->audioPlayer = $audioPlayer;
    }

    public function designateTitleLength() : string
    {
        $charCount = mb_strlen(strip_tags($this->title));
        if ($charCount < 20) {
            return self::XX_SHORT;
        }
        if ($charCount <= 38) {
            return self::X_SHORT;
        }
        if ($charCount <= 46) {
            return self::SHORT;
        }
        if ($charCount <= 57) {
            return self::MEDIUM;
        }
        if ($charCount <= 118) {
            return self::LONG;
        }
        if ($charCount <= 155) {
            return self::X_LONG;
        }

        return self::XX_LONG;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/content-header.mustache';
    }
}

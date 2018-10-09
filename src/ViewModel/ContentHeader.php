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

    const LENGTH_LIMITS = [
        19 => 'xx-short',
        38 => 'x-short',
        46 => 'short',
        57 => 'medium',
        118 => 'long',
        155 => 'x-long',
    ];

    const MAX_LENGTH = 'xx-long';

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
        $this->titleLength = ContentHeader::designateTitleLength($this->title);

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

    private static function designateTitleLength($title) : string
    {
        $charCount = mb_strlen(strip_tags($title));

        foreach (self::LENGTH_LIMITS as $maxLength => $value) {
            if ($charCount <= $maxLength) {
                return $value;
            }
        }

        return self::MAX_LENGTH;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/content-header.mustache';
    }
}

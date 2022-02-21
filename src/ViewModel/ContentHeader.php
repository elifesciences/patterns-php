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
    use HasTitleLength;

    private $title;
    private $titleLength;
    private $image;
    private $impactStatement;
    private $header;
    private $breadcrumb;
    private $authors;
    private $institutions;
    private $download;
    private $socialMediaSharers;
    private $contextualData;
    private $selectNav;
    private $meta;
    private $licence;
    private $audioPlayer;

    public function __construct(
        string $title,
        ContentHeaderImage $image = null,
        string $impactStatement = null,
        bool $header = false,
        Breadcrumb $breadcrumb = null,
        array $subjects = [],
        Profile $profile = null,
        array $authors = [],
        array $institutions = [],
        string $download = null,
        SocialMediaSharers $socialMediaSharers = null,
        ContextualData $contextualData = null,
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
        $this->titleLength = $this->determineTitleLength($this->title);

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
        $this->breadcrumb = $breadcrumb;
        if ($authors) {
            $this->authors = ['list' => $authors];
            if ($institutions) {
                $this->institutions = ['list' => $institutions];
            }
        }
        $this->download = $download;
        $this->socialMediaSharers = $socialMediaSharers;
        $this->contextualData = $contextualData;
        $this->selectNav = $selectNav;
        $this->meta = $meta;
        $this->licence = $licence;
        $this->audioPlayer = $audioPlayer;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/content-header-journal.mustache';
    }
}

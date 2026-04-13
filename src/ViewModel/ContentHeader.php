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
    private $download;
    private $socialMediaSharers;
    private $selectNav;
    private $meta;
    private $licence;
    private $audioPlayer;

    /**
     * @var Link|null
     */
    private $signupLink;

    public function __construct(
        string $title,
        ContentHeaderImage $image = null,
        string $impactStatement = null,
        bool $header = false,
        Breadcrumb $breadcrumb = null,
        array $subjects = [],
        Profile $profile = null,
        Authors $authors = null,
        string $download = null,
        SocialMediaSharers $socialMediaSharers = null,
        SelectNav $selectNav = null,
        Meta $meta = null,
        string $licence = null,
        AudioPlayer $audioPlayer = null,
        Link $signupLink = null
    ) {
        Assertion::notBlank($title);
        Assertion::allIsInstanceOf($subjects, Link::class);

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
        $this->authors = $authors;
        $this->download = $download;
        $this->socialMediaSharers = $socialMediaSharers;
        $this->selectNav = $selectNav;
        $this->meta = $meta;
        $this->licence = $licence;
        $this->audioPlayer = $audioPlayer;
        $this->signupLink = $signupLink;
    }

    /**
     * Fluent setter for audioPlayer
     * @param AudioPlayer $audioPlayer
     * @return $this
     */
    public function withAudioPlayer(AudioPlayer $audioPlayer): self
    {
        $this->audioPlayer = $audioPlayer;
        return $this;
    }

    /**
     * Fluent setter for signupLink
     * @param Link $signupLink
     * @return $this
     */
    public function withSignupLink(Link $signupLink): self
    {
        $this->signupLink = $signupLink;
        return $this;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/content-header.mustache';
    }
}

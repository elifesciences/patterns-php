<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;
use function eLife\Patterns\truncate;

final class SocialMediaSharers implements ViewModel
{
    const TWITTER_TITLE_LENGTH = 140 - 1 - 23; // Max - space - URL length

    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $facebookUrl;
    private $twitterUrl;
    private $emailUrl;
    private $redditUrl;

    public function __construct(string $title, string $url)
    {
        Assertion::notBlank($title);
        Assertion::url($url);

        $encodedTitle = urlencode($title);
        $encodedUrl = urlencode($url);

        $this->facebookUrl = "https://facebook.com/sharer/sharer.php?u={$encodedUrl}";
        $this->twitterUrl = $this->buildTwitterUrl($title, $url);
        $this->emailUrl = "mailto:?subject={$encodedTitle}&body={$encodedUrl}";
        $this->redditUrl = "https://reddit.com/submit/?url={$encodedUrl}";
    }

    private function buildTwitterUrl(string $title, string $url) : string
    {
        $encodedTitle = urlencode(truncate($title, self::TWITTER_TITLE_LENGTH));
        $encodedUrl = urlencode($url);

        return "https://twitter.com/intent/tweet/?text={$encodedTitle}&url={$encodedUrl}";
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/social-media-sharers.mustache';
    }

    protected function getLocalStyleSheets() : Traversable
    {
        yield 'resources/assets/css/social-media-sharers.css';
    }
}

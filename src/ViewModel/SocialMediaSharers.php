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
    const TWITTER_LENGTH = 140 - 1;
    const TWITTER_URL_LENGTH = 23;

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
        if (strlen($title) + self::TWITTER_URL_LENGTH > self::TWITTER_LENGTH) {
            $title = truncate($title, self::TWITTER_LENGTH - self::TWITTER_URL_LENGTH);
        }

        $encodedTitle = urlencode($title);
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

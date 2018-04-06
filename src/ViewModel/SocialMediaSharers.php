<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;
use function eLife\Patterns\truncate;
use function rawurlencode;

final class SocialMediaSharers implements ViewModel
{
    const TWITTER_LENGTH = 140 - 1;

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

        $encodedTitle = rawurlencode($title);
        $encodedUrl = rawurlencode($url);

        $this->facebookUrl = "https://facebook.com/sharer/sharer.php?u={$encodedUrl}";
        $this->twitterUrl = $this->buildTwitterUrl($title, $url);
        $this->emailUrl = "mailto:?subject={$encodedTitle}&body={$encodedUrl}";
        $this->redditUrl = "https://reddit.com/submit/?title={$encodedTitle}&url={$encodedUrl}";
    }

    private function buildTwitterUrl(string $title, string $url) : string
    {
        if (strlen($title.$url) > self::TWITTER_LENGTH) {
            $title = truncate($title, self::TWITTER_LENGTH - strlen($url));
        }

        $encodedTitle = rawurlencode($title);
        $encodedUrl = rawurlencode($url);

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

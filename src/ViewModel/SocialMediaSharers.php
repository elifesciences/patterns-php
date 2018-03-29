<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class SocialMediaSharers implements ViewModel
{
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
        Assertion::notBlank($url);

        $encodedTitle = urlencode($title);
        $encodedUrl = urlencode($url);

        $this->facebookUrl = 'https://facebook.com/sharer/sharer.php?u='.$encodedUrl;
        $this->twitterUrl = $this->buildTwitterUrl($title, $url);
        $this->emailUrl = 'mailto:?subject='.$encodedTitle.'&amp;body='.$encodedUrl;
        $this->redditUrl = 'https://reddit.com/submit/?url='.$encodedUrl;
    }

    private function buildTwitterUrl($title, $url)
    {
        // One character shorter than theoretical max to account for space injected by Twitter between the text and url
        $maxLength = 139;
        $stem = 'https://twitter.com/intent/tweet/';
        $encodedUrl = urlencode($url);

        if (strlen($title . $url) <= $maxLength) {
            return $stem . '?text=' . urlencode($title) . '&amp;url=' . $encodedUrl;
        }

        $ellipsis = ' &#8230;';
        // -1 to account for the display of the ellipsis
        $truncatedTitle = substr($title,0, $maxLength - strlen($url) - 1) . $ellipsis;
        return $stem . '?text=' . urlencode($truncatedTitle) . '&amp;url=' . $encodedUrl;
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

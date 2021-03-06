<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;
use function rawurlencode;

final class SocialMediaSharers implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

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
        $this->twitterUrl = "https://twitter.com/intent/tweet/?text={$encodedTitle}&url={$encodedUrl}";
        $this->emailUrl = "mailto:?subject={$encodedTitle}&body={$encodedUrl}";
        $this->redditUrl = "https://reddit.com/submit/?title={$encodedTitle}&url={$encodedUrl}";
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/social-media-sharers.mustache';
    }
}

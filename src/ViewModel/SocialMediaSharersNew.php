<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;
use function rawurlencode;

final class SocialMediaSharersNew implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $emailUrl = null;
    private $facebookUrl;
    private $twitterUrl;
    private $linkedInUrl;
    private $redditUrl;

    public function __construct(string $title, string $url, $includeEmail = true)
    {
        Assertion::notBlank($title);
        Assertion::url($url);

        $encodedTitle = rawurlencode($title);
        $encodedUrl = rawurlencode($url);

        if ($includeEmail) {
            $this->emailUrl = "mailto:?subject={$encodedTitle}&body={$encodedUrl}";
        }

        $this->facebookUrl = "https://facebook.com/sharer/sharer.php?u={$encodedUrl}";
        $this->twitterUrl = "https://twitter.com/intent/tweet/?text={$encodedTitle}&url={$encodedUrl}";
        $this->linkedInUrl = "https://www.linkedin.com/shareArticle?title={$encodedTitle}&url={$encodedUrl}";
        $this->redditUrl = "https://reddit.com/submit/?title={$encodedTitle}&url={$encodedUrl}";
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/social-media-sharers-journal.mustache';
    }
}
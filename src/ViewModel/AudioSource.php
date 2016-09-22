<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class AudioSource implements CastsToArray
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    protected $mimeType;
    protected $src;

    public function __construct(string $src, string $mediaType)
    {
        Assertion::regex($mediaType,
            '/^(audio\/[a-zA-Z0-9!#$%^&\*_\-\+{}\|\'.`~]+)(; *[a-zA-Z0-9!#$%^&\*_\-\+{}\|\'.`~]+=(([a-zA-Z0-9\.\-]+)|(".+")))*$/');

        $this->src = $src;
        $this->mimeType = [
            'forMachine' => $mediaType,
            'forHuman' => $this->guessHumanType($mediaType),
        ];
    }

    private function guessHumanType(string $mediaType)
    {
        $parts = explode(';', $mediaType);

        switch ($parts[0]) {
            case 'audio/mp3':
            case 'audio/mpeg':
                return 'MP3';
            case 'audio/ogg':
                return 'OGG';
            case 'audio/webm':
                return 'WebM';
        }

        return $mediaType;
    }
}

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

    const MIME_TYPES = [
        AudioSource::TYPE_MP3,
        AudioSource::TYPE_MPEG,
        AudioSource::TYPE_WEBM,
        AudioSource::TYPE_OGG,
    ];

    const TYPE_MP3 = [
      'forHuman' => 'mp3',
      'forMachine' => 'audio/mp3'
    ];

    const TYPE_MPEG = [
      'forHuman' => 'mpeg',
      'forMachine' => 'audio/mpeg'
    ];

    const TYPE_WEBM = [
      'forHuman' => 'webm',
      'forMachine' => 'audio/webm'
    ];

    const TYPE_OGG = [
      'forHuman' => 'ogg',
      'forMachine' => 'audio/ogg'
    ];

    protected $mimeType;
    protected $src;

    public function __construct(
      $src,
      $type
    ) {
        Assertion::inArray($type, static::MIME_TYPES);

        $this->src = $src;
        $this->mimeType = $type;
    }

}

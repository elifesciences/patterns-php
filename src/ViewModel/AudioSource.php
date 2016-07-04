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
        'mp3' => 'audio/mp3',
        'mpeg' => 'audio/mpeg',
        'webm' => 'audio/webm',
        'ogg' => 'audio/ogg',
    ];

    protected $mime_type;
    protected $type;
    protected $src;

    public function __construct(
      $src,
      $type
    ) {
        Assertion::inArray(
            $type,
            array_keys(static::MIME_TYPES),
            'Type must be one of the following: (' . implode(', ', static::MIME_TYPES) . ')'
        );

        $this->src = $src;
        $this->type = $type;
        $this->mime_type = static::MIME_TYPES[$type];
    }

}

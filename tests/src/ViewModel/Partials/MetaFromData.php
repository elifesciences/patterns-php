<?php

namespace tests\eLife\Patterns\ViewModel\Partials;

use eLife\Patterns\ViewModel\Date;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Meta;
use DateTimeImmutable;

trait MetaFromData
{
    final protected function metaFromData(array $data) : Meta
    {
        if (isset($data['url']) && $data['url'] !== null) {
            if (isset($data['date']['forMachine'])) {
                return Meta::withLink(
                    new Link($data['text'], $data['url']),
                    new Date(new DateTimeImmutable($data['date']['forMachine']))
                );
            }
            else {
                return Meta::withLink(
                    new Link($data['text'], $data['url'])
                );
            }
        }
        if (isset($data['text'])) {
            if (isset($data['date']['forMachine'])) {
                return Meta::withText(
                    $data['text'],
                    new Date(new DateTimeImmutable($data['date']['forMachine']))
                );
            }
            else {
                return Meta::withText(
                    $data['text']
                );
            }
        }
        if (isset($data['date'])) {
            return Meta::withDate(
                new Date(new DateTimeImmutable($data['date']['forMachine']))
            );
        }
        // Throw maybe? Or expected.
        return null;
    }
}

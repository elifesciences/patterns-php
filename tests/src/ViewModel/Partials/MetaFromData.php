<?php

namespace tests\eLife\Patterns\ViewModel\Partials;

use DateTimeImmutable;
use eLife\Patterns\ViewModel\Date;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Meta;

trait MetaFromData
{
    final protected function metaFromData(array $data) : Meta
    {
        if ($data['url']) {
            if (isset($data['date']['forMachine'])) {
                return Meta::withLink(
                    new Link($data['text'], $data['url']),
                    Date::simple(new DateTimeImmutable($data['date']['forMachine']))
                );
            } else {
                return Meta::withLink(
                    new Link($data['text'], $data['url'])
                );
            }
        }
        if (isset($data['text'])) {
            if (isset($data['date']['forMachine'])) {
                return Meta::withText(
                    $data['text'],
                    Date::simple(new DateTimeImmutable($data['date']['forMachine']))
                );
            } else {
                return Meta::withText(
                    $data['text']
                );
            }
        }
        if (isset($data['date'])) {
            return Meta::withDate(
                Date::simple(new DateTimeImmutable($data['date']['forMachine']))
            );
        }
        // Throw maybe? Or expected.
        return null;
    }
}

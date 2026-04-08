<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\FormFieldInfoLink;
use PHPUnit\Framework\Attributes\Test;

final class FormFieldInfoLinkTest extends ViewModelTest
{
    #[Test]
    public function it_has_data()
    {
        $data = [
            'name' => 'some text',
            'url' => 'http://example.com',
        ];
        $formFieldInfoLink = new FormFieldInfoLink($data['name'], $data['url']);

        $this->assertSame($data['name'], $formFieldInfoLink['name']);
        $this->assertSame($data['url'], $formFieldInfoLink['url']);

        $this->assertSame($data, $formFieldInfoLink->toArray());
    }

    public static function viewModelProvider() : array
    {
        return [
            [new FormFieldInfoLink('name', 'https://url')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/form-field-info-link.mustache';
    }
}

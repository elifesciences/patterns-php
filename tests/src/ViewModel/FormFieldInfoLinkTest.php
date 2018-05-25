<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\FormFieldInfoLink;

final class FormFieldInfoLinkTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'name' => 'some text',
            'url' => 'http://example.com',
            'alignLeft' => true,
        ];
        $formFieldInfoLink = FormFieldInfoLink::alignedLeft($data['name'], $data['url']);

        $this->assertSame($data['name'], $formFieldInfoLink['name']);
        $this->assertSame($data['url'], $formFieldInfoLink['url']);
        $this->assertSame($data['alignLeft'], $formFieldInfoLink['alignLeft']);

        $this->assertSame($data, $formFieldInfoLink->toArray());
    }

    public function it_can_be_aligned_right()
    {
        $formFieldInfoLink = FormFieldInfoLink::alignedRight('name', 'https://url');
        $this->assertFalse($formFieldInfoLink['alignLeft']);
    }

    public function viewModelProvider() : array
    {
        return [
            'alignedLeft' => [FormFieldInfoLink::alignedLeft('name', 'https://url')],
            'alignedRight' => [FormFieldInfoLink::alignedRight('name', 'https://url')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/form-field-info-link.mustache';
    }
}

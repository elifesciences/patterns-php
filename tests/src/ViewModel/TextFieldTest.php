<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\FormLabel;
use eLife\Patterns\ViewModel\TextField;

final class TextFieldTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'inputType' => 'email',
            'label' => [
                'labelText' => 'label',
                'for' => 'id',
                'isVisuallyHidden' => false,
            ],
            'name' => 'id',
        ];
        $textField = TextField::emailInput(
            new FormLabel($data['label']['labelText'], $data['label']['for']),
            $data['name']
        );

        $this->assertSame($data['name'], $textField['name']);
        $this->assertSame($data['label'], $textField['label']->toArray());
        $this->assertSame($data, $textField->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'email input' => [TextField::emailInput(new FormLabel('label', 'id'), 'id')],
            'text input' => [TextField::textInput(new FormLabel('label', 'id'), 'id')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/text-field.mustache';
    }
}

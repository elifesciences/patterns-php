<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\FormLabel;
use eLife\Patterns\ViewModel\TextArea;
use InvalidArgumentException;

class TextAreaTest extends ViewModelTest
{


    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'label' =>
                [
                    'labelText' => 'label text',
                    'for' => 'someid',
                    'isVisuallyHidden' => false,
                ],
            'name' => 'name',
            'id' => 'someid',
            'value' => 'default value',
        ];
        $textArea = new TextArea(new FormLabel($data['label']['labelText'], $data['label']['for']), $data['id'], $data['name'], $data['value']);

        $this->assertSameWithoutOrder($data, $textArea);
    }

    /**
     * @test
     */
    public function it_must_have_matching_ids_with_label() {
        $this->expectException(InvalidArgumentException::class);
        new TextArea(new FormLabel('label text', 'NOT THE SAME'), 'someid', 'name', 'default value');
    }

    public function viewModelProvider() : array
    {
        return [
            [ new TextArea(new FormLabel('label text', 'someid'), 'someid', 'name', 'default value') ]
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/text-area.mustache';
    }
}

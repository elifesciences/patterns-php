<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\HiddenField;

final class HiddenFieldTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'name' => 'name',
            'id' => 'id',
            'value' => 'value',
        ];

        $field = new HiddenField($data['name'], $data['id'], $data['value']);

        $this->assertSame($data['name'], $field['name']);
        $this->assertSame($data['id'], $field['id']);
        $this->assertSame($data['value'], $field['value']);
        $this->assertSame($data, $field->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [new HiddenField()],
            'complete' => [new HiddenField('name', 'id', 'value')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/hidden-field.mustache';
    }
}

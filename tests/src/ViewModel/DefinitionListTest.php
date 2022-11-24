<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\DefinitionList;
use InvalidArgumentException;

final class DefinitionListTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'items' => [
                [
                    'term' => 'foo',
                    'descriptors' => ['bar'],
                ],
                [
                    'term' => 'baz',
                    'descriptors' => ['qux', 'quxx'],
                ],
            ],
        ];

        $list = new DefinitionList(array_reduce($data['items'], function (array $carry, array $item) {
            $carry[$item['term']] = $item['descriptors'];

            return $carry;
        }, []));

        $this->assertSame($data['items'], $list['items']);
        $this->assertSame($data, $list->toArray());

        $data = [
            'items' => [
                [
                    'term' => 'foo',
                    'descriptors' => ['bar'],
                ],
                [
                    'term' => 'baz',
                    'descriptors' => ['qux', 'quxx'],
                ],
            ],
            'variant' => 'inline',
        ];

        $list = new DefinitionList(array_reduce($data['items'], function (array $carry, array $item) {
            $carry[$item['term']] = $item['descriptors'];

            return $carry;
        }, []), $data['variant']);

        $this->assertSame($data['items'], $list['items']);
        $this->assertSame($data['variant'], $list['variant']);
        $this->assertSame($data, $list->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_items()
    {
        $this->expectException(InvalidArgumentException::class);

        new DefinitionList([]);
    }

    /**
     * @test
     */
    public function it_must_have_items_containing_items()
    {
        $this->expectException(InvalidArgumentException::class);

        new DefinitionList(['foo' => []]);
    }

    /**
     * @test
     */
    public function it_may_contain_single_items()
    {
        $list = new DefinitionList(['foo' => 'bar']);

        $this->assertSame(['bar'], $list['items'][0]['descriptors']);
    }

    public function viewModelProvider() : array
    {
        return [
            'expanded' => [new DefinitionList(['foo' => ['bar']])],
            'variant' => [new DefinitionList(['foo' => ['bar']], 'inline')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/definition-list.mustache';
    }
}

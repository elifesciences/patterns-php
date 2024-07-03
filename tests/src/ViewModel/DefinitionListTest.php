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

        $list = DefinitionList::basic(array_reduce($data['items'], function (array $carry, array $item) {
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

        $list = DefinitionList::inline(array_reduce($data['items'], function (array $carry, array $item) {
            $carry[$item['term']] = $item['descriptors'];

            return $carry;
        }, []));

        $this->assertSame($data['items'], $list['items']);
        $this->assertSame($data['variant'], $list['variant']);
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
            'variant' => 'timeline',
            'color' => 'vor',
            'label' => 'Version history'
        ];

        $list = DefinitionList::timeline($data['items'], $data['color'], $data['label']);

        $this->assertSame($data['items'], $list['items']);
        $this->assertSame($data['variant'], $list['variant']);
        $this->assertSame($data['color'], $list['color']);
        $this->assertSame($data['label'], $list['label']);
        $this->assertSame($data, $list->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_items()
    {
        $this->expectException(InvalidArgumentException::class);

        DefinitionList::basic([]);
    }

    /**
     * @test
     */
    public function it_must_have_items_containing_items()
    {
        $this->expectException(InvalidArgumentException::class);

        DefinitionList::basic(['foo' => []]);
    }

    /**
     * @test
     */
    public function it_may_contain_single_items()
    {
        $list = DefinitionList::basic(['foo' => 'bar']);

        $this->assertSame(['bar'], $list['items'][0]['descriptors']);
    }

    /**
     * @test
     */
    public function it_must_have_a_valid_color()
    {
        $this->expectException(InvalidArgumentException::class);

        DefinitionList::timeline([['term' => 'foo', 'descriptors' => ['bar']]], 'not valid color');
    }

    public function viewModelProvider() : array
    {
        return [
            'expanded' => [DefinitionList::basic(['foo' => ['bar']])],
            'inline' => [DefinitionList::inline(['foo' => ['bar']])],
            'timeline' => [DefinitionList::timeline([['term' => 'foo', 'descriptors' => ['bar']]], 'vor')],
            'timeline with label' => [DefinitionList::timeline([['term' => 'foo', 'descriptors' => ['bar']]], 'vor', 'Version history')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/definition-list.mustache';
    }
}

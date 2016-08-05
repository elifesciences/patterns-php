<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Author;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Reference;
use eLife\Patterns\ViewModel\ReferenceList;
use eLife\Patterns\ViewModel\ReferenceListItem;

final class ReferenceListTest extends ViewModelTest
{
    private static function referenceStub() : Reference
    {
        return new Reference('title of reference', 'the origin', '/', 'the secondary', [
            Author::asText('Person Foo'),
            Author::asLink(new Link('Person Bar', '/bar')),
        ], [
            new Link('Download', '/download'),
            new Link('View', '/view'),
        ]);
    }

    private static function referenceStubArray() : array
    {
        return self::referenceStub()->toArray();
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'references' => [
                ['bibId' => ['full' => 'full id 1', 'ordinal' => 1], 'reference' => self::referenceStubArray()],
                ['bibId' => ['full' => 'full id 2', 'ordinal' => 2], 'reference' => self::referenceStubArray()],
                ['bibId' => ['full' => 'full id 3', 'ordinal' => 3], 'reference' => self::referenceStubArray()],
                ['bibId' => ['full' => 'full id 4', 'ordinal' => 4], 'reference' => self::referenceStubArray()],
                ['bibId' => ['full' => 'full id 5', 'ordinal' => 5], 'reference' => self::referenceStubArray()],
            ],
        ];
        $referenceList = new ReferenceList(
            new ReferenceListItem($data['references'][0]['bibId']['full'], $data['references'][0]['bibId']['ordinal'], self::referenceStub()),
            new ReferenceListItem($data['references'][1]['bibId']['full'], $data['references'][1]['bibId']['ordinal'], self::referenceStub()),
            new ReferenceListItem($data['references'][2]['bibId']['full'], $data['references'][2]['bibId']['ordinal'], self::referenceStub()),
            new ReferenceListItem($data['references'][3]['bibId']['full'], $data['references'][3]['bibId']['ordinal'], self::referenceStub()),
            new ReferenceListItem($data['references'][4]['bibId']['full'], $data['references'][4]['bibId']['ordinal'], self::referenceStub())
        );

        $this->assertSameWithoutOrder($data, $referenceList);
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new ReferenceList(
                    new ReferenceListItem('full id 1', 1, self::referenceStub()),
                    new ReferenceListItem('full id 2', 2, self::referenceStub()),
                    new ReferenceListItem('full id 3', 3, self::referenceStub()),
                    new ReferenceListItem('full id 4', 4, self::referenceStub()),
                    new ReferenceListItem('full id 5', 5, self::referenceStub())
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/reference-list.mustache';
    }
}

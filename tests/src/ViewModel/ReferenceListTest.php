<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Author;
use eLife\Patterns\ViewModel\Doi;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Reference;
use eLife\Patterns\ViewModel\ReferenceAuthorList;
use eLife\Patterns\ViewModel\ReferenceList;

final class ReferenceListTest extends ViewModelTest
{
    private static function referenceStub(string $id) : Reference
    {
        return Reference::withDoi('title', new Doi('10.7554/eLife.10181.001'), $id, 'referenceLabel', ['origin'], [new ReferenceAuthorList([Author::asText('author')], 'suffix')], [new Link('abstract', 'link')]);
    }

    private static function referenceStubArray(string $id) : array
    {
        return self::referenceStub($id)->toArray();
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'references' => [
                self::referenceStubArray('full id 1'),
                self::referenceStubArray('full id 2'),
                self::referenceStubArray('full id 3'),
                self::referenceStubArray('full id 4'),
                self::referenceStubArray('full id 5'),
            ],
        ];
        $referenceList = new ReferenceList(
            self::referenceStub($data['references'][0]['bibId']),
            self::referenceStub($data['references'][1]['bibId']),
            self::referenceStub($data['references'][2]['bibId']),
            self::referenceStub($data['references'][3]['bibId']),
            self::referenceStub($data['references'][4]['bibId'])
        );

        $this->assertSameWithoutOrder($data, $referenceList);
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new ReferenceList(
                    self::referenceStub('full id 1'),
                    self::referenceStub('full id 2'),
                    self::referenceStub('full id 3'),
                    self::referenceStub('full id 4'),
                    self::referenceStub('full id 5')
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/reference-list.mustache';
    }
}

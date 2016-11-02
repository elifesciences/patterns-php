<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Doi;
use InvalidArgumentException;

final class DoiTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'doi' => '10.7554/eLife.10181.001',
            'variant' => 'article-section',
            'isTruncated' => false,
        ];
        $doi = new Doi($data['doi'], Doi::ARTICLE_SECTION, $data['isTruncated']);

        $this->assertSame($data['doi'], $doi['doi']);
        $this->assertSame($data, $doi->toArray());
    }

    public function it_must_be_a_doi()
    {
        $this->expectException(InvalidArgumentException::class);

        new Doi('foo');
    }

    public function viewModelProvider() : array
    {
        return [
            [new Doi('10.7554/eLife.10181.001')],
            [new Doi('10.7554/eLife.10181.001', null, true)],
            [new Doi('10.7554/eLife.10181.001', Doi::ASSET)],
            [new Doi('10.7554/eLife.10181.001', Doi::ARTICLE_SECTION)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/doi.mustache';
    }
}

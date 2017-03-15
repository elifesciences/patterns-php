<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\SectionListingLink;
use InvalidArgumentException;

final class SectionListingLinkTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'text' => 'foo',
            'targetFragmentId' => 'id',
        ];

        $subjectsListLink = new SectionListingLink($data['text'], $data['targetFragmentId']);

        $this->assertSame($data['text'], $subjectsListLink['text']);
        $this->assertSame($data['targetFragmentId'], $subjectsListLink['targetFragmentId']);
        $this->assertSame($data, $subjectsListLink->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_text()
    {
        $this->expectException(InvalidArgumentException::class);

        new SectionListingLink('', 'foo');
    }

    /**
     * @test
     */
    public function it_must_have_a_target_fragment_id()
    {
        $this->expectException(InvalidArgumentException::class);

        new SectionListingLink('foo', '');
    }

    public function viewModelProvider() : array
    {
        return [
            [new SectionListingLink('text', 'id')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/section-listing-link.mustache';
    }
}

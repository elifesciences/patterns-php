<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\InlineProfile;
use eLife\Patterns\ViewModel\Picture;
use InvalidArgumentException;

final class InlineProfileTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'image' => [
                'fallback' => [
                    'altText' => '',
                    'defaultPath' => '/default/path',
                ],
            ],
            'text' => 'text',
        ];

        $infoBar = new InlineProfile(new Picture([], new Image($data['image']['fallback']['defaultPath'])), $data['text']);

        $this->assertSame($data['text'], $infoBar['text']);
        $this->assertSameWithoutOrder($data['image'], $infoBar['image']);
        $this->assertSame($data, $infoBar->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_blank_text()
    {
        $this->expectException(InvalidArgumentException::class);

        new InlineProfile(new Picture([], new Image('path')), '');
    }

    public function viewModelProvider() : array
    {
        return [
            [new InlineProfile(new Picture([], new Image('path')), 'text')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/inline-profile.mustache';
    }
}

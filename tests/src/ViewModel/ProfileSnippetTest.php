<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Picture;
use eLife\Patterns\ViewModel\ProfileSnippet;

final class ProfileSnippetTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'image' => [
                'fallback' => [
                    'altText' => 'the alt text',
                    'defaultPath' => '/default/path',
                    'srcset' => '/path/to/image/500/wide 2x, /default/path 1x',
                ],
            ],
            'title' => 'Title McTitle',
            'name' => 'Name McName',
        ];
        $profileSnippet = new ProfileSnippet($data['name'], $data['title'],
            new Picture([], new Image('/default/path', ['2' => '/path/to/image/500/wide', '1' => '/default/path'], 'the alt text'))
        );

        $this->assertSame($data['name'], $profileSnippet['name']);
        $this->assertSame($data['title'], $profileSnippet['title']);
        $this->assertSame($data['image'], $profileSnippet['image']->toArray());

        $this->assertSame($data, $profileSnippet->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new ProfileSnippet(
                    'Name McName',
                    'Title McTitle',
                    new Picture(
                        [],
                        new Image(
                            '/default/path',
                            ['2' => '/path/to/image/500/wide', '1' => '/default/path'],
                            'the alt text'
                        )
                    )
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/profile-snippet.mustache';
    }
}

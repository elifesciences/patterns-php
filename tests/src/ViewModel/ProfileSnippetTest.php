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
            'picture' => [
                    'pictureClasses' => 'profile-snippet__picture',
                    'fallback' => [
                            'altText' => 'the alt text',
                            'classes' => 'profile-snippet__image',
                            'defaultPath' => '/default/path',
                            'srcset' => '/path/to/image/500/wide 500w, /default/path 250w',
                        ],
                    'sources' => [
                            0 => [
                                    'srcset' => '/path/to/svg',
                                ],
                        ],
                ],
            'title' => 'Title McTitle',
            'name' => 'Name McName',
        ];
        $profileSnippet = new ProfileSnippet($data['name'], $data['title'], new Picture([
            ['srcset' => '/path/to/svg'],
        ], new Image('/default/path', [500 => '/path/to/image/500/wide', 250 => '/default/path'], 'the alt text')));

        $this->assertSame($data['name'], $profileSnippet['name']);
        $this->assertSame($data['title'], $profileSnippet['title']);
        $this->assertSame($data['picture'], $profileSnippet['picture']->toArray());

        $this->assertSame(ProfileSnippet::PICTURE_CLASSES, $profileSnippet['picture']['pictureClasses']);
        $this->assertSame(ProfileSnippet::FALLBACK_CLASSES, $profileSnippet['picture']['fallback']['classes']);

        $this->assertSame($data, $profileSnippet->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [new ProfileSnippet('Name McName', 'Title McTitle', new Picture([
                ['srcset' => '/path/to/svg'],
            ], new Image('/default/path', [500 => '/path/to/image/500/wide', 250 => '/default/path'], 'the alt text')))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/profile-snippet.mustache';
    }
}

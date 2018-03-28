<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\SocialMediaSharers;
use InvalidArgumentException;

final class SocialMediaSharersTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'raw' => [
                'title'=> 'Some article title',
                'url' => 'https://example.com/some-article-url',
            ],
            'encoded' => [
                'facebookUrl' => 'https://facebook.com/sharer/sharer.php?u=https%3A%2F%2Fexample.com%2Fsome-article-url',
                'twitterUrl' => 'https://twitter.com/intent/tweet/?text=Some+article+title&amp;url=https%3A%2F%2Fexample.com%2Fsome-article-url',
                'emailUrl' => 'mailto:?subject=Some+article+title&amp;body=https%3A%2F%2Fexample.com%2Fsome-article-url',
                'redditUrl' => 'https://reddit.com/submit/?url=https%3A%2F%2Fexample.com%2Fsome-article-url'
            ],
        ];
        $socialMediaSharers = new SocialMediaSharers($data['raw']['title'], $data['raw']['url']);

        $this->assertSame($data['encoded']['facebookUrl'], $socialMediaSharers['facebookUrl']);
        $this->assertSame($data['encoded']['twitterUrl'], $socialMediaSharers['twitterUrl']);
        $this->assertSame($data['encoded']['emailUrl'], $socialMediaSharers['emailUrl']);
        $this->assertSame($data['encoded']['redditUrl'], $socialMediaSharers['redditUrl']);
        $this->assertSame($data['encoded'], $socialMediaSharers->toArray());
    }

    /**
     * @test
     */
    public function it_must_be_given_a_title()
    {
        $this->expectException(InvalidArgumentException::class);

        new SocialMediaSharers('', 'https://example.com/some-article-url');
    }

    /**
     * @test
     */
    public function it_must_be_given_a_url()
    {
        $this->expectException(InvalidArgumentException::class);

        new SocialMediaSharers('Some article title', '');
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new SocialMediaSharers('Some article title', 'https://example.com/some-article-url')
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/social-media-sharers.mustache';
    }
}

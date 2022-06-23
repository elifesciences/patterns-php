<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\SocialMediaSharersNew;
use InvalidArgumentException;

final class SocialMediaSharersNewTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'raw' => [
                'title' => 'Some article title',
                'url' => 'https://example.com/some-article-url',
            ],
            'encoded' => [
                'emailUrl' => 'mailto:?subject=Some%20article%20title&body=https%3A%2F%2Fexample.com%2Fsome-article-url',
                'facebookUrl' => 'https://facebook.com/sharer/sharer.php?u=https%3A%2F%2Fexample.com%2Fsome-article-url',
                'twitterUrl' => 'https://twitter.com/intent/tweet/?text=Some%20article%20title&url=https%3A%2F%2Fexample.com%2Fsome-article-url',
                'linkedInUrl' => 'https://www.linkedin.com/shareArticle?title=Some%20article%20title&url=https%3A%2F%2Fexample.com%2Fsome-article-url',
                'redditUrl' => 'https://reddit.com/submit/?title=Some%20article%20title&url=https%3A%2F%2Fexample.com%2Fsome-article-url',
            ],
        ];
        $socialMediaSharers = new SocialMediaSharersNew($data['raw']['title'], $data['raw']['url']);

        $this->assertSame($data['encoded']['emailUrl'], $socialMediaSharers['emailUrl']);
        $this->assertSame($data['encoded']['facebookUrl'], $socialMediaSharers['facebookUrl']);
        $this->assertSame($data['encoded']['twitterUrl'], $socialMediaSharers['twitterUrl']);
        $this->assertSame($data['encoded']['linkedInUrl'], $socialMediaSharers['linkedInUrl']);
        $this->assertSame($data['encoded']['redditUrl'], $socialMediaSharers['redditUrl']);
        $this->assertSame($data['encoded'], $socialMediaSharers->toArray());
    }

    /**
     * @test
     */
    public function it_must_be_given_a_title()
    {
        $this->expectException(InvalidArgumentException::class);

        new SocialMediaSharersNew('', 'https://example.com/some-article-url');
    }

    /**
     * @test
     */
    public function it_must_be_given_a_url()
    {
        $this->expectException(InvalidArgumentException::class);

        new SocialMediaSharersNew('Some article title', 'foo');
    }

    /**
     * @test
     */
    public function it_may_include_an_email_url()
    {
        $with = new SocialMediaSharersNew('Some article title', 'https://example.com/some-article-url', true);
        $without = new SocialMediaSharersNew('Some article title', 'https://example.com/some-article-url', false);

        $this->assertArrayHasKey('emailUrl', $with->toArray());
        $this->assertArrayNotHasKey('emailUrl', $without->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new SocialMediaSharersNew('Some article title', 'https://example.com/some-article-url'),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/social-media-sharers-journal.mustache';
    }
}
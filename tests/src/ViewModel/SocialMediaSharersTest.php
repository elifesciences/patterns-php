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
                'title' => 'Some article title',
                'url' => 'https://example.com/some-article-url',
            ],
            'encoded' => [
                'facebookUrl' => 'https://facebook.com/sharer/sharer.php?u=https%3A%2F%2Fexample.com%2Fsome-article-url',
                'twitterUrl' => 'https://twitter.com/intent/tweet/?text=Some+article+title&amp;url=https%3A%2F%2Fexample.com%2Fsome-article-url',
                'emailUrl' => 'mailto:?subject=Some+article+title&amp;body=https%3A%2F%2Fexample.com%2Fsome-article-url',
                'redditUrl' => 'https://reddit.com/submit/?url=https%3A%2F%2Fexample.com%2Fsome-article-url',
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
    public function its_twitterUrl_parameter_values_are_correctly_formed()
    {
        // One character shorter than theoretical max to account for space injected by Twitter between the text and url
        $overallMaxLength = 139;

        $tweets = [
            [
                'url' => 'https://elifesciences.org/articles/34901',
                'title' => 'Retrotransposons: On the move',
            ],
            [
                'url' => 'https://elifesciences.org/labs/0af6527f/building-a-pattern-library-for-scholarly-publishing',
                'title' => 'Building a pattern library for scholarly publishing',
            ],
            [
                'url' => 'https://elifesciences.org/labs/0a677ba3/prototyping-tools-to-improve-the-understanding-of-science',
                'title' => 'Prototyping tools to improve the understanding of science',
            ],
            [
                'url' => 'https://elifesciences.org/inside-elife/912b0679/early-career-advisory-group-elife-welcomes-150-ambassadors-of-good-practice-in-science',
                'title' => 'Early-Career Advisory Group: eLife welcomes 150 Ambassadors of good practice in science',
            ],
        ];

        foreach ($tweets as $tweet) {
            $url = $tweet['url'];
            $title = $tweet['title'];

            $twitterUrl = (new SocialMediaSharers($title, $url))['twitterUrl'];

            preg_match('/url=([^&]+)/', $twitterUrl, $urlMatch);
            $decodedUrl = urldecode($urlMatch[1]);
            $this->assertEquals($url, $decodedUrl);

            preg_match('/text=([^&]+)/', $twitterUrl, $textMatch);
            $decodedText = urldecode($textMatch[1]);
            if ($title === $decodedText) {
                $this->assertLessThanOrEqual($overallMaxLength, strlen($decodedText.$decodedUrl));
            } else {
                // The title has been truncated to stop the overall tweet being too long
                $ellipsis = ' &#8230;';
                // -1 to account for the display of the ellipsis
                $charCountTruncatedTitle = $overallMaxLength - strlen($decodedUrl) - 1;
                $this->assertEquals(substr($title, 0, $charCountTruncatedTitle).$ellipsis, $decodedText);
                $this->assertLessThanOrEqual($overallMaxLength + strlen($ellipsis) - 1, strlen($decodedText));
            }
        }
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
                new SocialMediaSharers('Some article title', 'https://example.com/some-article-url'),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/social-media-sharers.mustache';
    }
}

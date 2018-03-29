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
    public function its_facebookUrl_is_correctly_formed()
    {
        $url = 'https://elifesciences.org/articles/34901';
        $facebookUrl = (new SocialMediaSharers('Retrotransposons: On the move', $url))['facebookUrl'];
        $this->assertEquals('https://facebook.com/sharer/sharer.php?u='.urlencode($url), $facebookUrl);
    }

    /**
     * @test
     */
    public function its_redditUrl_is_correctly_formed()
    {
        $url = 'https://elifesciences.org/articles/34901';
        $redditUrl = (new SocialMediaSharers('Retrotransposons: On the move', $url))['redditUrl'];
        $this->assertEquals('https://reddit.com/submit/?url='.urlencode($url), $redditUrl);
    }

    /**
     * @test
     */
    public function its_emailUrl_is_correctly_formed()
    {
        $title = 'Retrotransposons: On the move';
        $url = 'https://elifesciences.org/articles/34901';
        $emailUrl = (new SocialMediaSharers($title, $url))['emailUrl'];
        $this->assertEquals('mailto:?subject='.urlencode($title).'&amp;body='.urlencode($url), $emailUrl);
    }

    /**
     * @test
     */
    public function its_twitterUrl_is_correctly_formed()
    {
        // One character shorter than theoretical max to account for space injected by Twitter between the text and url
        $overallMaxLength = 139;

        $tweets = [
            [
                'title' => 'Retrotransposons: On the move',
                'url' => 'https://elifesciences.org/articles/34901',
            ],
            [
                'title' => 'Early-Career Advisory Group: eLife welcomes 150 Ambassadors of good practice in science',
                'url' => 'https://elifesciences.org/inside-elife/912b0679/early-career-advisory-group-elife-welcomes-150-ambassadors-of-good-practice-in-science',
            ],
        ];

        foreach ($tweets as $tweet) {
            $title = $tweet['title'];
            $url = $tweet['url'];

            $twitterUrl = (new SocialMediaSharers($title, $url))['twitterUrl'];
            $this->assertStringStartsWith('https://twitter.com/intent/tweet/', $twitterUrl);

            preg_match('/url=([^&]+)/', $twitterUrl, $urlMatch);
            $this->assertEquals(urlencode($url), $urlMatch[1]);
            $decodedUrl = urldecode($urlMatch[1]);

            preg_match('/text=([^&]+)/', $twitterUrl, $textMatch);
            $decodedText = urldecode($textMatch[1]);
            if (urlencode($title) === $textMatch[1]) {
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

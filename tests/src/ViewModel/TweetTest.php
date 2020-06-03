<?php

namespace tests\eLife\Patterns\ViewModel;

use DateTimeImmutable;
use eLife\Patterns\ViewModel\Date;
use eLife\Patterns\ViewModel\Tweet;

final class TweetTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'url' => 'https://twitter.com/eLife/status/1225868108168093696',
            'accountId' => 'eLife',
            'accountLabel' => 'eLife - the journal',
            'text' => 'tweet text',
            'date' => [
                'isExpanded' => false,
                'isUpdated' => false,
                'forHuman' => [
                    'dayOfMonth' => 7,
                    'month' => 'Feb',
                    'year' => 2020,
                ],
                'forMachine' => '2020-02-07',
            ],
            'hideConversation' => false,
            'hideCards' => false,
        ];
        $tweet = new Tweet($data['url'], $data['accountId'], $data['accountLabel'], $data['text'], Date::simple(new DateTimeImmutable('2020-02-07')), $data['hideConversation'], $data['hideCards']);

        $this->assertSame($data, $tweet->toArray());
        $this->assertSame($data['url'], $tweet['url']);
        $this->assertSame($data['accountId'], $tweet['accountId']);
        $this->assertSame($data['accountLabel'], $tweet['accountLabel']);
        $this->assertSame($data['text'], $tweet['text']);
        $this->assertSame($data['date'], $tweet['date']->toArray());
        $this->assertSame($data['hideConversation'], $tweet['hideConversation']);
        $this->assertSame($data['hideCards'], $tweet['hideCards']);
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [new Tweet('#', 'accountId', 'accountLabel', 'text', Date::simple(new DateTimeImmutable()))],
            'complete' => [new Tweet('#', 'accountId', 'accountLabel', 'text', Date::simple(new DateTimeImmutable()), false, false)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/tweet.mustache';
    }
}

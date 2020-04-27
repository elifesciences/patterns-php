<?php

namespace tests\eLife\Patterns\ViewModel;

use DateTimeImmutable;
use eLife\Patterns\ViewModel\Date;
use eLife\Patterns\ViewModel\Paragraph;
use eLife\Patterns\ViewModel\Tweet;

final class TweetTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'url' => 'http://www.example.com/',
            'accountId' => 'accountId',
            'accountLabel' => 'accountLabel',
            'text' => [(new Paragraph('tweet'))->toArray()],
            'date' => Date::simple(new DateTimeImmutable('2000-01-01'))->toArray(),
            'hideConversation' => false,
            'hideCards' => false,
        ];
        $tweet = new Tweet('http://www.example.com/', 'accountId', 'accountLabel', [new Paragraph('tweet')], Date::simple(new DateTimeImmutable('2000-01-01')), false, false);

        $this->assertSame($data['url'], $tweet['url']);
        $this->assertSame($data['accountId'], $tweet['accountId']);
        $this->assertSame($data['accountLabel'], $tweet['accountLabel']);
        $this->assertSame($data['text'][0], $tweet['text'][0]->toArray());
        $this->assertSame($data['date'], $tweet['date']->toArray());
        $this->assertSame($data['hideConversation'], $tweet['hideConversation']);
        $this->assertSame($data['hideCards'], $tweet['hideCards']);
        $this->assertSame($data, $tweet->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [new Tweet('http://www.example.com/', 'accountId', 'accountLabel', [new Paragraph('tweet')], Date::simple(new DateTimeImmutable('2000-01-01')))],
            'complete' => [new Tweet('http://www.example.com/', 'accountId', 'accountLabel', [new Paragraph('tweet')], Date::simple(new DateTimeImmutable('2000-01-01')), false, false)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/tweet.mustache';
    }
}

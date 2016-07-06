<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\DecisionLetterProfile;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Picture;
use eLife\Patterns\ViewModel\ProfileSnippet;

class DecisionLetterProfileTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'mainText' => 'This is the main text',
            'profileSnippet' => self::getProfileStub()->toArray(),
        ];

        $decisionLetter = new DecisionLetterProfile($data['mainText'], self::getProfileStub());

        $this->assertSame($data['mainText'], $decisionLetter['mainText']);
        $this->assertSame($data['profileSnippet'], $decisionLetter['profileSnippet']->toArray());
        $this->assertSame($data, $decisionLetter->toArray());
    }

    protected static function getProfileStub()
    {
        return new ProfileSnippet('Name McName', 'Title McTitle', new Picture([
            ['srcset' => '/path/to/svg'],
        ], new Image('/default/path', [500 => '/path/to/image/500/wide', 250 => '/default/path'], 'the alt text')));
    }

    public function viewModelProvider() : array
    {
        return [
            [new DecisionLetterProfile('Main text of letter', self::getProfileStub())],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/decision-letter-profile.mustache';
    }
}

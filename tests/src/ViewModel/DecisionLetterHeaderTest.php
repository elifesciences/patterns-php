<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\DecisionLetterHeader;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\ProfileSnippet;

final class DecisionLetterHeaderTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'mainText' => 'This is the main text',
            'hasProfiles' => true,
            'profiles' => [self::getProfileStub()->toArray()],
        ];

        $decisionLetter = new DecisionLetterHeader($data['mainText'], [self::getProfileStub()]);

        $this->assertSame($data['mainText'], $decisionLetter['mainText']);
        $this->assertSame($data['hasProfiles'], $decisionLetter['hasProfiles']);
        $this->assertSame($data['profiles'][0], $decisionLetter['profiles'][0]->toArray());
        $this->assertSame($data, $decisionLetter->toArray());
    }

    protected static function getProfileStub()
    {
        return new ProfileSnippet('Name McName', 'Title McTitle',
            new Image('/default/path', '/path/to/image/500/wide', 'the alt text')
        );
    }

    public function viewModelProvider() : array
    {
        return [
            'without profiles' => [new DecisionLetterHeader('Main text of letter')],
            'with profiles' => [new DecisionLetterHeader('Main text of letter', [self::getProfileStub()])],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/decision-letter-header.mustache';
    }
}

<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\OrcidVisibilitySettingError;

final class OrcidVisibilitySettingErrorTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'contactUri' => '/contact',
        ];

        $orcidVisibilitySettingError = new OrcidVisibilitySettingError('/contact');

        $this->assertSame($data['contactUri'], $orcidVisibilitySettingError['contactUri']);
        $this->assertSame($data, $orcidVisibilitySettingError->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [new OrcidVisibilitySettingError('/contact')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/orcid-error-visibility-setting.mustache';
    }
}

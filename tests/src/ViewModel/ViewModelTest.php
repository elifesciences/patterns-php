<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\CastsToArray;
use eLife\Patterns\ViewModel;
use JsonSchema\Validator;
use PHPUnit_Framework_TestCase;
use stdClass;
use Symfony\Component\Yaml\Yaml;
use tests\eLife\Patterns\PuliAwareTestCase;
use Traversable;
use function eLife\Patterns\flatten;
use function eLife\Patterns\traversable_to_unique_array;

abstract class ViewModelTest extends PHPUnit_Framework_TestCase
{
    use PuliAwareTestCase;

    /**
     * @test
     */
    abstract public function it_has_data();

    /**
     * @test
     */
    final public function it_is_a_view_model()
    {
        $viewModel = $this->createViewModel();

        $this->assertInstanceOf(ViewModel::class, $viewModel);
    }

    /**
     * @test
     */
    final public function it_has_a_template()
    {
        $viewModel = $this->createViewModel();

        $this->assertSame($this->expectedTemplate(), $viewModel->getTemplateName());
        $this->puli->get($viewModel->getTemplateName());
    }

    /**
     * @test
     * @depends it_has_a_template
     */
    final public function it_has_a_definition()
    {
        $this->loadDefinition();
    }

    /**
     * @test
     */
    final public function it_is_array_accessible()
    {
        $viewModel = $this->createViewModel();
        $data = $viewModel->toArray();

        foreach ($data as $key => $value) {
            $actual = $this->handleValue($viewModel[$key]);

            $this->assertSame($value, $actual);
        }
    }

    /**
     * @test
     * @dataProvider viewModelProvider
     * @depends      it_has_a_definition
     */
    final public function it_matches_the_schema(ViewModel $viewModel)
    {
        $validator = new Validator();

        $json = json_encode($viewModel->toArray());
        if ('[]' === $json) {
            $json = '{}';
        }

        $validator->check(json_decode($json), $this->loadDefinition()->schema);

        $message = '';
        foreach ($validator->getErrors() as $error) {
            $message .= sprintf("[%s] %s\n", $error['property'], $error['message']);
        };

        $this->assertTrue($validator->isValid(), $message);
    }

    /**
     * @test
     * @depends it_has_a_definition
     */
    final public function it_has_assets()
    {
        $viewModel = $this->createViewModel();

        $expectedStylesheets = traversable_to_unique_array($this->expectedStylesheets());
        $actualStyleSheets = traversable_to_unique_array($viewModel->getStyleSheets());

        $this->assertSameValuesWithoutOrder($expectedStylesheets, $actualStyleSheets);

        foreach ($this->expectedStylesheets() as $stylesheet) {
            $this->puli->get($stylesheet);
        }

        $expectedJavaScripts = traversable_to_unique_array($this->expectedJavaScripts());
        $actualJavaScripts = traversable_to_unique_array($viewModel->getJavaScripts());

        $this->assertSameValuesWithoutOrder($expectedJavaScripts, $actualJavaScripts);

        foreach ($this->expectedJavaScripts() as $javaScript) {
            $this->puli->get($javaScript);
        }
    }

    abstract public function viewModelProvider() : array;

    final protected function createViewModel() : ViewModel
    {
        return array_values($this->viewModelProvider())[0][0];
    }

    abstract protected function expectedTemplate() : string;

    private function expectedStylesheets() : Traversable
    {
        $definition = $this->loadDefinition();

        foreach (array_unique(iterator_to_array(flatten($definition->assets->css))) as $stylesheet) {
            yield '/elife/patterns/assets/css/'.$stylesheet;
        }
    }

    private function expectedJavaScripts() : Traversable
    {
        $definition = $this->loadDefinition();

        foreach (array_unique(iterator_to_array(flatten($definition->assets->js))) as $javaScript) {
            yield '/elife/patterns/assets/js/'.$javaScript;
        }
    }

    final private function loadDefinition() : stdClass
    {
        $templateName = $this->puli->get($this->createViewModel()->getTemplateName())->getName();
        $yamlFile = '/elife/patterns/definitions/'.substr($templateName, 0, -8).'yaml';

        return Yaml::parse($this->puli->get($yamlFile)->getBody(), Yaml::PARSE_OBJECT_FOR_MAP);
    }

    protected function srcsetToArray($srcset)
    {
        $sets = explode(', ', $srcset);
        $array = [];
        foreach ($sets as $set) {
            $parts = explode(' ', $set);
            $array[substr($parts[1], 0, -1)] = $parts[0];
        }

        return $array;
    }

    protected function assertSameWithoutOrder($expected, $actual, $prefix = '')
    {
        $reasons = [];
        foreach ($expected as $key => $expected_item) {
            if ($expected_item === null && !isset($actual[$key])) {
                continue;
            }
            if (!isset($actual[$key])) {
                array_push($reasons, 'Key missing in array: '.$prefix.'.'.$key);
                continue;
            }
            if ($actual[$key] instanceof CastsToArray || is_array($actual[$key])) {
                $this->assertSameWithoutOrder($expected_item, $actual[$key], $key);
                continue;
            }
            if ($key === 'behaviour' || $key === 'classes') {
                $this->assertSameValuesWithoutOrder(explode(' ', $expected_item), explode(' ', $actual[$key]));
                continue;
            }
            $this->assertSame($expected_item, $actual[$key]);
        }
        if ($reasons) {
            $this->fail(implode("\n", $reasons));
        }
    }

    protected function assertSameValuesWithoutOrder($expected, $actual)
    {
        foreach ($expected as $expected_item) {
            $this->assertContains($expected_item, $actual);
        }
    }

    private function handleValue($value)
    {
        if (is_array($value)) {
            foreach ($value as $subKey => $subValue) {
                $value[$subKey] = $this->handleValue($subValue);
            }
        }

        if ($value instanceof CastsToArray) {
            return $value->toArray();
        }

        return $value;
    }
}

<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\CastsToArray;
use eLife\Patterns\ViewModel;
use JsonSchema\Validator;
use PHPUnit_Framework_TestCase;
use stdClass;
use Symfony\Component\Yaml\Yaml;

abstract class ViewModelTest extends PHPUnit_Framework_TestCase
{
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
        $this->assertFileExists(__DIR__.'/../../../'.$viewModel->getTemplateName());
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

        $validator->check(json_decode($json), $this->loadDefinition());

        $message = '';
        foreach ($validator->getErrors() as $error) {
            $message .= sprintf("[%s] %s\n", $error['property'], $error['message']);
        }

        $this->assertTrue($validator->isValid(), $message);
    }

    abstract public function viewModelProvider() : array;

    final protected function createViewModel() : ViewModel
    {
        return array_values($this->viewModelProvider())[0][0];
    }

    abstract protected function expectedTemplate() : string;

    private function loadDefinition() : stdClass
    {
        $templateName = $this->createViewModel()->getTemplateName();
        $yamlFile = __DIR__.'/../../../resources/definitions/'.basename($templateName, 'mustache').'yaml';

        $this->assertFileExists($yamlFile);

        return Yaml::parse(file_get_contents($yamlFile), Yaml::PARSE_OBJECT_FOR_MAP);
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
            if (null === $expected_item && !isset($actual[$key])) {
                continue;
            }
            if (!isset($actual[$key]) && null !== $expected[$key]) {
                array_push($reasons, 'Key missing in array: '.$prefix.'.'.$key.' with value '.json_encode($expected_item));
                continue;
            }
            if ($actual[$key] instanceof CastsToArray || is_array($actual[$key])) {
                $this->assertSameWithoutOrder($expected_item, $actual[$key], $key);
                continue;
            }
            if ('behaviour' === $key || 'classes' === $key) {
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
        $this->assertTrue(is_array($expected), 'array expected');
        $this->assertTrue(is_array($actual), 'array expected');
        $isArrayOrObject = false;
        foreach ($expected as $expected_item) {
            $this->assertContains($expected_item, $actual);
            if (is_array($expected_item) || is_object($expected_item)) {
                $isArrayOrObject = true;
            }
        }
        foreach ($actual as $actual_item) {
            $this->assertContains($actual_item, $expected);
            if (is_array($actual_item) || is_object($actual_item)) {
                $isArrayOrObject = true;
            }
        }
        if (false === $isArrayOrObject) {
            $expectedArray = (array) $expected;
            $actualArray = (array) $actual;
            sort($expectedArray);
            sort($actualArray);
            $this->assertSame($expectedArray, $actualArray);
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

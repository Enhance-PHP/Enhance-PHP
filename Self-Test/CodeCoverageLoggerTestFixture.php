<?php
class TestClassForCodeCoverageLogger
{
    public $property = 1;
    
    public function getNumberPlusTwo($number)
    {
        return $number + 2;
    }
}

class CodeCoverageLoggerTestFixture extends EnhanceTestFixture
{
    public function useCodeCoverageLoggerToCallMethod()
    {
        /** @var TestClassForCodeCoverageLogger $target */
        $target = Enhance::getCodeCoverageWrapper('TestClassForCodeCoverageLogger');
        
        $result = $target->getNumberPlusTwo(5);
        
        Assert::areIdentical(7, $result);
    }
    
    public function useCodeCoverageLoggerToGetProperty()
    {
        /** @var TestClassForCodeCoverageLogger $target */
        $target = Enhance::getCodeCoverageWrapper('TestClassForCodeCoverageLogger');
        
        $result = $target->property;
        
        Assert::areIdentical(1, $result);
    }
    
    public function useCodeCoverageLoggerToSetProperty() 
    {
        /** @var TestClassForCodeCoverageLogger $target */
        $target = Enhance::getCodeCoverageWrapper('TestClassForCodeCoverageLogger');
        
        $target->property = 8;
        $result = $target->property;
        
        Assert::areIdentical(8, $result);
    }
}
?>
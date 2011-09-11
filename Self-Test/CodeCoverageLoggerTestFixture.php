<?php
class TestClassForCodeCoverageLogger
{
    public $property = 1;
    
    public function getNumberPlusTwo($number)
    {
        return $number + 2;
    }
}

class CodeCoverageLoggerTestFixture
{
    public function useCodeCoverageLoggerToCallMethodTest()
    {
        $target = Enhance::getCodeCoverageWrapper('TestClassForCodeCoverageLogger');
        
        $result = $target->getNumberPlusTwo(5);
        
        Assert::areIdentical(7, $result);
    }
    
    public function useCodeCoverageLoggerToGetPropertyTest()
    {
        $target = Enhance::getCodeCoverageWrapper('TestClassForCodeCoverageLogger');
        
        $result = $target->property;
        
        Assert::areIdentical(1, $result);
    }
    
    public function useCodeCoverageLoggerToSetPropertyTest() 
    {
        $target = Enhance::getCodeCoverageWrapper('TestClassForCodeCoverageLogger');
        
        $target->property = 8;
        $result = $target->property;
        
        Assert::areIdentical(8, $result);
    }
}
?>
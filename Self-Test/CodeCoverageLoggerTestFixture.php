<?php
class TestClassForCodeCoverageLogger {
    public $Property = 1;
    public function GetNumberPlusTwo($number) {
        return $number + 2;
    }
}

class CodeCoverageLoggerTestFixture {

    public function UseCodeCoverageLoggerToCallMethodTest() {
        $target = Enhance::getCodeCoverageWrapper('TestClassForCodeCoverageLogger');
        
        $result = $target->GetNumberPlusTwo(5);
        
        Assert::areIdentical(7, $result);
    }
    
    public function UseCodeCoverageLoggerToGetPropertyTest() {
        $target = Enhance::getCodeCoverageWrapper('TestClassForCodeCoverageLogger');
        
        $result = $target->Property;
        
        Assert::areIdentical(1, $result);
    }
    
    public function UseCodeCoverageLoggerToSetPropertyTest() {
        $target = Enhance::getCodeCoverageWrapper('TestClassForCodeCoverageLogger');
        
        $target->Property = 8;
        $result = $target->Property;
        
        Assert::areIdentical(8, $result);
    }
}
?>
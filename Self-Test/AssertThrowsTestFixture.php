<?php
class StubThrowsClass {
    public function DoesThrow() {
        throw new Exception('Test exception.');
    }
    
    public function DoesNotThrow() {

    }
    
    public function DoesThrowWithArgs($a, $b) {
        if ($a === $b) {
            throw new Exception('Test exception.');
        }
    }
    
    public function DoesNotThrowWithArgs($a, $b) {
        if ($a !== $b) {
            throw new Exception('Test exception.');
        }
    }
}

class AssertThrowsTestFixture {
    private $Target;
    
    public function SetUp() {
        $this->Target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
    }

    public function AssertThrowsWithExceptionExpectPassTest() {
        $Stub = new StubThrowsClass();
        $this->Target->throws($Stub, 'DoesThrow');
    }
    
    public function AssertThrowsWithNoExceptionExpectFailTest() {
        $Stub = new StubThrowsClass();
        $VerifyFailed = false;
        try {
            $this->Target->throws($Stub, 'DoesNotThrow');
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        Assert::isTrue($VerifyFailed);
    }
    
    public function AssertThrowsWithArgumentsAndExceptionExpectPassTest() {
        $Stub = new StubThrowsClass();
        $this->Target->throws($Stub, 'DoesThrowWithArgs', array(3, 3));
    }
    
    public function AssertThrowsWithArgumentsAndNoExceptionExpectFailTest() {
        $Stub = new StubThrowsClass();
        $VerifyFailed = false;
        try {
            $this->Target->throws($Stub, 'DoesNotThrowWithArgs', array(4, 4));
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        Assert::isTrue($VerifyFailed);
    }
}
?>
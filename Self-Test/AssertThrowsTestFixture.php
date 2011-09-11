<?php
class StubThrowsClass
{
    public function doesThrow()
    {
        throw new Exception('Test exception.');
    }
    
    public function doesNotThrow()
    {

    }
    
    public function doesThrowWithArgs($a, $b)
    {
        if ($a === $b) {
            throw new Exception('Test exception.');
        }
    }
    
    public function doesNotThrowWithArgs($a, $b)
    {
        if ($a !== $b) {
            throw new Exception('Test exception.');
        }
    }
}

class AssertThrowsTestFixture {
    private $target;
    
    public function setUp()
    {
        $this->target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
    }

    public function assertThrowsWithExceptionExpectPassTest()
    {
        $Stub = new StubThrowsClass();
        $this->target->throws($Stub, 'doesThrow');
    }
    
    public function assertThrowsWithNoExceptionExpectFailTest()
    {
        $Stub = new StubThrowsClass();
        $verifyFailed = false;
        try {
            $this->target->throws($Stub, 'doesNotThrow');
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        Assert::isTrue($verifyFailed);
    }
    
    public function assertThrowsWithArgumentsAndExceptionExpectPassTest()
    {
        $Stub = new StubThrowsClass();
        $this->target->throws($Stub, 'doesThrowWithArgs', array(3, 3));
    }
    
    public function assertThrowsWithArgumentsAndNoExceptionExpectFailTest()
    {
        $Stub = new StubThrowsClass();
        $verifyFailed = false;
        try {
            $this->target->throws($Stub, 'doesNotThrowWithArgs', array(4, 4));
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        Assert::isTrue($verifyFailed);
    }
}
?>
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

class AssertThrowsTestFixture extends \Enhance\TestFixture
{
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp()
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertThrowsWithExceptionExpectPass()
    {
        $Stub = new StubThrowsClass();
        $this->target->throws($Stub, 'doesThrow');
    }
    
    public function assertThrowsWithNoExceptionExpectFail()
    {
        $Stub = new StubThrowsClass();
        $verifyFailed = false;
        try {
            $this->target->throws($Stub, 'doesNotThrow');
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
    
    public function assertThrowsWithArgumentsAndExceptionExpectPass()
    {
        $Stub = new StubThrowsClass();
        $this->target->throws($Stub, 'doesThrowWithArgs', array(3, 3));
    }
    
    public function assertThrowsWithArgumentsAndNoExceptionExpectFail()
    {
        $Stub = new StubThrowsClass();
        $verifyFailed = false;
        try {
            $this->target->throws($Stub, 'doesNotThrowWithArgs', array(4, 4));
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}
?>
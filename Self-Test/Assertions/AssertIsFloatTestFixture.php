<?php
class AssertIsFloatTestFixture extends \Enhance\TestFixture
{
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp() 
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertIsFloatWithFloat()
    {
        $this->target->isFloat(1.1);
    }

    public function assertIsFloatWithInteger()
    {
        $verifyFailed = false;
        try {
            $this->target->isFloat(1);
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }

    public function assertIsFloatWithString()
    {
        $verifyFailed = false;
        try {
            $this->target->isFloat('1.1');
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}
?>
<?php
class AssertIsNotNumericTestFixture extends \Enhance\TestFixture
{
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp() 
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertIsNotNumericWithNormalString()
    {
        $this->target->isNotNumeric('xyz');
    }

    public function assertIsNotNumericWithFloat()
    {
        $verifyFailed = false;
        try {
            $this->target->isNotNumeric(1.1);
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }

    public function assertIsNotNumericWithInt()
    {
        $verifyFailed = false;
        try {
            $this->target->isNotNumeric(1);
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }

    public function assertIsNotNumericWithNumericString()
    {
        $verifyFailed = false;
        try {
            $this->target->isNotNumeric('1');
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}
?>
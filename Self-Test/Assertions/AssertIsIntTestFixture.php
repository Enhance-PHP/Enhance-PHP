<?php
class AssertIsIntTestFixture extends \Enhance\TestFixture
{
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp() 
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertIsIntWithInt()
    {
        $this->target->isInt(1);
    }

    public function assertIsIntWithFloat()
    {
        $verifyFailed = false;
        try {
            $this->target->isInt(1.1);
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }

    public function assertIsIntWithString()
    {
        $verifyFailed = false;
        try {
            $this->target->isInt('1');
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}
?>
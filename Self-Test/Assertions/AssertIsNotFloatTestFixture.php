<?php
class AssertIsNotFloatTestFixture extends \Enhance\TestFixture
{
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp() 
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertIsNotFloatWithInteger()
    {
        $this->target->isNotFloat(1);
    }

    public function assertIsNotFloatWithString()
    {
        $this->target->isNotFloat('1.1');
    }

    public function assertIsNotFloatWithFloat()
    {
        $verifyFailed = false;
        try {
            $this->target->isNotFloat(1.1);
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}
?>
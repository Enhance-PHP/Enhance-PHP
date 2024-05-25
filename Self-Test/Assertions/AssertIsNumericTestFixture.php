<?php
class AssertIsNumericTestFixture extends \Enhance\TestFixture
{
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp() 
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertIsNumericWithFloat()
    {
        $this->target->isNumeric(1.1);
    }

    public function assertIsNumericWithInt()
    {
        $this->target->isNumeric(1);
    }

    public function assertIsNumericWithNumericString()
    {
        $this->target->isNumeric('1');
    }

    public function assertIsNumericWithNormalString()
    {
        $verifyFailed = false;
        try {
            $this->target->isNumeric('xyz');
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}

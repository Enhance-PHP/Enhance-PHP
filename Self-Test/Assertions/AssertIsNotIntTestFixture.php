<?php
class AssertIsNotIntTestFixture extends \Enhance\TestFixture
{
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp() 
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertIsNotIntWithFloat()
    {
        $this->target->isNotInt(1.1);
    }

    public function assertIsNotIntWithString()
    {
        $this->target->isNotInt('1');
    }

    public function assertIsNotIntWithInt()
    {
        $verifyFailed = false;
        try {
            $this->target->isNotInt(1);
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}
?>
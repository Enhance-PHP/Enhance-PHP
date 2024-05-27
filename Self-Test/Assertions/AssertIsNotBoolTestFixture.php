<?php
class AssertIsNotBoolTestFixture extends \Enhance\TestFixture
{
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp() 
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertIsNotBoolWithStringTrue()
    {
        $this->target->isNotBool('true');
    }

    public function assertIsNotBoolWithStringFalse()
    {
        $this->target->isNotBool('false');
    }

    public function assertIsNotBoolWithNumber1()
    {
        $this->target->isNotBool(1);
    }

    public function assertIsNotBoolWithNumber0()
    {
        $this->target->isNotBool(0);
    }
    
    public function assertIsNotBoolWithTrue()
    {
        $verifyFailed = false;
        try {
            $this->target->isNotBool(true);
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }

    public function assertIsNotBoolWithFalse()
    {
        $verifyFailed = false;
        try {
            $this->target->isNotBool(false);
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}

<?php
class AssertIsTrueTestFixture extends \Enhance\TestFixture
{
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp()
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertIsTrueWithTrueExpectPass()
    {
        $this->target->isTrue(true);
    }
    
    public function assertIsTrueWithFalseExpectFail()
    {
        $verifyFailed = false;
        try {
            $this->target->isTrue(false);
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
    
    public function assertIsTrueWith1ExpectFail()
    {
        $verifyFailed = false;
        try {
            $this->target->isTrue(1);
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}

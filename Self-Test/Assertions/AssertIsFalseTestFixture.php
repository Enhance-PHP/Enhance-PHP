<?php
class AssertIsFalseTestFixture extends \Enhance\TestFixture
{
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp()
    {
        $this->target = \Enhance\Enhance::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertIsFalseWithFalseExpectPass()
    {
        $this->target->isFalse(false);
    }
    
    public function assertIsFalseWithTrueExpectFail()
    {
        $VerifyFailed = false;
        try {
            $this->target->isFalse(true);
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        \Enhance\Assert::isTrue($VerifyFailed);
    }
    
    public function assertIsFalseWith0ExpectFail()
    {
        $verifyFailed = false;
        try {
            $this->target->isFalse(0);
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}
?>
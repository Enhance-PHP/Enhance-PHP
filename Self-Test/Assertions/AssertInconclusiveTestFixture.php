<?php
class AssertInconclusiveTestFixture extends \Enhance\TestFixture
 {
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp()
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertInconclusiveExpectError()
    {
        $verifyFailed = false;
        try {
            $this->target->inconclusive();
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}

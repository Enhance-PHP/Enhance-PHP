<?php
class AssertIsNotNullTestFixture extends \Enhance\TestFixture
{
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp()
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertIsNotNullWithNotNull()
    {
        $this->target->isNotNull('');
    }
    
    public function assertIsNotNullWithNull()
    {
        $verifyFailed = false;
        try {
            $this->target->isNotNull(null);
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}

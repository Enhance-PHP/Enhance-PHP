<?php
class AssertIsNullTestFixture extends \Enhance\TestFixture
{
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp()
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertIsNullWithNull()
    {
        $this->target->isNull(null);
    }
    
    public function assertIsNullWithNotNull()
    {
        $verifyFailed = false;
        try {
            $this->target->isNull('');
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}

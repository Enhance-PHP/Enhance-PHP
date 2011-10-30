<?php
class AssertIsNullTestFixture extends \Enhance\EnhanceTestFixture
{
    /** @var \Enhance\EnhanceAssertions $target */
    private $target;
    
    public function setUp()
    {
        $this->target = \Enhance\Enhance::getCodeCoverageWrapper('\Enhance\EnhanceAssertions', array(\Enhance\EnhanceLanguage::English));
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
?>
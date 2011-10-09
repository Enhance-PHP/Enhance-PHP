<?php
class AssertIsNullTestFixture extends EnhanceTestFixture
{
    /** @var EnhanceAssertions $target */
    private $target;
    
    public function setUp()
    {
        $this->target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
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
        Assert::isTrue($verifyFailed);
    }
}
?>
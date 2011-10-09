<?php
class AssertIsNotNullTestFixture extends EnhanceTestFixture
{
    /** @var EnhanceAssertions $target */
    private $target;
    
    public function setUp()
    {
        $this->target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
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
        Assert::isTrue($verifyFailed);
    }
}
?>
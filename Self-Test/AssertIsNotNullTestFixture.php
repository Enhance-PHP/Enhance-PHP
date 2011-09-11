<?php
class AssertIsNotNullTestFixture
{
    private $target;
    
    public function setUp()
    {
        $this->target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
    }

    public function assertIsNotNullWithNotNullTest()
    {
        $this->target->isNotNull('');
    }
    
    public function assertIsNotNullWithNullTest()
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
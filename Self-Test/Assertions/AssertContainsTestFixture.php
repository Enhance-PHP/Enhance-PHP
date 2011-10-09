<?php
class AssertContainsTestFixture extends EnhanceTestFixture
{
    /** @var EnhanceAssertions $target */
    private $target;
    
    public function setUp()
    {
        $this->target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
    }

    public function assertContainsWithStringThatContains()
    {
        $this->target->contains('Test', 'Some Test String');
    }
    
    public function assertContainsWithStringThatEndsWith() 
    {
        $this->target->contains('Test', 'Some Test');
    }
    
    public function assertContainsWithStringThatStartsWith()
    {
        $this->target->contains('Test', 'Test Some String');
    }
    
    public function assertContainsWithStringThatDoesNotContain()
    {
        $verifyFailed = false;
        try {
            $this->target->contains('Test', 'Some Other String');
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        Assert::isTrue($verifyFailed);
    }
}
?>
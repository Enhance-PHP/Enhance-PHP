<?php
class AssertContainsTestFixture 
{
    private $target;
    
    public function setUp()
    {
        $this->target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
    }

    public function assertContainsWithStringThatContainsTest()
    {
        $this->target->contains('Test', 'Some Test String');
    }
    
    public function assertContainsWithStringThatEndsWithTest() 
    {
        $this->target->contains('Test', 'Some Test');
    }
    
    public function assertContainsWithStringThatStartsWithTest()
    {
        $this->target->contains('Test', 'Test Some String');
    }
    
    public function assertContainsWithStringThatDoesNotContainTest()
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
<?php
class AssertNotContainsTestFixture 
{
    private $target;
    
    public function setUp()
    {
        $this->target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
    }
    
    public function assertNotContainsWithStringThatContainsTest() 
    {
        $verifyFailed = false;
        try {
            $this->target->notContains('Test', 'Some Test String');
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        Assert::isTrue($verifyFailed);
    }
    
    public function assertNotContainsWithStringThatEndsWithTest()
    {
        $verifyFailed = false;
        try {
            $this->target->notContains('Test', 'Some Test');
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        Assert::isTrue($verifyFailed);
    }
    
    public function assertNotContainsWithStringThatStartsWithTest()
    {
        $verifyFailed = false;
        try {
            $this->target->notContains('Test', 'Test Some String');
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        Assert::isTrue($verifyFailed);
    }
    
    public function assertNotContainsWithStringThatDoesNotContainTest()
    {
        $this->target->notContains('Test', 'Some Other String');
    }
}
?>
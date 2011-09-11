<?php
class AssertNotContainsTestFixture {
    private $Target;
    
    public function SetUp() {
        $this->Target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
    }
    
    public function AssertNotContainsWithStringThatContainsTest() {
        $VerifyFailed = false;
        try {
            $this->Target->notContains('Test', 'Some Test String');
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        Assert::isTrue($VerifyFailed);
    }
    
    public function AssertNotContainsWithStringThatEndsWithTest() {
        $VerifyFailed = false;
        try {
            $this->Target->notContains('Test', 'Some Test');
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        Assert::isTrue($VerifyFailed);
    }
    
    public function AssertNotContainsWithStringThatStartsWithTest() {
        $VerifyFailed = false;
        try {
            $this->Target->notContains('Test', 'Test Some String');
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        Assert::isTrue($VerifyFailed);
    }
    
    public function AssertNotContainsWithStringThatDoesNotContainTest() {
        $this->Target->notContains('Test', 'Some Other String');
    }
}
?>
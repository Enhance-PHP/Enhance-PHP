<?php
class AssertContainsTestFixture {
    private $Target;
    
    public function SetUp() {
        $this->Target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
    }

    public function AssertContainsWithStringThatContainsTest() {
        $this->Target->contains('Test', 'Some Test String');
    }
    
    public function AssertContainsWithStringThatEndsWithTest() {
        $this->Target->contains('Test', 'Some Test');
    }
    
    public function AssertContainsWithStringThatStartsWithTest() {
        $this->Target->contains('Test', 'Test Some String');
    }
    
    public function AssertContainsWithStringThatDoesNotContainTest() {
        $VerifyFailed = false;
        try {
            $this->Target->contains('Test', 'Some Other String');
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        Assert::isTrue($VerifyFailed);
    }
}
?>
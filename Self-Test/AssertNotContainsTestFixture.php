<?php
class AssertNotContainsTestFixture {
	private $Target;
	
	public function SetUp() {
		$this->Target = Enhance::GetCodeCoverageWrapper('EnhanceAssertions');
	}
	
	public function AssertNotContainsWithStringThatContainsTest() {
		$VerifyFailed = false;
		try {
			$this->Target->NotContains('Test', 'Some Test String');
		} catch (Exception $e) {
			$VerifyFailed = true;
		}
		Assert::IsTrue($VerifyFailed);
	}
	
	public function AssertNotContainsWithStringThatEndsWithTest() {
		$VerifyFailed = false;
		try {
			$this->Target->NotContains('Test', 'Some Test');
		} catch (Exception $e) {
			$VerifyFailed = true;
		}
		Assert::IsTrue($VerifyFailed);
	}
	
	public function AssertNotContainsWithStringThatStartsWithTest() {
		$VerifyFailed = false;
		try {
			$this->Target->NotContains('Test', 'Test Some String');
		} catch (Exception $e) {
			$VerifyFailed = true;
		}
		Assert::IsTrue($VerifyFailed);
	}
	
	public function AssertNotContainsWithStringThatDoesNotContainTest() {
		$this->Target->NotContains('Test', 'Some Other String');
	}
}
?>
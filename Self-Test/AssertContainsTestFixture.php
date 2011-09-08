<?php
class AssertContainsTestFixture {
	private $Target;
	
	public function SetUp() {
		$this->Target = Enhance::GetCodeCoverageWrapper('EnhanceAssertions');
	}

	public function AssertContainsWithStringThatContainsTest() {
		$this->Target->Contains('Test', 'Some Test String');
	}
	
	public function AssertContainsWithStringThatEndsWithTest() {
		$this->Target->Contains('Test', 'Some Test');
	}
	
	public function AssertContainsWithStringThatStartsWithTest() {
		$this->Target->Contains('Test', 'Test Some String');
	}
	
	public function AssertContainsWithStringThatDoesNotContainTest() {
		$VerifyFailed = false;
		try {
			$this->Target->Contains('Test', 'Some Other String');
		} catch (Exception $e) {
			$VerifyFailed = true;
		}
		Assert::IsTrue($VerifyFailed);
	}
}
?>
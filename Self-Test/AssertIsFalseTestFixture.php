<?php
class AssertIsFalseTestFixture {
	private $Target;
	
	public function SetUp() {
		$this->Target = Enhance::GetCodeCoverageWrapper('EnhanceAssertions');
	}

	public function AssertIsFalseWithFalseExpectPassTest() {
		$this->Target->IsFalse(false);
	}
	
	public function AssertIsFalseWithTrueExpectFailTest() {
		$VerifyFailed = false;
		try {
			$this->Target->IsFalse(true);
		} catch (Exception $e) {
			$VerifyFailed = true;
		}
		Assert::IsTrue($VerifyFailed);
	}
	
	public function AssertIsFalseWith0ExpectFailTest() {
		$VerifyFailed = false;
		try {
			$this->Target->IsFalse(0);
		} catch (Exception $e) {
			$VerifyFailed = true;
		}
		Assert::IsTrue($VerifyFailed);
	}
}
?>
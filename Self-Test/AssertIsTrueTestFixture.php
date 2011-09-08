<?php
class AssertIsTrueTestFixture {
	private $Target;
	
	public function SetUp() {
		$this->Target = Enhance::GetCodeCoverageWrapper('EnhanceAssertions');
	}

	public function AssertIsTrueWithTrueExpectPassTest() {
		$this->Target->IsTrue(true);
	}
	
	public function AssertIsTrueWithFalseExpectFailTest() {
		$VerifyFailed = false;
		try {
			$this->Target->IsTrue(false);
		} catch (Exception $e) {
			$VerifyFailed = true;
		}
		Assert::IsTrue($VerifyFailed);
	}
	
	public function AssertIsTrueWith1ExpectFailTest() {
		$VerifyFailed = false;
		try {
			$this->Target->IsTrue(1);
		} catch (Exception $e) {
			$VerifyFailed = true;
		}
		Assert::IsTrue($VerifyFailed);
	}
}
?>
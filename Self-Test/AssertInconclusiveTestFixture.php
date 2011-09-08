<?php
class AssertInconclusiveTestFixture {
	private $Target;
	
	public function SetUp() {
		$this->Target = Enhance::GetCodeCoverageWrapper('EnhanceAssertions');
	}

	public function AssertInconclusiveExpectErrorTest() {
		$VerifyFailed = false;
		try {
			$this->Target->Inconclusive();
		} catch (Exception $e) {
			$VerifyFailed = true;
		}
		Assert::IsTrue($VerifyFailed);
	}
}
?>
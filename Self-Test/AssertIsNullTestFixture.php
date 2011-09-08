<?php
class AssertIsNullTestFixture {
	private $Target;
	
	public function SetUp() {
		$this->Target = Enhance::GetCodeCoverageWrapper('EnhanceAssertions');
	}

	public function AssertIsNullWithNullTest() {
		$this->Target->IsNull(null);
	}
	
	public function AssertIsNullWithNotNullTest() {
		$VerifyFailed = false;
		try {
			$this->Target->IsNull('');
		} catch (Exception $e) {
			$VerifyFailed = true;
		}
		Assert::IsTrue($VerifyFailed);
	}
}
?>
<?php
class AssertIsNotNullTestFixture {
	private $Target;
	
	public function SetUp() {
		$this->Target = Enhance::GetCodeCoverageWrapper('EnhanceAssertions');
	}

	public function AssertIsNotNullWithNotNullTest() {
		$this->Target->IsNotNull('');
	}
	
	public function AssertIsNotNullWithNullTest() {
		$VerifyFailed = false;
		try {
			$this->Target->IsNotNull(null);
		} catch (Exception $e) {
			$VerifyFailed = true;
		}
		Assert::IsTrue($VerifyFailed);
	}
}
?>
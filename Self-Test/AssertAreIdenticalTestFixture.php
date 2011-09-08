<?php
class AssertAreIdenticalTestFixture {
	private $Target;
	
	public function SetUp() {
		$this->Target = Enhance::GetCodeCoverageWrapper('EnhanceAssertions');
	}

	public function AssertAreIdenticalWithIdenticalIntegersTest() {
		$this->Target->AreIdentical(5, 5);
	}
	
	public function AssertAreIdenticalWithDifferentIntegersTest() {
		$VerifyFailed = false;
		try {
			$this->Target->AreIdentical(5, 4);
		} catch (Exception $e) {
			$VerifyFailed = true;
		}
		Assert::IsTrue($VerifyFailed);
	}
	
	public function AssertAreIdenticalWithIdenticalStringsTest() {
		$this->Target->AreIdentical('Test', 'Test');
	}
	
	public function AssertAreIdenticalWithDifferentStringsTest() {
		$VerifyFailed = false;
		try {
			$this->Target->AreIdentical('Test', 'test');
		} catch (Exception $e) {
			$VerifyFailed = true;
		}
		Assert::IsTrue($VerifyFailed);
	}
	
	public function AssertAreIdenticalWithIdenticalFloatsTest() {
		$this->Target->AreIdentical(15.123346575, 15.123346575);
	}
	
	public function AssertAreIdenticalWithDifferentFloatsTest() {
		$VerifyFailed = false;
		try {
			$this->Target->AreIdentical(15.123346575, 15.123346574);
		} catch (Exception $e) {
			$VerifyFailed = true;
		}
		Assert::IsTrue($VerifyFailed);
	}
}
?>
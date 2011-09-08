<?php
class AssertAreNotIdenticalTestFixture {
	private $Target;
	
	public function SetUp() {
		$this->Target = Enhance::GetCodeCoverageWrapper('EnhanceAssertions');
	}

	public function AssertAreNotIdenticalWithDifferentIntegersTest() {
		$this->Target->AreNotIdentical(5, 4);
	}
	
	public function AssertAreNotIdenticalWithIdenticalIntegersTest() {
		$VerifyFailed = false;
		try {
			$this->Target->AreNotIdentical(5, 5);
		} catch (Exception $e) {
			$VerifyFailed = true;
		}
		Assert::IsTrue($VerifyFailed);
	}
	
	public function AssertAreNotIdenticalWithDifferentStringsTest() {
		$this->Target->AreNotIdentical('Test', 'test');
	}
	
	public function AssertAreNotIdenticalWithIdenticalStringsTest() {
		$VerifyFailed = false;
		try {
			$this->Target->AreNotIdentical('Test', 'Test');
		} catch (Exception $e) {
			$VerifyFailed = true;
		}
		Assert::IsTrue($VerifyFailed);
	}
	
	public function AssertAreNotIdenticalWithDifferentFloatsTest() {
		$this->Target->AreNotIdentical(15.123346575, 15.123346574);
	}
	
	public function AssertAreNotIdenticalWithIdenticalFloatsTest() {
		$VerifyFailed = false;
		try {
			$this->Target->AreNotIdentical(15.123346575, 15.123346575);
		} catch (Exception $e) {
			$VerifyFailed = true;
		}
		Assert::IsTrue($VerifyFailed);
	}
}
?>
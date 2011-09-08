<?php
class SomeType {
	public $Value;
}

class AssertIsInstanceOfTypeTestFixture {
	private $Target;
	
	public function SetUp() {
		$this->Target = Enhance::GetCodeCoverageWrapper('EnhanceAssertions');
	}

	public function AssertIsInstanceOfTypeWithIdenticalTypeTest() {
		$object = new SomeType();
		$this->Target->IsInstanceOfType('SomeType', $object);
	}
	
	public function AssertIsInstanceOfTypeWithDifferentTypesTest() {
		$VerifyFailed = false;
		$object = new SomeType();
		try {
			$this->Target->IsInstanceOfType('SomeOtherType', $object);
		} catch (Exception $e) {
			$VerifyFailed = true;
		}
		Assert::IsTrue($VerifyFailed);
	}
}
?>
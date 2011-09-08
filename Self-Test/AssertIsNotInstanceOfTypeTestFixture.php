<?php
class SomeOtherType {
	public $Value;
}

class AssertIsNotInstanceOfTypeTestFixture {
	private $Target;
	
	public function SetUp() {
		$this->Target = Enhance::GetCodeCoverageWrapper('EnhanceAssertions');
	}

	public function AssertIsNotInstanceOfTypeWithDifferentTypeTest() {
		$object = new SomeOtherType();
		$this->Target->IsNotInstanceOfType('SomeType', $object);
	}
	
	public function AssertIsNotInstanceOfTypeWithIdenticalTypesTest() {
		$VerifyFailed = false;
		$object = new SomeOtherType();
		try {
			$this->Target->IsNotInstanceOfType('SomeOtherType', $object);
		} catch (Exception $e) {
			$VerifyFailed = true;
		}
		Assert::IsTrue($VerifyFailed);
	}
}
?>
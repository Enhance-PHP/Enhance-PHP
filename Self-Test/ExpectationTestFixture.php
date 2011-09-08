<?php
class ExpectationTestFixture {

	public function ExpectWithMethodWithReturnsTimesTest() {
		$target = Expect::Method('TestA')->With('A', 'B')->Returns('TestC')->Times(1);
		
		Assert::IsTrue($target->ExpectArguments);
		Assert::IsTrue($target->ExpectTimes);
		Assert::AreIdentical('A', $target->MethodArguments[0]);
		Assert::AreIdentical('B', $target->MethodArguments[1]);
		Assert::AreIdentical('TestC', $target->ReturnValue);
		Assert::AreIdentical(1, $target->ExpectedCalls);
	}
	
	public function ExpectWithMethodWithReturnsTest() {
		$target = Expect::Method('TestA')->With('A', 'B')->Returns('TestC');
		
		Assert::IsTrue($target->ExpectArguments);
		Assert::IsFalse($target->ExpectTimes);
		Assert::AreIdentical('A', $target->MethodArguments[0]);
		Assert::AreIdentical('B', $target->MethodArguments[1]);
		Assert::AreIdentical('TestC', $target->ReturnValue);
		Assert::AreIdentical(-1, $target->ExpectedCalls);
	}
	
	public function ExpectWithMethodReturnsTimesTest() {
		$target = Expect::Method('TestA')->Returns('TestC')->Times(1);
		
		Assert::IsFalse($target->ExpectArguments);
		Assert::IsTrue($target->ExpectTimes);
		Assert::AreIdentical('TestC', $target->ReturnValue);
		Assert::AreIdentical(1, $target->ExpectedCalls);
	}
	
	public function ExpectWithMethodTimesTest() {
		$target = Expect::Method('TestA')->Times(1);
		
		Assert::IsFalse($target->ExpectArguments);
		Assert::IsTrue($target->ExpectTimes);
		Assert::AreIdentical(1, $target->ExpectedCalls);
	}
}
?>
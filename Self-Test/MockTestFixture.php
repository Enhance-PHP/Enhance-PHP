<?php
class MockTestFixture {

	public function CreateMockWithArgumentsAndOneTimeExpectReturnValueAndVerifiesTest() {
		$Mock = MockFactory::CreateMock('ExampleClass');
		$Mock->AddExpectation(Expect::Method('DoSomething')->With('hello', 3, 'world')->Returns('Some Value')->Times(1));

		$result = $Mock->DoSomething('hello', 3, 'world');

		Assert::AreIdentical('Some Value', $result);
		$Mock->VerifyExpectations();
	}
	
	public function CreateMockWithNoRequiredArgumentsAndOneTimeExpectReturnValueAndVerifiesTest() {
		$Mock = MockFactory::CreateMock('ExampleClass');
		$Mock->AddExpectation(Expect::Method('DoSomething')->Returns('Some Value')->Times(1));

		$result = $Mock->DoSomething();

		Assert::AreIdentical('Some Value', $result);
		$Mock->VerifyExpectations();
	}
	
	public function CreateMockWithAnyArgumentsAndOneTimeExpectReturnValueAndVerifiesTest() {
		$Mock = MockFactory::CreateMock('ExampleClass');
		$Mock->AddExpectation(Expect::Method('DoSomething')->With(Expect::AnyValue, Expect::AnyValue, Expect::AnyValue)->Returns('Some Value')->Times(1));

		$result = $Mock->DoSomething('lalalala', 7, 'blahblah');

		Assert::AreIdentical('Some Value', $result);
		$Mock->VerifyExpectations();
	}

	public function CreateMockWithArgumentsAndTwoTimesExpectReturnValueAndVerifiesTest() {
		$Mock = MockFactory::CreateMock('ExampleClass');
		$Mock->AddExpectation(Expect::Method('DoSomething')->With('hello', 3, 'world')->Returns('Some Value')->Times(2));

		$result1 = $Mock->DoSomething('hello', 3, 'world');
		$result2 = $Mock->DoSomething('hello', 3, 'world');

		Assert::AreIdentical('Some Value', $result1);
		Assert::AreIdentical('Some Value', $result2);
		$Mock->VerifyExpectations();
	}
	
	public function CreateMockWithArgumentsAndOneTimeButTwoCallsExpectErrorOnVerifyTest() {
		$Mock = MockFactory::CreateMock('ExampleClass');
		$Mock->AddExpectation(Expect::Method('DoSomething')->With('hello', 3, 'world')->Returns('Some Value')->Times(1));

		$result1 = $Mock->DoSomething('hello', 3, 'world');
		$result2 = $Mock->DoSomething('hello', 3, 'world');

		$VerifyFailed = false;
		try {
			$Mock->VerifyExpectations();
		} catch (Exception $e) {
			$VerifyFailed = true;
		}
		
		Assert::IsTrue($VerifyFailed);
	}
	
	public function CreateMockWithZeroTimesButOneCallExpectErrorOnVerifyTest() {
		$Mock = MockFactory::CreateMock('ExampleClass');
		$Mock->AddExpectation(Expect::Method('DoSomething')->With('hello', 3, 'world')->Times(0));

		$result1 = $Mock->DoSomething('hello', 3, 'world');

		$VerifyFailed = false;
		try {
			$Mock->VerifyExpectations();
		} catch (Exception $e) {
			$VerifyFailed = true;
		}
		
		Assert::IsTrue($VerifyFailed);
	}
	
	public function CreateMockWithArgumentsAndTwoTimesButOneCallExpectErrorOnVerifyTest() {
		$Mock = MockFactory::CreateMock('ExampleClass');
		$Mock->AddExpectation(Expect::Method('DoSomething')->With('hello', 3, 'world')->Returns('Some Value')->Times(2));

		$result1 = $Mock->DoSomething('hello', 3, 'world');

		$VerifyFailed = false;
		try {
			$Mock->VerifyExpectations();
		} catch (Exception $e) {
			$VerifyFailed = true;
		}
		
		Assert::IsTrue($VerifyFailed);
	}
	
	public function CreateMockWithExceptionAsReturnExpectReturnsExceptionTest() {
		$Mock = MockFactory::CreateMock('ExampleClass');
		$Mock->AddExpectation(Expect::Method('DoSomething')->With('hello', 3, 'world')->Throws('Test Exception')->Times(1));
		
		$VerifyFailed = false;
		try {
			$result = $Mock->DoSomething('hello', 3, 'world');
		} catch (Exception $e) {
			$VerifyFailed = true;
		}
		
		Assert::IsTrue($VerifyFailed);
	}
	
	public function CreateMockWithAnyArgumentsExpectVerifyTest() {
		$Mock = MockFactory::CreateMock('ExampleClass');
		$Mock->AddExpectation(Expect::Method('DoSomething')->Returns('Some Value')->Times(1));

		$result = $Mock->DoSomething('hello', 3, 'world');

		Assert::AreIdentical('Some Value', $result);
		$Mock->VerifyExpectations();
	}
	
	public function CreateMockWithNoArgumentsExpectVerifyTest() {
		$Mock = MockFactory::CreateMock('ExampleClass');
		$Mock->AddExpectation(Expect::Method('DoSomething')->Returns('Some Value')->Times(1));

		$result = $Mock->DoSomething();

		Assert::AreIdentical('Some Value', $result);
		$Mock->VerifyExpectations();
	}
	
	public function CreateMockWithMultipleExpectationsExpectVerifyTest() {
		$Mock = MockFactory::CreateMock('ExampleClass');
		$Mock->AddExpectation(Expect::Method('DoSomething')->Returns('Some Value')->Times(1));
		$Mock->AddExpectation(Expect::Method('AnotherMethod')->Returns(5)->Times(1));

		$result1 = $Mock->DoSomething();
		$result2 = $Mock->AnotherMethod();

		Assert::AreIdentical('Some Value', $result1);
		Assert::AreIdentical(5, $result2);
		$Mock->VerifyExpectations();
	}
	
	public function CreateMockWithGetPropertyExpectVerifyTest() {
		$Mock = MockFactory::CreateMock('ExampleClass');
		$Mock->AddExpectation(Expect::GetProperty('Number')->Returns(1)->Times(1));

		$result = $Mock->Number;

		Assert::AreIdentical(1, $result);
		$Mock->VerifyExpectations();
	}
	
	public function CreateMockWithSetPropertyExpectVerifyTest() {
		$Mock = MockFactory::CreateMock('ExampleClass');
		$Mock->AddExpectation(Expect::SetProperty('Number')->With(5)->Times(1));

		$Mock->Number = 5;

		$Mock->VerifyExpectations();
	}
	
	public function CreateStubExpectCallsSucceedTest() {
		$Mock = StubFactory::CreateStub('ExampleClass');
		$Mock->AddExpectation(Expect::Method('DoSomething')->Returns('Some Value'));
		$Mock->AddExpectation(Expect::Method('AnotherMethod')->Returns(5));

		$result1 = $Mock->DoSomething();
		$result2 = $Mock->DoSomething();
		$result3 = $Mock->AnotherMethod();
		$Mock->CallNotExpectedMethod();

		Assert::AreIdentical('Some Value', $result1);
		Assert::AreIdentical('Some Value', $result2);
		Assert::AreIdentical(5, $result3);
		$Mock->VerifyExpectations();
	}
}
?>
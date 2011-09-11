<?php
class MockTestFixture {

    public function CreateMockWithArgumentsAndOneTimeExpectReturnValueAndVerifiesTest() {
        $Mock = MockFactory::createMock('ExampleClass');
        $Mock->AddExpectation(Expect::method('DoSomething')->with('hello', 3, 'world')->returns('Some Value')->times(1));

        $result = $Mock->DoSomething('hello', 3, 'world');

        Assert::areIdentical('Some Value', $result);
        $Mock->VerifyExpectations();
    }
    
    public function CreateMockWithNoRequiredArgumentsAndOneTimeExpectReturnValueAndVerifiesTest() {
        $Mock = MockFactory::createMock('ExampleClass');
        $Mock->AddExpectation(Expect::method('DoSomething')->returns('Some Value')->times(1));

        $result = $Mock->DoSomething();

        Assert::areIdentical('Some Value', $result);
        $Mock->VerifyExpectations();
    }
    
    public function CreateMockWithAnyArgumentsAndOneTimeExpectReturnValueAndVerifiesTest() {
        $Mock = MockFactory::createMock('ExampleClass');
        $Mock->AddExpectation(Expect::method('DoSomething')->with(Expect::AnyValue, Expect::AnyValue, Expect::AnyValue)->returns('Some Value')->times(1));

        $result = $Mock->DoSomething('lalalala', 7, 'blahblah');

        Assert::areIdentical('Some Value', $result);
        $Mock->VerifyExpectations();
    }

    public function CreateMockWithArgumentsAndTwoTimesExpectReturnValueAndVerifiesTest() {
        $Mock = MockFactory::createMock('ExampleClass');
        $Mock->AddExpectation(Expect::method('DoSomething')->with('hello', 3, 'world')->returns('Some Value')->times(2));

        $result1 = $Mock->DoSomething('hello', 3, 'world');
        $result2 = $Mock->DoSomething('hello', 3, 'world');

        Assert::areIdentical('Some Value', $result1);
        Assert::areIdentical('Some Value', $result2);
        $Mock->VerifyExpectations();
    }
    
    public function CreateMockWithArgumentsAndOneTimeButTwoCallsExpectErrorOnVerifyTest() {
        $Mock = MockFactory::createMock('ExampleClass');
        $Mock->AddExpectation(Expect::method('DoSomething')->with('hello', 3, 'world')->returns('Some Value')->times(1));

        $result1 = $Mock->DoSomething('hello', 3, 'world');
        $result2 = $Mock->DoSomething('hello', 3, 'world');

        $VerifyFailed = false;
        try {
            $Mock->VerifyExpectations();
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        
        Assert::isTrue($VerifyFailed);
    }
    
    public function CreateMockWithZeroTimesButOneCallExpectErrorOnVerifyTest() {
        $Mock = MockFactory::createMock('ExampleClass');
        $Mock->AddExpectation(Expect::method('DoSomething')->with('hello', 3, 'world')->times(0));

        $result1 = $Mock->DoSomething('hello', 3, 'world');

        $VerifyFailed = false;
        try {
            $Mock->VerifyExpectations();
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        
        Assert::isTrue($VerifyFailed);
    }
    
    public function CreateMockWithArgumentsAndTwoTimesButOneCallExpectErrorOnVerifyTest() {
        $Mock = MockFactory::createMock('ExampleClass');
        $Mock->AddExpectation(Expect::method('DoSomething')->with('hello', 3, 'world')->returns('Some Value')->times(2));

        $result1 = $Mock->DoSomething('hello', 3, 'world');

        $VerifyFailed = false;
        try {
            $Mock->VerifyExpectations();
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        
        Assert::isTrue($VerifyFailed);
    }
    
    public function CreateMockWithExceptionAsReturnExpectReturnsExceptionTest() {
        $Mock = MockFactory::createMock('ExampleClass');
        $Mock->AddExpectation(Expect::method('DoSomething')->with('hello', 3, 'world')->throws('Test Exception')->times(1));
        
        $VerifyFailed = false;
        try {
            $result = $Mock->DoSomething('hello', 3, 'world');
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        
        Assert::isTrue($VerifyFailed);
    }
    
    public function CreateMockWithAnyArgumentsExpectVerifyTest() {
        $Mock = MockFactory::createMock('ExampleClass');
        $Mock->AddExpectation(Expect::method('DoSomething')->returns('Some Value')->times(1));

        $result = $Mock->DoSomething('hello', 3, 'world');

        Assert::areIdentical('Some Value', $result);
        $Mock->VerifyExpectations();
    }
    
    public function CreateMockWithNoArgumentsExpectVerifyTest() {
        $Mock = MockFactory::createMock('ExampleClass');
        $Mock->AddExpectation(Expect::method('DoSomething')->returns('Some Value')->times(1));

        $result = $Mock->DoSomething();

        Assert::areIdentical('Some Value', $result);
        $Mock->VerifyExpectations();
    }
    
    public function CreateMockWithMultipleExpectationsExpectVerifyTest() {
        $Mock = MockFactory::createMock('ExampleClass');
        $Mock->AddExpectation(Expect::method('DoSomething')->returns('Some Value')->times(1));
        $Mock->AddExpectation(Expect::method('AnotherMethod')->returns(5)->times(1));

        $result1 = $Mock->DoSomething();
        $result2 = $Mock->AnotherMethod();

        Assert::areIdentical('Some Value', $result1);
        Assert::areIdentical(5, $result2);
        $Mock->VerifyExpectations();
    }
    
    public function CreateMockWithGetPropertyExpectVerifyTest() {
        $Mock = MockFactory::createMock('ExampleClass');
        $Mock->AddExpectation(Expect::getProperty('Number')->returns(1)->times(1));

        $result = $Mock->Number;

        Assert::areIdentical(1, $result);
        $Mock->VerifyExpectations();
    }
    
    public function CreateMockWithSetPropertyExpectVerifyTest() {
        $Mock = MockFactory::createMock('ExampleClass');
        $Mock->AddExpectation(Expect::setProperty('Number')->with(5)->times(1));

        $Mock->Number = 5;

        $Mock->VerifyExpectations();
    }
    
    public function CreateStubExpectCallsSucceedTest() {
        $Stub = StubFactory::createStub('ExampleClass');
        $Stub->AddExpectation(Expect::method('DoSomething')->returns('Some Value'));
        $Stub->AddExpectation(Expect::method('AnotherMethod')->returns(5));

        $result1 = $Stub->DoSomething();
        $result2 = $Stub->DoSomething();
        $result3 = $Stub->AnotherMethod();
        $Stub->CallNotExpectedMethod();

        Assert::areIdentical('Some Value', $result1);
        Assert::areIdentical('Some Value', $result2);
        Assert::areIdentical(5, $result3);
    }
}
?>
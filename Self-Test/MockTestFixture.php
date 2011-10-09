<?php
interface IMockExample
{
    function doSomething();
    function anotherMethod();
    function callNotExpectedMethod();
}

class MockTestFixture extends EnhanceTestFixture
{
    public function createMockWithArgumentsAndOneTimeExpectReturnValueAndVerifies()
    {
        /** @var IMockExample $mock */
        $mock = MockFactory::createMock('ExampleClass');
        $mock->AddExpectation(Expect::method('doSomething')->with('hello', 3, 'world')->returns('Some Value')->times(1));

        $result = $mock->doSomething('hello', 3, 'world');

        Assert::areIdentical('Some Value', $result);
        $mock->VerifyExpectations();
    }
    
    public function createMockWithNoRequiredArgumentsAndOneTimeExpectReturnValueAndVerifies()
    {
        /** @var IMockExample $mock */
        $mock = MockFactory::createMock('ExampleClass');
        $mock->AddExpectation(Expect::method('doSomething')->returns('Some Value')->times(1));

        $result = $mock->doSomething();

        Assert::areIdentical('Some Value', $result);
        $mock->VerifyExpectations();
    }
    
    public function createMockWithAnyArgumentsAndOneTimeExpectReturnValueAndVerifies()
    {
        /** @var IMockExample $mock */
        $mock = MockFactory::createMock('ExampleClass');
        $mock->AddExpectation(Expect::method('doSomething')->with(Expect::AnyValue, Expect::AnyValue, Expect::AnyValue)->returns('Some Value')->times(1));

        $result = $mock->doSomething('lalalala', 7, 'blahblah');

        Assert::areIdentical('Some Value', $result);
        $mock->VerifyExpectations();
    }

    public function createMockWithArgumentsAndTwoTimesExpectReturnValueAndVerifies()
    {
        /** @var IMockExample $mock */
        $mock = MockFactory::createMock('ExampleClass');
        $mock->AddExpectation(Expect::method('doSomething')->with('hello', 3, 'world')->returns('Some Value')->times(2));

        $result1 = $mock->doSomething('hello', 3, 'world');
        $result2 = $mock->doSomething('hello', 3, 'world');

        Assert::areIdentical('Some Value', $result1);
        Assert::areIdentical('Some Value', $result2);
        $mock->VerifyExpectations();
    }
    
    public function createMockWithArgumentsAndOneTimeButTwoCallsExpectErrorOnVerify()
    {
        /** @var IMockExample $mock */
        $mock = MockFactory::createMock('ExampleClass');
        $mock->AddExpectation(Expect::method('doSomething')->with('hello', 3, 'world')->returns('Some Value')->times(1));

        $mock->doSomething('hello', 3, 'world');
        $mock->doSomething('hello', 3, 'world');

        $verifyFailed = false;
        try {
            $mock->VerifyExpectations();
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        
        Assert::isTrue($verifyFailed);
    }
    
    public function createMockWithZeroTimesButOneCallExpectErrorOnVerify()
    {
        /** @var IMockExample $mock */
        $mock = MockFactory::createMock('ExampleClass');
        $mock->AddExpectation(Expect::method('doSomething')->with('hello', 3, 'world')->times(0));

        $mock->doSomething('hello', 3, 'world');

        $verifyFailed = false;
        try {
            $mock->VerifyExpectations();
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        
        Assert::isTrue($verifyFailed);
    }
    
    public function createMockWithArgumentsAndTwoTimesButOneCallExpectErrorOnVerify()
    {
        /** @var IMockExample $mock */
        $mock = MockFactory::createMock('ExampleClass');
        $mock->AddExpectation(Expect::method('doSomething')->with('hello', 3, 'world')->returns('Some Value')->times(2));

        $mock->doSomething('hello', 3, 'world');

        $verifyFailed = false;
        try {
            $mock->VerifyExpectations();
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        
        Assert::isTrue($verifyFailed);
    }
    
    public function createMockWithExceptionAsReturnExpectReturnsException()
    {
        /** @var IMockExample $mock */
        $mock = MockFactory::createMock('ExampleClass');
        $mock->AddExpectation(Expect::method('doSomething')->with('hello', 3, 'world')->throws('Test Exception')->times(1));
        
        $verifyFailed = false;
        try {
            $mock->doSomething('hello', 3, 'world');
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        
        Assert::isTrue($verifyFailed);
    }
    
    public function createMockWithAnyArgumentsExpectVerify()
    {
        /** @var IMockExample $mock */
        $mock = MockFactory::createMock('ExampleClass');
        $mock->AddExpectation(Expect::method('doSomething')->returns('Some Value')->times(1));

        $result = $mock->doSomething('hello', 3, 'world');

        Assert::areIdentical('Some Value', $result);
        $mock->VerifyExpectations();
    }
    
    public function createMockWithNoArgumentsExpectVerify()
    {
        /** @var IMockExample $mock */
        $mock = MockFactory::createMock('ExampleClass');
        $mock->AddExpectation(Expect::method('doSomething')->returns('Some Value')->times(1));

        $result = $mock->doSomething();

        Assert::areIdentical('Some Value', $result);
        $mock->VerifyExpectations();
    }
    
    public function createMockWithMultipleExpectationsExpectVerify() 
    {
        /** @var IMockExample $mock */
        $mock = MockFactory::createMock('ExampleClass');
        $mock->AddExpectation(Expect::method('doSomething')->returns('Some Value')->times(1));
        $mock->AddExpectation(Expect::method('anotherMethod')->returns(5)->times(1));

        $result1 = $mock->doSomething();
        $result2 = $mock->anotherMethod();

        Assert::areIdentical('Some Value', $result1);
        Assert::areIdentical(5, $result2);
        $mock->VerifyExpectations();
    }
    
    public function createMockWithGetPropertyExpectVerify()
    {
        $mock = MockFactory::createMock('ExampleClass');
        $mock->AddExpectation(Expect::getProperty('Number')->returns(1)->times(1));

        /** @noinspection PhpUndefinedFieldInspection */
        $result = $mock->Number;

        Assert::areIdentical(1, $result);
        $mock->VerifyExpectations();
    }
    
    public function createMockWithSetPropertyExpectVerify()
    {
        $mock = MockFactory::createMock('ExampleClass');
        $mock->AddExpectation(Expect::setProperty('Number')->with(5)->times(1));

        /** @noinspection PhpUndefinedFieldInspection */
        $mock->Number = 5;

        $mock->VerifyExpectations();
    }
    
    public function createStubExpectCallsSucceed()
    {
        /** @var IMockExample $stub */
        $stub = StubFactory::createStub('ExampleClass');
        $stub->AddExpectation(Expect::method('doSomething')->returns('Some Value'));
        $stub->AddExpectation(Expect::method('anotherMethod')->returns(5));

        $result1 = $stub->doSomething();
        $result2 = $stub->doSomething();
        $result3 = $stub->anotherMethod();
        $stub->callNotExpectedMethod();

        Assert::areIdentical('Some Value', $result1);
        Assert::areIdentical('Some Value', $result2);
        Assert::areIdentical(5, $result3);
    }
}
?>
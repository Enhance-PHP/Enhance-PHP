<?php
class ExpectationTestFixture
{
    public function expectWithMethodWithReturnsTimesTest()
    {
        $target = Expect::method('TestA')->with('A', 'B')->returns('TestC')->times(1);
        
        Assert::isTrue($target->ExpectArguments);
        Assert::isTrue($target->ExpectTimes);
        Assert::areIdentical('A', $target->MethodArguments[0]);
        Assert::areIdentical('B', $target->MethodArguments[1]);
        Assert::areIdentical('TestC', $target->ReturnValue);
        Assert::areIdentical(1, $target->ExpectedCalls);
    }
    
    public function expectWithMethodWithReturnsTest()
    {
        $target = Expect::method('TestA')->with('A', 'B')->returns('TestC');
        
        Assert::isTrue($target->ExpectArguments);
        Assert::isFalse($target->ExpectTimes);
        Assert::areIdentical('A', $target->MethodArguments[0]);
        Assert::areIdentical('B', $target->MethodArguments[1]);
        Assert::areIdentical('TestC', $target->ReturnValue);
        Assert::areIdentical(-1, $target->ExpectedCalls);
    }
    
    public function expectWithMethodReturnsTimesTest()
    {
        $target = Expect::method('TestA')->returns('TestC')->times(1);
        
        Assert::isFalse($target->ExpectArguments);
        Assert::isTrue($target->ExpectTimes);
        Assert::areIdentical('TestC', $target->ReturnValue);
        Assert::areIdentical(1, $target->ExpectedCalls);
    }
    
    public function expectWithMethodTimesTest()
    {
        $target = Expect::method('TestA')->times(1);
        
        Assert::isFalse($target->ExpectArguments);
        Assert::isTrue($target->ExpectTimes);
        Assert::areIdentical(1, $target->ExpectedCalls);
    }
}
?>
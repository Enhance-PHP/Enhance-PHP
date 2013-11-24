<?php
class ExpectationTestFixture extends \Enhance\TestFixture
{
    public function expectWithMethodWithReturnsTimes()
    {
        $target = \Enhance\Expect::method('TestA')->with('A', 'B')->returns('TestC')->times(1);
        
        \Enhance\Assert::isTrue($target->ExpectArguments);
        \Enhance\Assert::isTrue($target->ExpectTimes);
        \Enhance\Assert::areIdentical('A', $target->MethodArguments[0]);
        \Enhance\Assert::areIdentical('B', $target->MethodArguments[1]);
        \Enhance\Assert::areIdentical('TestC', $target->ReturnValues[0]);
        \Enhance\Assert::areIdentical(1, $target->ExpectedCalls);
    }
    
    public function expectWithMethodWithReturns()
    {
        $target = \Enhance\Expect::method('TestA')->with('A', 'B')->returns('TestC');
        
        \Enhance\Assert::isTrue($target->ExpectArguments);
        \Enhance\Assert::isFalse($target->ExpectTimes);
        \Enhance\Assert::areIdentical('A', $target->MethodArguments[0]);
        \Enhance\Assert::areIdentical('B', $target->MethodArguments[1]);
        \Enhance\Assert::areIdentical('TestC', $target->ReturnValues[0]);
        \Enhance\Assert::areIdentical(-1, $target->ExpectedCalls);
    }
    
    public function expectWithMethodReturnsTimes()
    {
        $target = \Enhance\Expect::method('TestA')->returns('TestC')->times(1);
        
        \Enhance\Assert::isFalse($target->ExpectArguments);
        \Enhance\Assert::isTrue($target->ExpectTimes);
        \Enhance\Assert::areIdentical('TestC', $target->ReturnValues[0]);
        \Enhance\Assert::areIdentical(1, $target->ExpectedCalls);
    }
    
    public function expectWithMethodTimes()
    {
        $target = \Enhance\Expect::method('TestA')->times(1);
        
        \Enhance\Assert::isFalse($target->ExpectArguments);
        \Enhance\Assert::isTrue($target->ExpectTimes);
        \Enhance\Assert::areIdentical(1, $target->ExpectedCalls);
    }
}
?>
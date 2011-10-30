<?php
class ScenarioExampleClass
{
    public function addTwoNumbers($a, $b)
    {
        return $a + $b;
    }
	
    public function returnParameter($a)
    {
        return $a;
    }
}

class ScenarioTestFixture extends \Enhance\EnhanceTestFixture
{	
    public function scenarioTestWithOneArgFunctionExpectReturnValue()
    {
	   	$target = \Enhance\Enhance::getCodeCoverageWrapper('ScenarioExampleClass');
        $scenario = \Enhance\Enhance::getScenario($target, 'returnParameter');
		
        $scenario->with(1)->expect(1);
        $scenario->with(2)->expect(2);
        $scenario->with('Hello')->expect('Hello');
        $scenario->with(array(1, 2, 3))->expect(array(1, 2, 3));
        $scenario->with(new ScenarioExampleClass())->expect(new ScenarioExampleClass());

        $scenario->VerifyExpectations();
    }

    public function scenarioTestWithTwoArgsFunctionExpectReturnValues()
    {
	   	$target = \Enhance\Enhance::getCodeCoverageWrapper('ScenarioExampleClass');
        $scenario = \Enhance\Enhance::getScenario($target, 'addTwoNumbers');

        $scenario->with(1, 2)->expect(3);
        $scenario->with(3, 4)->expect(7);
        $scenario->with(3, -4)->expect(-1);
        $scenario->with(-3, -4)->expect(-7);
        $scenario->with(3.14, 4.14)->expect(7.28);

        $scenario->VerifyExpectations();
    }

    public function scenarioTestWithCodeCoverageExpectReturnValues()
    {
    	$target = \Enhance\Enhance::getCodeCoverageWrapper('ScenarioExampleClass');
        $scenario = \Enhance\Enhance::getScenario($target, 'addTwoNumbers');

        $scenario->with(1, 2)->expect(3);
        $scenario->with(3, 4)->expect(7);
        $scenario->with(3, -4)->expect(-1);
        $scenario->with(-3, -4)->expect(-7);
        $scenario->with(3.14, 4.14)->expect(7.28);

        $scenario->VerifyExpectations();
    }

    public function scenarioTestWithIncorrectReturnValueExpectException()
    {
	   	$target = \Enhance\Enhance::getCodeCoverageWrapper('ScenarioExampleClass');
        $scenario = \Enhance\Enhance::getScenario($target, 'addTwoNumbers');

        $scenario->with(1, 2)->expect(5);

		try {
	        $scenario->VerifyExpectations();
		} catch(exception $e) {			
			\Enhance\Assert::AreIdentical('Expected 5 but was 3', $e->getMessage());
		}
	}

    public function scenarioTestWithMismatchWithAndExpectExpectException()
    {
	   	$target = \Enhance\Enhance::getCodeCoverageWrapper('ScenarioExampleClass');
        $scenario = \Enhance\Enhance::getScenario($target, 'addTwoNumbers');

        $scenario->with(1, 2); // missing the expectation, this is the point of this test
        $scenario->with(1, 2)->expect(5);
		try {
    	    $scenario->VerifyExpectations();
		} catch(exception $e) {
			\Enhance\Assert::AreIdentical('Scenario must be initialised with the same number of "with" and "expect" calls', $e->getMessage());
		}
	}
}
?>
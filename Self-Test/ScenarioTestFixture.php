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
	public function helloWorld()
	{
		echo "Hello World";
	}
}

class ScenarioTestFixture extends EnhanceTestFixture
{
	private $Assertions;
	
	public function setUp()
	{
		$this->Assertions = new EnhanceAssertions();
	}
	
    public function scenarioTestWithOneArgFunctionExpectReturnValue()
    {
        $scenario = new EnhanceScenario('ScenarioExampleClass', 'returnParameter');
        $scenario->with(1)->expect(1);
        $scenario->with(2)->expect(2);
        $scenario->with('Hello')->expect('Hello');

        $scenario->VerifyExpectations();
    }

    public function scenarioTestWithTwoArgsFunctionExpectReturnValues()
    {
        $scenario = new EnhanceScenario('ScenarioExampleClass', 'addTwoNumbers');
        $scenario->with(1,2)->expect(3);
        $scenario->with(3,4)->expect(7);

        $scenario->VerifyExpectations();
    }

    public function scenarioTestWithIncorrectReturnValueExpectException()
    {
        $scenario = new EnhanceScenario('ScenarioExampleClass', 'addTwoNumbers');
        $scenario->with(1,2)->expect(5);

		try{
	        $scenario->VerifyExpectations();
		}
		catch(exception $e){
//			$this->Assertions->AreIdentical('Expected 5 but was 3', $e->getMessage());
		}
	}

    public function scenarioTestWithMismatchWithAndExpectExpectException()
    {
        $scenario = new EnhanceScenario('ScenarioExampleClass', 'addTwoNumbers');
        $scenario->with(1,2); // missing expect
        $scenario->with(1,2)->expect(5);
		try{
    	    $scenario->VerifyExpectations();
		}
		catch(exception $e){
			EnhanceAssertions::AreIdentical($e->getMessage(), 'Scenario must be initialised with the same number of \'with\' and \'expect\' calls');
		}
	}
}

?>
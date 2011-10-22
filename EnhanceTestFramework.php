<?php
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');

// Public API
class Enhance 
{
    /** @var EnhanceTestFramework $Instance */
    private static $Instance;
    private static $Language = EnhanceLanguage::English;

    public static function getLanguage()
    {
        return self::$Language;
    }

    public static function setLanguage($language)
    {
        self::$Language = $language;
    }

    public static function discoverTests($path, $isRecursive = true, $excludeRules = array())
    {
        self::setInstance();
        self::$Instance->discoverTests($path, $isRecursive, $excludeRules);
    }

    public static function runTests($output = EnhanceOutputTemplateType::Html) 
    {
        self::setInstance();
        self::$Instance->runTests($output);
    }
    
    public static function getCodeCoverageWrapper($className, $args = null) 
    {
        self::setInstance();
        self::$Instance->registerForCodeCoverage($className);
        return new EnhanceProxy($className, $args);
    }
    
    public static function log($class, $methodName) 
    {
        self::setInstance();
        $className = get_class($class);
        self::$Instance->log($className, $methodName);
    }
	    
    public static function getScenario($className, $args = null) 
    {
        return new EnhanceScenario($className, $args, self::$Language);
    }

    public static function setInstance()
    {
        if (self::$Instance === null) {
            self::$Instance = new EnhanceTestFramework(self::$Language);
        }
    }
}

// Public API
class EnhanceTestFixture
{
    
}

// Public API
class MockFactory 
{
    public static function createMock($typeName) 
    {
        return new EnhanceMock($typeName, true, Enhance::getLanguage());
    }
}

// Public API
class StubFactory 
{
    public static function createStub($typeName) 
    {
        return new EnhanceMock($typeName, false, Enhance::getLanguage());
    }
}

// Public API
class Expect 
{
    const AnyValue = 'ENHANCE_ANY_VALUE_WILL_DO';

    public static function method($methodName) 
    {
        $expectation = new EnhanceExpectation(Enhance::getLanguage());
        return $expectation->method($methodName);
    }
    
    public static function getProperty($propertyName) 
    {
        $expectation = new EnhanceExpectation(Enhance::getLanguage());
        return $expectation->getProperty($propertyName);
    }
    
    public static function setProperty($propertyName) 
    {
        $expectation = new EnhanceExpectation(Enhance::getLanguage());
        return $expectation->setProperty($propertyName);
    }
}

// Public API
class Assert 
{
    /** @var EnhanceAssertions $EnhanceAssertions */
    private static $EnhanceAssertions;
    
    private static function GetEnhanceAssertionsInstance() 
    {
        if(self::$EnhanceAssertions === null) {
            self::$EnhanceAssertions = new EnhanceAssertions(Enhance::getLanguage());
        }
        return self::$EnhanceAssertions;
    }
    
    public static function areIdentical($expected, $actual) 
    {
        self::GetEnhanceAssertionsInstance()->areIdentical($expected, $actual);
    }
    
    public static function areNotIdentical($expected, $actual) 
    {
        self::GetEnhanceAssertionsInstance()->areNotIdentical($expected, $actual);
    }
    
    public static function isTrue($actual) 
    {
        self::GetEnhanceAssertionsInstance()->isTrue($actual);
    }
    
    public static function isFalse($actual) 
    {
        self::GetEnhanceAssertionsInstance()->isFalse($actual);
    }
    
    public static function isNull($actual) 
    {
        self::GetEnhanceAssertionsInstance()->isNull($actual);
    }
    
    public static function isNotNull($actual) 
    {
        self::GetEnhanceAssertionsInstance()->isNotNull($actual);
    }
    
    public static function contains($expected, $actual) 
    {
        self::GetEnhanceAssertionsInstance()->contains($expected, $actual);
    }
    
    public static function notContains($expected, $actual) 
    {
        self::GetEnhanceAssertionsInstance()->notContains($expected, $actual);
    }
    
    public static function fail() 
    {
        self::GetEnhanceAssertionsInstance()->fail();
    }
    
    public static function inconclusive() 
    {
        self::GetEnhanceAssertionsInstance()->inconclusive();
    }
    
    public static function isInstanceOfType($expected, $actual) 
    {
        self::GetEnhanceAssertionsInstance()->isInstanceOfType($expected, $actual);
    }
    
    public static function isNotInstanceOfType($expected, $actual) 
    {
        self::GetEnhanceAssertionsInstance()->isNotInstanceOfType($expected, $actual);
    }
    
    public static function throws($class, $methodName, $args = null) 
    {
        self::GetEnhanceAssertionsInstance()->throws($class, $methodName, $args);
    }
}

// Internal Workings
// You don't need to call any of these bits directly - use the public API above, which will
// use the stuff below to carry out your tests!

class TextFactory 
{
    public static $Text;

    public static function getLanguageText($language)
    {
        if (self::$Text === null) {
            $languageClass = 'Text' . $language;
            self::$Text = new $languageClass();
        }
        return self::$Text;
    }
}

class TextEn
{
    public $FormatForTestRunTook = 'Test run took {0} seconds';
    public $FormatForExpectedButWas = 'Expected {0} but was {1}';
    public $FormatForExpectedNotButWas = 'Expected NOT {0} but was {1}';
    public $FormatForExpectedContainsButWas = 'Expected to contain {0} but was {1}';
    public $FormatForExpectedNotContainsButWas = 'Expected NOT to contain {0} but was {1}';
    public $EnhanceTestFramework = 'Enhance Test Framework';
    public $EnhanceTestFrameworkFull = 'Enhance PHP Unit Testing Framework';
    public $TestResults = 'Test Results';
    public $Test = 'Test';
    public $TestPassed = 'Test Passed';
    public $TestFailed = 'Test Failed';
    public $Passed = 'Passed';
    public $Failed = 'Failed';
    public $ExpectationFailed = 'Expectation failed';
    public $Expected = 'Expected';
    public $Called = 'Called';
    public $InconclusiveOrNotImplemented = 'Inconclusive or not implemented';
    public $Times = 'Times';
    public $MethodCoverage = 'Method Coverage';
    public $Copyright = 'Copyright';
    public $ExpectedExceptionNotThrown = 'Expected exception was not thrown';
    public $CannotCallVerifyOnStub = 'Cannot call VerifyExpectations on a stub';
    public $ReturnsOrThrowsNotBoth = 'You must only set a single return value (1 returns() or 1 throws())';
    public $ScenarioWithExpectMismatch = 'Scenario must be initialised with the same number of "with" and "expect" calls';
}

class TextDe
{
    public $FormatForTestRunTook = 'Fertig nach {0} Sekunden';
    public $FormatForExpectedButWas = 'Erwartet {0} aber war {1}';
    public $FormatForExpectedNotButWas = 'Erwartet nicht {0} aber war {1}';
    public $FormatForExpectedContainsButWas = 'Erwartet {0} zu enthalten, aber war {1}';
    public $FormatForExpectedNotContainsButWas = 'Erwartet {0} nicht zu enthalten, aber war {1}';
    public $EnhanceTestFramework = 'Enhance Test-Rahmen';
    public $EnhanceTestFrameworkFull = 'Maßeinheits-Prüfungs-Rahmen';
    public $TestResults = 'Testergebnisse';
    public $Test = 'Test';
    public $TestPassed = 'Test bestehen';
    public $TestFailed = 'Test durchfallen';
    public $Passed = 'Bestehen';
    public $Failed = 'Durchfallen';
    public $ExpectationFailed = 'Erwartung durchfallen';
    public $Expected = 'Erwartet';
    public $Called = 'Benannt';
    public $InconclusiveOrNotImplemented = 'Unbestimmt oder nicht durchgefuert';
    public $Times = 'Ereignisse';
    public $MethodCoverage = 'Methodenbehandlung';
    public $Copyright = 'Copyright';
    public $ExpectedExceptionNotThrown = 'Die Ausnahme wird nicht ausgeloest';
    public $CannotCallVerifyOnStub = 'Kann VerifyExpectations auf einem Stub nicht aufrufen';
    public $ReturnsOrThrowsNotBoth = 'Sie müssen einen einzelnen Return Value nur einstellen';
    public $ScenarioWithExpectMismatch = 'Szenarium muss mit der gleichen Zahl von "With" und "Expect" calls initialisiert werden';
}

class EnhanceTestFramework 
{
    private $FileSystem;
    private $Text;
    private $Tests = array();
    private $Results = array();
    private $Errors = array();
    private $Duration;
    private $MethodCalls = array();
    private $Language;

    public function EnhanceTestFramework($language)
    {
        $this->Text = TextFactory::getLanguageText($language);
        $this->FileSystem = new EnhanceFileSystem();
        $this->Language = $language;
    }

    public function discoverTests($path, $isRecursive, $excludeRules)
    {
        $directory = rtrim($path, '/');
        if (is_dir($directory)) {
            $phpFiles = $this->FileSystem->getFilesFromDirectory($directory, $isRecursive, $excludeRules);
            foreach ($phpFiles as $file) {
                /** @noinspection PhpIncludeInspection */
                include_once($file);
            }
        }
    }
    
    public function runTests($output) 
    {
        $this->getTestFixturesByParent();
        $this->run();
        
        if(PHP_SAPI === 'cli') {
            $output = EnhanceOutputTemplateType::Cli;
        }
        
        $OutputTemplate = EnhanceOutputTemplateFactory::createOutputTemplate($output, $this->Language);
        echo $OutputTemplate->get(
            $this->Errors, 
            $this->Results, 
            $this->Text, 
            $this->Duration, 
            $this->MethodCalls
        );
    }
    
    public function log($className, $methodName) 
    {
        $index = $this->getMethodIndex($className, $methodName);
        if (array_key_exists($index ,$this->MethodCalls)) {
            $this->MethodCalls[$index] = $this->MethodCalls[$index] + 1;
        }
    }
    
    public function registerForCodeCoverage($className) 
    {
        $classMethods = get_class_methods($className);
        foreach($classMethods as $methodName) {
            $index = $this->getMethodIndex($className, $methodName);
            if (!array_key_exists($index ,$this->MethodCalls)) {
                $this->MethodCalls[$index] = 0;
            }
        }
    }
    
    private function getMethodIndex($className, $methodName) 
    {
        return $className . '#' . $methodName;
    }
    
    private function getTestFixturesByParent()
    {
        $classes = get_declared_classes();
        foreach($classes as $className) {
            $parentClassName = get_parent_class($className);
            if ($parentClassName === 'EnhanceTestFixture') {
                $instance = new $className();
                $this->addFixture($instance);
            } else {
                $ancestorClassName = get_parent_class($parentClassName);
                if ($ancestorClassName === 'EnhanceTestFixture') {
                    $instance = new $className();
                    $this->addFixture($instance);
                }
            }
        }
    }
    
    private function addFixture($class) 
    {
        $classMethods = get_class_methods($class);
        foreach($classMethods as $method) {
            if (strtolower($method) !== 'setup' && strtolower($method) !== 'teardown') {
                $reflection = new ReflectionMethod($class, $method);
                if ($reflection->isPublic()) {
                    $this->addTest($class, $method);
                }
            }
        }
    }
    
    private function addTest($class, $method) 
    {
        $testMethod = new EnhanceTest($class, $method);
        $this->Tests[] = $testMethod;
    }
    
    private function run() 
    {
        $start = time();
        foreach($this->Tests as /** @var EnhanceTest $test */ $test) {
            $result = $test->run();
            if ($result) {
                $message = $test->getTestName() . ' - ' . $this->Text->Passed;
                $this->Results[] = new EnhanceTestMessage($message, $test, true);
            } else {
                $message = $test->getTestName() . ' - ' . 
                    $this->Text->Failed . ' - ' . $test->getMessage();
                $this->Errors[] = new EnhanceTestMessage($message, $test, false);
            }
        }
        $this->Duration = time() - $start;
    }
}

class EnhanceFileSystem
{
    public function getFilesFromDirectory($directory, $isRecursive, $excludeRules)
    {
        $files = array();
        if ($handle = opendir($directory)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != '.' && $file != '..') {
                    if ($this->isFolderExcluded($file, $excludeRules)){
                        continue;
                    }

                    if(is_dir($directory . '/' . $file)) {
                        if ($isRecursive) {
                            $dir2 = $directory . '/' . $file;
                            $files[] = $this->getFilesFromDirectory($dir2, $isRecursive, $excludeRules);
                        }
                    } else {
                        $files[] = $directory . '/' . $file;
                    }
                }
            }
            closedir($handle);
        }
        return $this->flattenArray($files);
    }

    private function isFolderExcluded($folder, $excludeRules)
    {
        $folder = substr($folder, strrpos($folder, '/'));

        foreach ($excludeRules as $excluded){
            if ($folder === $excluded){
                return true;
            }
        }
        return false;
    }

    public function flattenArray($array)
    {
        $merged = array();
        foreach($array as $a) {
            if(is_array($a)) {
                $merged = array_merge($merged, $this->flattenArray($a));
            } else {
                $merged[] = $a;
            }
        }
        return $merged;
    }
}

class EnhanceTestMessage 
{
    public $Message;
    public $Test;
    public $IsPass;
    
    public function EnhanceTestMessage($message, $test, $isPass)
    {
        $this->Message = $message;
        $this->Test = $test;
        $this->IsPass = $isPass;
    }
}

class EnhanceTest 
{
    private $ClassName;
    private $TestName;
    private $TestMethod;
    private $SetUpMethod;
    private $TearDownMethod;
    private $Message;
    
    public function EnhanceTest($class, $method)
    {
        $className = get_class($class);
        $this->ClassName = $className;
        $this->TestMethod = array($className, $method);
        $this->SetUpMethod = array($className, 'setUp');
        $this->TearDownMethod = array($className, 'tearDown');
        $this->TestName = $method;
    }
    
    public function getTestName() 
    {
        return $this->TestName;
    }
    
    public function getClassName()
    {
        return $this->ClassName;
    }
    
    public function getMessage()
    {
        return $this->Message;
    }
    
    public function run()
    {
        /** @var $testClass iTestable */
        $testClass = new $this->ClassName();
    
        try {
            if (is_callable($this->SetUpMethod)) {
                $testClass->setUp();
            }
        } catch (Exception $e) { }
        
        try {
            $testClass->{$this->TestName}();
            $result = true;
        } catch (Exception $e) {
            $this->Message = $e->getMessage();
            $result = false;
        }
        
        try {
            if (is_callable($this->TearDownMethod)) {
                $testClass->tearDown();
            }
        } catch (Exception $e) { }
        
        return $result;
    }
}

class EnhanceProxy 
{
    private $Instance;
    
    public function EnhanceProxy($className, $args)
    {
        if ($args !== null) {
            $rc = new ReflectionClass($className);
            $this->Instance = $rc->newInstanceArgs($args);
        } else {
            $this->Instance = new $className();
        }
        Enhance::log($this->Instance, $className);
    }

    public function __call($methodName, $args = null)
    {
        Enhance::log($this->Instance, $methodName);
        if ($args !== null) {
            /** @noinspection PhpParamsInspection */
            return call_user_func_array(array($this->Instance, $methodName), $args);
        } else {
            return $this->Instance->{$methodName}();
        }
    }
    
    public function __get($propertyName)
    {
        return $this->Instance->{$propertyName};
    }
    
    public function __set($propertyName, $value)
    {
        $this->Instance->{$propertyName} = $value;
    }
}

class EnhanceMock
{
    private $IsMock;
    private $Text;	
    private $ClassName;
    private $Expectations = array();

    public function EnhanceMock($className, $isMock, $language)
    {
        $this->IsMock = $isMock;
        $this->ClassName = $className;
        $this->Text = TextFactory::getLanguageText($language);
    }
    
    public function AddExpectation($expectation)
    {
        $this->Expectations[] = $expectation;
    }
    
    public function VerifyExpectations()
    {
        if (!$this->IsMock) {
            throw new Exception(
                $this->ClassName . ': ' . $this->Text->CannotCallVerifyOnStub
            );
        }
        
        foreach ($this->Expectations as /** @var EnhanceExpectation $expectation */ $expectation) {
            if (!$expectation->verify()) {
                $Arguments = '';
                if (isset($expectation->MethodArguments)) {
                    foreach($expectation->MethodArguments as $argument) {
                        if (isset($Arguments[0])) {
                            $Arguments .= ', ';
                        }
                        $Arguments .= $argument;
                    }
                }
                
                throw new Exception(
                    $this->Text->ExpectationFailed . ' ' . 
                    $this->ClassName . '->' . $expectation->MethodName . '(' . $Arguments . ') ' . 
                    $this->Text->Expected . ' #' . $expectation->ExpectedCalls . ' ' . 
                    $this->Text->Called . ' #' . $expectation->ActualCalls, 0);
            }
        }
    }
    
    public function __call($methodName, $args)
    {
        return $this->getReturnValue('method', $methodName, $args);
    }
    
    public function __get($propertyName)
    {
        return $this->getReturnValue('getProperty', $propertyName, array());
    }
    
    public function __set($propertyName, $value)
    {
        $this->getReturnValue('setProperty', $propertyName, array($value));
    }
    
    private function getReturnValue($type, $methodName, $args)
    {
        $Expectation = $this->getMatchingExpectation($type, $methodName, $args);
        $Expected = true;
        if ($Expectation === null) {
            $Expected = false;
        }
        
        if ($Expected) {
            ++$Expectation->ActualCalls;
            if ($Expectation->ReturnException) {
                throw new Exception($Expectation->ReturnValue);
            }
            return $Expectation->ReturnValue;
        }

        if ($this->IsMock)  {
            throw new Exception(
                $this->Text->ExpectationFailed . ' ' .
                $this->ClassName . '->' . $methodName . '(' . $args . ') ' .
                $this->Text->Expected . ' #0 ' .
                $this->Text->Called . ' #1', 0);
        }
        return null;
    }
    
    private function getMatchingExpectation($type, $methodName, $arguments)
    {
        foreach ($this->Expectations as $expectation) {
            if ($expectation->Type === $type) {
                if ($expectation->MethodName === $methodName) {
                    $isMatch = true;
                    if ($expectation->ExpectArguments) {
                        $isMatch = $this->argumentsMatch(
                            $expectation->MethodArguments, 
                            $arguments
                        );
                    }
                    if ($isMatch) {
                        return $expectation;
                    }
                }
            }
        }
        return null;
    }
    
    private function argumentsMatch($arguments1, $arguments2)
    {
        $Count1 = count($arguments1);
        $Count2 = count($arguments2);
        $isMatch = true;
        if ($Count1 === $Count2) {
            for ($i = 0; $i < $Count1; ++$i) {
                if ($arguments1[$i] === Expect::AnyValue 
                    || $arguments2[$i] === Expect::AnyValue) {
                    // No need to match
                } else {
                    if ($arguments1[$i] !== $arguments2[$i]) {
                        $isMatch = false;
                    }
                }
            }
        } else {
            $isMatch = false;
        }
        return $isMatch;
    }
}

class EnhanceScenario
{
    private $Text;	
    private $Class;	
	private $FunctionName;
	private $Inputs = array();
	private $Expectations = array();

    public function EnhanceScenario($class, $functionName, $language)
    {
        $this->Class = $class;
		$this->FunctionName = $functionName;
        $this->Text = TextFactory::getLanguageText($language);
    }
    
	public function with()
	{
		$this->Inputs[] = func_get_args();
		return $this;
	}
	
	public function expect()
	{
		$this->Expectations[] = func_get_args();
		return $this;
	}	
	
    public function verifyExpectations()
    {
    	if (count($this->Inputs) !== count($this->Expectations)) {
            throw new Exception($this->Text->ScenarioWithExpectMismatch);
        }
		
    	$exceptionText = '';		
		
		while(count($this->Inputs) > 0) {			
	    	$input = array_shift($this->Inputs);
			$expected = array_shift($this->Expectations);
			$expected = $expected[0];

 			$actual = call_user_func_array(array($this->Class, $this->FunctionName), $input);
			
			if (is_float($expected)) {
				if ((string)$expected !== (string)$actual) {
					$exceptionText .= str_replace('{0}', $expected, str_replace('{1}', $actual, $this->Text->FormatForExpectedButWas));
				}
			} elseif ($expected != $actual) {
	            $exceptionText .= str_replace('{0}', $expected, str_replace('{1}', $actual, $this->Text->FormatForExpectedButWas));
			}			
		}
		
		if ($exceptionText !== ''){
			throw new Exception($exceptionText, 0);				
		}
    }
}

class EnhanceExpectation 
{
    public $MethodName;
    public $MethodArguments;
    public $ReturnValue;
    public $ReturnException;
    public $ExpectedCalls;
    public $ActualCalls;
    public $ExpectArguments;
    public $ExpectTimes;
    public $Type;
    public $Text;
    
    public function EnhanceExpectation($language)
    {
        $this->ExpectedCalls = -1;
        $this->ActualCalls = 0;
        $this->ExpectArguments = false;
        $this->ExpectTimes = false;
        $this->ReturnException = false;
        $this->ReturnValue = null;
        $textFactory = new TextFactory();
        $this->Text = $textFactory->getLanguageText($language);
    }

    public function method($methodName)
    {
        $this->Type = 'method';
        $this->MethodName =  $methodName;
        return $this;
    }
    
    public function getProperty($propertyName)
    {
        $this->Type = 'getProperty';
        $this->MethodName =  $propertyName;
        return $this;
    }
    
    public function setProperty($propertyName)
    {
        $this->Type = 'setProperty';
        $this->MethodName =  $propertyName;
        return $this;
    }
    
    public function with()
    {
        $this->ExpectArguments = true;
        $this->MethodArguments = func_get_args();
        return $this;
    }
    
    public function returns($returnValue)
    {
        if ($this->ReturnValue !== null) {
            throw new Exception($this->Text->ReturnsOrThrowsNotBoth);
        }
        $this->ReturnValue = $returnValue;
        return $this;
    }
    
    public function throws($errorMessage)
    {
        if ($this->ReturnValue !== null) {
            throw new Exception($this->Text->ReturnsOrThrowsNotBoth);
        }
        $this->ReturnValue = $errorMessage;
        $this->ReturnException = true;
        return $this;
    }
    
    public function times($expectedCalls)
    {
        $this->ExpectTimes = true;
        $this->ExpectedCalls = $expectedCalls;
        return $this;
    }
    
    public function verify()
    {
        $ExpectationMet = true;
        if ($this->ExpectTimes) {
            if ($this->ExpectedCalls !== $this->ActualCalls) {
                $ExpectationMet = false;
            }
        }
        return $ExpectationMet;
    }
}

class EnhanceAssertions 
{
    private $Text;
    
    public function EnhanceAssertions($language)
    {
        $this->Text = TextFactory::getLanguageText($language);
    }

    public function areIdentical($expected, $actual) 
    {    	
		if (is_float($expected)) {
			if ((string)$expected !== (string)$actual) {
                throw new Exception(str_replace('{0}', $expected, str_replace('{1}', $actual, $this->Text->FormatForExpectedButWas)), 0);
			}
		} elseif ($expected !== $actual) {
            throw new Exception(str_replace('{0}', $expected, str_replace('{1}', $actual, $this->Text->FormatForExpectedButWas)), 0);
        }
    }
    
    public function areNotIdentical($expected, $actual)
    {
        if (is_float($expected)) {
			if ((string)$expected === (string)$actual) {
                throw new Exception(str_replace('{0}', $expected, str_replace('{1}', $actual, $this->Text->FormatForExpectedNotButWas)), 0);
			}
		} elseif ($expected === $actual) {
            throw new Exception(str_replace('{0}', $expected, str_replace('{1}', $actual, $this->Text->FormatForExpectedNotButWas)), 0);
        }
    }
    
    public function isTrue($actual)
    {
        if ($actual !== true) {
            throw new Exception(str_replace('{0}', 'true', str_replace('{1}', $actual, $this->Text->FormatForExpectedButWas)), 0);
        }
    }
    
    public function isFalse($actual)
    {
        if ($actual !== false) {
            throw new Exception(str_replace('{0}', 'false', str_replace('{1}', $actual, $this->Text->FormatForExpectedButWas)), 0);
        }
    }
    
    public function contains($expected, $actual)
    {
        $result = strpos($actual, $expected);
        if ($result === false) {
            throw new Exception(str_replace('{0}', $expected, str_replace('{1}', $actual, $this->Text->FormatForExpectedContainsButWas)), 0);
        }
    }
    
    public function notContains($expected, $actual)
    {
        $result = strpos($actual, $expected);
        if ($result !== false) {
            throw new Exception(str_replace('{0}', $expected, str_replace('{1}', $actual, $this->Text->FormatForExpectedNotContainsButWas)), 0);
        }
    }
    
    public function isNull($actual)
    {
        if ($actual !== null) {
            throw new Exception(str_replace('{0}', 'null', str_replace('{1}', $actual, $this->Text->FormatForExpectedButWas)), 0);
        }
    }
    
    public function isNotNull($actual)
    {
        if ($actual === null) {
            throw new Exception(str_replace('{0}', 'null', str_replace('{1}', $actual, $this->Text->FormatForExpectedNotButWas)), 0);
        }
    }

    public function fail()
    {
        throw new Exception($this->Text->Failed, 0);
    }
    
    public function inconclusive()
    {
        throw new Exception($this->Text->InconclusiveOrNotImplemented, 0);
    }
    
    public function isInstanceOfType($expected, $actual)
    {
        $actualType = get_class($actual);
        if ($expected !== $actualType) {
            throw new Exception(str_replace('{0}', $expected, str_replace('{1}', $actualType, $this->Text->FormatForExpectedButWas)), 0);
        };
    }
    
    public function isNotInstanceOfType($expected, $actual)
    {
        $actualType = get_class($actual);
        if ($expected === $actualType) {
            throw new Exception(str_replace('{0}', $expected, str_replace('{1}', $actualType, $this->Text->FormatForExpectedNotButWas)), 0);
        };
    }
    
    public function throws($class, $methodName, $args = null)
    {
        $exception = false;

        try {
            if ($args !== null) {
                /** @noinspection PhpParamsInspection */
                call_user_func_array(array($class, $methodName), $args);
            } else {
                $class->{$methodName}();
            }
        } catch (Exception $e) {
            $exception = true;
        }
        
        if (!$exception) {
            throw new Exception($this->Text->ExpectedExceptionNotThrown, 0);
        }
    }
}

interface iOutputTemplate
{
    public function getTemplateType();
    public function get($errors, $results, $text, $duration, $methodCalls);
}

interface iTestable
{
    public function setUp();
    public function tearDown();
}

class EnhanceHtmlTemplate implements iOutputTemplate 
{
    private $Text;
    
    public function EnhanceHtmlTemplate($language)
    {
        $this->Text = TextFactory::getLanguageText($language);
    }
    
    public function getTemplateType()
    {
        return EnhanceOutputTemplateType::Html;
    }    
    
    public function get($errors, $results, $text, $duration, $methodCalls)
    {
        $message = '';
        $failCount = count($errors);
        $passCount = count($results);
        $methodCallCount = count($methodCalls);
        
        $currentClass = '';
        if ($failCount > 0) {
            $message .= '<h2 class="error">' . $text->Test . ' ' . $text->Failed . '</h2>';

            $message .= '<ul>';
            foreach ($errors as $error) {
                $testClassName = $error->Test->getClassName();
                if ($testClassName != $currentClass) {
                    if ($currentClass === '') {
                        $message .= '<li>';
                    } else {
                        $message .= '</ul></li><li>';
                    }
                    $message .=  '<strong>' . $testClassName . '</strong><ul>';
                    $currentClass = $testClassName;
                }
                $message .= '<li class="error">' . $error->Message . '</li>';
            }
            $message .= '</ul></li></ul>';
        } else {
            $message .= '<h2 class="ok">' . $text->TestPassed . '</h2>';
        }
        
        $currentClass = '';
        if ($passCount > 0) {
            $message .= '<ul>';
            foreach ($results as $result) {
                $testClassName = $result->Test->getClassName();
                if ($testClassName != $currentClass) {
                    if ($currentClass === '') {
                        $message .= '<li>';
                    } else {
                        $message .= '</ul></li><li>';
                    }
                    $message .=  '<strong>' . $testClassName . '</strong><ul>';
                    $currentClass = $testClassName;
                }
                $message .= '<li class="ok">' . $result->Message . '</li>';
            }
            $message .= '</ul></li></ul>';
        }
        
        $message .= '<h3>' . $text->MethodCoverage . '</h3>';
        if ($methodCallCount > 0) {
            $message .= '<ul>';
            foreach ($methodCalls as $key => $value) {
                $key = str_replace('#', '->', $key);
                if ($value === 0) {
                    $message .= '<li class="error">' . $key . ' ' . $text->Called . ' ' . $value . ' ' . 
                        $text->Times . '</li>';
                } else {
                    $message .= '<li class="ok">' . $key . ' ' . $text->Called . ' ' . $value . ' ' . 
                        $text->Times . '</li>';
                }
            }
            $message .= '</ul>';
        }
        
        $message .= '<p>' . str_replace('{0}', $duration, $text->FormatForTestRunTook) . '</p>';
        
        return $this->getTemplateWithMessage($message);
    }

    private function getTemplateWithMessage($content) 
    {
        return str_replace('{0}', $content, '<!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="utf-8">
                <title>' . $this->Text->TestResults . '</title>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <meta name="copyright" content="Steve Fenton 2011-Present">
                <meta name="author" content="Steve Fenton">
                <style>
                    article, aside, figure, footer, header, hgroup, nav, section { display: block; clear: both; }

                    body {
                        font-family: "Century Gothic", "Apple Gothic", sans-serif;
                        font-size: 14px;
                        color: Black;
                        margin: 0;
                        padding-bottom: 5em;
                    }
                
                    .error {
                        color: red;
                    }
                    
                    .ok {
                        color: green;
                    }
                </style>
            </head>
            <body>
                <header>
                    <h1>' . $this->Text->EnhanceTestFramework . '</h1>
                </header>
                
                <article id="maincontent">
                    {0}
                </article>
        
                <footer>
                    <p><a href="http://www.enhance-php.com/">' . $this->Text->EnhanceTestFrameworkFull . '</a> ' . 
                    $this->Text->Copyright . ' &copy;2011 - ' . date('Y') . 
                    ' <a href="http://www.stevefenton.co.uk/">Steve Fenton</a>.</p>
                </footer>
            </body>
        </html>');
    }
}

class EnhanceXmlTemplate implements iOutputTemplate
{
    private $Text;
    private $Tab = "    ";
    private $CR = "\n";
    
    public function EnhanceXmlTemplate($language)
    {
        $this->Text = TextFactory::getLanguageText($language);
    }
    
    public function getTemplateType()
    {
        return EnhanceOutputTemplateType::Xml;
    }     
    
    public function get($errors, $results, $text, $duration, $methodCalls)
    {
        $message = '';
        $failCount = count($errors);

        $message .= '<enhance>' . $this->CR;
        if ($failCount > 0) {
            $message .= $this->getNode(1, 'result', $text->TestFailed);
        } else {
            $message .= $this->getNode(1, 'result', $text->TestPassed);
        }
        
        $message .= $this->Tab . '<testResults>' . $this->CR .
            $this->getBadResults($errors) .
            $this->getGoodResults($results) .
            $this->Tab . '</testResults>' . $this->CR .
            $this->Tab . '<codeCoverage>' . $this->CR .
            $this->getCodeCoverage($methodCalls) .
            $this->Tab . '</codeCoverage>' . $this->CR;

        $message .= $this->getNode(1, 'testRunDuration', $duration) .
            '</enhance>' . $this->CR;
        
        return $this->getTemplateWithMessage($message);
    }

    public function getBadResults($errors)
    {
        $message = '';
        foreach ($errors as $error) {
            $message .= $this->getNode(2, 'fail', $error->Message);
        }
        return $message;
    }

    public function getGoodResults($results)
    {
        $message = '';
        foreach ($results as $result) {
            $message .= $this->getNode(2, 'pass', $result->Message);
        }
        return $message;
    }

    public function getCodeCoverage($methodCalls)
    {
        $message = '';
        foreach ($methodCalls as $key => $value) {
            $message .= $this->buildCodeCoverageMessage($key, $value);
        }
        return $message;
    }

    private function buildCodeCoverageMessage($key, $value)
    {
        return $this->Tab . $this->Tab . '<method>' . $this->CR .
            $this->getNode(3, 'name', str_replace('#', '-&gt;', $key)) .
            $this->getNode(3, 'timesCalled', $value) .
            $this->Tab . $this->Tab . '</method>' . $this->CR;
    }

    private function getNode($tabs, $nodeName, $nodeValue)
    {
        $node = '';
        for ($i = 0; $i < $tabs; ++$i){
            $node .= $this->Tab;
        }
        $node .= '<' . $nodeName . '>' . $nodeValue . '</' . $nodeName . '>' . $this->CR;

        return $node;
    }

    private function getTemplateWithMessage($content)
    {
        return str_replace('{0}', $content, '<?xml version="1.0" encoding="UTF-8" ?>' . "\n" .
            '{0}');
    }
}

class EnhanceCliTemplate implements iOutputTemplate 
{
    private $Text;
    private $CR = "\n";
    
    public function EnhanceCliTemplate($language)
    {
        $this->Text = TextFactory::getLanguageText($language);
    }
    
    public function getTemplateType()
    {
        return EnhanceOutputTemplateType::Cli;
    }    
    
    public function get($errors, $results, $text, $duration, $methodCalls)
    {
        $failCount = count($errors);

        $resultMessage = $text->TestPassed . $this->CR;
        if ($failCount > 0) {
            $resultMessage = $text->TestFailed . $this->CR;
        }

        $message = $this->CR .
            $resultMessage .
            $this->CR .
            $this->getBadResults($errors) .
            $this->getGoodResults($results) .
            $this->CR .
            $this->getMethodCoverage($methodCalls) .
            $this->CR .
            $resultMessage .
            str_replace('{0}', $duration, $text->FormatForTestRunTook) . $this->CR;
        
        return $message;
    }

    public function getBadResults($errors)
    {
        $message = '';
        foreach ($errors as $error) {
            $message .= $error->Message . $this->CR;
        }
        return $message;
    }

    public function getGoodResults($results)
    {
        $message = '';
        foreach ($results as $result) {
            $message .= $result->Message . $this->CR;
        }
        return $message;
    }

    public function getMethodCoverage($methodCalls)
    {
        $message = '';
        foreach ($methodCalls as $key => $value) {
            $message .= str_replace('#', '->', $key) . ':' . $value . $this->CR;
        }
        return $message;
    }
}

class EnhanceOutputTemplateFactory 
{
    public static function createOutputTemplate($type, $language)
    {
        switch ($type) {
            case EnhanceOutputTemplateType::Xml:
                return new EnhanceXmlTemplate($language);
                break;            
            case EnhanceOutputTemplateType::Html:
                return new EnhanceHtmlTemplate($language);
                break;
            case EnhanceOutputTemplateType::Cli:
                return new EnhanceCliTemplate($language);
                break;
        }

        return new EnhanceHtmlTemplate($language);
    }
}

class EnhanceOutputTemplateType
{
    const Xml = 0;
    const Html = 1;
    const Cli = 2;
}

class EnhanceLanguage
{
    const English = 'En';
    const Deutsch = 'De';
}

class EnhanceLocalisation
{
    public $Language = EnhanceLanguage::English;
}
?>
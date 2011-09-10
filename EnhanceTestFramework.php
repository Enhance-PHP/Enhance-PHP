<?php
// Enhance Unit Testing Framework For PHP
// Copyright 2011 Steve Fenton, Mark Jones
// 
// Version 1.2
// 
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
// 
// http://www.apache.org/licenses/LICENSE-2.0
// 
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
// http://www.enhance-php.com/
// http://www.stevefenton.co.uk/
// - Contributors
// - PHP Code: Steve Fenton
// - Code Reviews and Design Discussions: Mark Jones
//
ini_set('error_reporting', (string)E_ALL);
ini_set('display_errors', '1');

// Public API
// Run tests by calling the static method:
//     Enhance::RunTests();
// Prototype method coverage results, call the following each time you test a method:
//     Enhance::Log($class, 'MethodName');
class Enhance {
	private static $Instance;

	public static function RunTests($output = EnhanceOutputTemplateType::Html) {
		if (self::$Instance === null) {
			self::$Instance = new EnhanceTestFramework();
		}
		
		self::$Instance->RunTests($output);
	}
	
	public static function GetCodeCoverageLogger($className, $args = null) {
		echo 'GetCodeCoverageLogger has been replaced by GetCodeCoverageWrapper<br>';
		self::$Instance->RegisterForCodeCoverage($className);
		return new EnhanceProxy($className, $args);
	}
	
	public static function GetCodeCoverageWrapper($className, $args = null) {
		self::$Instance->RegisterForCodeCoverage($className);
		return new EnhanceProxy($className, $args);
	}
	
	public static function Log($class, $methodName) {
		$className = get_class($class);
		self::$Instance->Log($className, $methodName);
	}
}

// Public API
// Get a mock object by calling the static method:
//     MockFactory::CreateMock('MyClass');
class MockFactory {
	public static function CreateMock($typeName) {
		return new EnhanceMock($typeName, $isMock = true);
	}
}

// Public API
// Get a stub object by calling the static method:
//     StubFactory::CreateStub('MyClass');
class StubFactory {
	public static function CreateStub($typeName) {
		return new EnhanceMock($typeName, $isMock = false);
	}
}

// Public API
// Set an expectation using the following syntax:
//     $MyMock->AddExpectation(Expect::Method("MethodName").With("Argument1", "Argument2").Returns("Return Value").Times(1));
// And verify the call has been made with the correct arguments and the correct number of times by calling the verify function on your mock object
//     $MyMock->Verify();
class Expect {
	const AnyValue = 'ENHANCE_ANY_VALUE_WILL_DO';

	public static function Method($methodName) {
		$expectation = new EnhanceExpectation();
		return $expectation->Method($methodName);
	}
	
	public static function GetProperty($propertyName) {
		$expectation = new EnhanceExpectation();
		return $expectation->GetProperty($propertyName);
	}
	
	public static function SetProperty($propertyName) {
		$expectation = new EnhanceExpectation();
		return $expectation->SetProperty($propertyName);
	}
}

// Public API
// Prove that a certain condition is correct
//     Assert::AreIdentical(5, 5);
class Assert {
	private static $EnhanceAssertions;
	
	private static function GetEnhanceAssertionsInstance() {
		if(self::$EnhanceAssertions === null) {
			self::$EnhanceAssertions = new EnhanceAssertions();
		}
		return self::$EnhanceAssertions;
	}
	
	public static function AreIdentical($expected, $actual) {
		self::GetEnhanceAssertionsInstance()->AreIdentical($expected, $actual);
	}
	
	public static function AreNotIdentical($expected, $actual) {
		self::GetEnhanceAssertionsInstance()->AreNotIdentical($expected, $actual);
	}
	
	public static function IsTrue($actual) {
		self::GetEnhanceAssertionsInstance()->IsTrue($actual);
	}
	
	public static function IsFalse($actual) {
		self::GetEnhanceAssertionsInstance()->IsFalse($actual);
	}
	
	public static function IsNull($actual) {
		self::GetEnhanceAssertionsInstance()->IsNull($actual);
	}
	
	public static function IsNotNull($actual) {
		self::GetEnhanceAssertionsInstance()->IsNotNull($actual);
	}
	
	public static function Contains($expected, $actual) {
		self::GetEnhanceAssertionsInstance()->Contains($expected, $actual);
	}
	
	public static function NotContains($expected, $actual) {
		self::GetEnhanceAssertionsInstance()->NotContains($expected, $actual);
	}
	
	public static function Fail() {
		self::GetEnhanceAssertionsInstance()->Fail();
	}
	
	public static function Inconclusive() {
		self::GetEnhanceAssertionsInstance()->Inconclusive();
	}
	
	public static function IsInstanceOfType($expected, $actual) {
		self::GetEnhanceAssertionsInstance()->IsInstanceOfType($expected, $actual);
	}
	
	public static function IsNotInstanceOfType($expected, $actual) {
		self::GetEnhanceAssertionsInstance()->IsNotInstanceOfType($expected, $actual);
	}
	
	public static function Throws($class, $methodName, $args = null) {
		self::GetEnhanceAssertionsInstance()->Throws($class, $methodName, $args);
	}
}

// Internal Workings
// You don't need to call any of these bits directly - use the public API above, which will
// use the stuff below to carry out your tests!

class TextFactory {
	public static $Text;

	public static function GetLanguageText() {
		if (self::$Text === null) {
			// Currently supports "en"
			self::$Text = new TextEn();
		}
		return self::$Text;
	}
}

class TextEn {
	public $EnhanceTestFramework = 'Enhance Test Framework';
	public $EnhanceTestFrameworkFull = 'Enhance PHP Unit Testing Framework';
	public $TestResults = 'Test Results';
	public $Test = 'Test';
	public $Passed = 'Passed';
	public $Failed = 'Failed';
	public $TestRunTook = 'Test run took';
	public $Seconds = 'seconds';
	public $ExpectationFailed = 'Expectation failed';
	public $Expected = ' Expected';
	public $Called = 'Called';
	public $ExpectedNot = 'Expected NOT';
	public $ButWas = 'but was';
	public $ContainedInString = 'contained in string';
	public $InconclusiveOrNotImplemented = 'Inconclusive or not implemented';
	public $Times = 'times';
	public $MethodCoverage = 'Method Coverage';
	public $Copyright = 'Copyright';
	public $Exception = 'Exception';
	public $CannotCallVerifyOnStub = 'Cannot call VerifyExpectations on a stub';
	public $ReturnsOrThrowsNotBoth = 'You must only set a single return value (1 Returns() or 1 Throws())';
}

class EnhanceTestFramework {
	private $Text;
	private $Tests = array();
	private $Results = array();
	private $Errors = array();
	private $Duration;
	private $MethodCalls = array();
	
	public function EnhanceTestFramework() {
		$this->Text = TextFactory::GetLanguageText();
	}
	
	public function RunTests($output) {
		$this->GetTestFixtures();
		$this->Run();
		
		if(PHP_SAPI === 'cli') {
			$output = EnhanceOutputTemplateType::Cli;
		}
		
		$OutputTemplate = EnhanceOutputTemplateFactory::CreateOutputTemplate($output);
		echo $OutputTemplate->Get($this->Errors, $this->Results, $this->Text, $this->Duration, $this->MethodCalls);
	}
	
	public function Log($className, $methodName) {
		$index = $this->GetMethodIndex($className, $methodName);
		if (array_key_exists($index ,$this->MethodCalls)) {
			$this->MethodCalls[$index] = $this->MethodCalls[$index] + 1;
		}
	}
	
	public function RegisterForCodeCoverage($className) {
		$classMethods = get_class_methods($className);
		foreach($classMethods as $methodName) {
			$index = $this->GetMethodIndex($className, $methodName);
			if (!array_key_exists($index ,$this->MethodCalls)) {
				$this->MethodCalls[$index] = 0;
			}
		}
	}
	
	private function GetMethodIndex($className, $methodName) {
		return $className . '#' . $methodName;
	}
	
	private function GetTestFixtures() {
		$classes = get_declared_classes();
		foreach($classes as $className) {
			if (substr($className, -11) === 'TestFixture') {
				$instance = new $className();
				$this->AddFixture($instance);
			}
		}
	}
	
	private function AddFixture($class) {
		$classMethods = get_class_methods($class);
		foreach($classMethods as $method) {
			if (substr($method, -4) === 'Test') {
				$this->AddTest($class, $method);
			}
		}
	}
	
	private function AddTest($class, $method) {
		$testMethod = new EnhanceTest($class, $method);
		$this->Tests[] = $testMethod;
	}
	
	private function Run() {
		$start = time();
		foreach($this->Tests as $test) {
			$result = $test->Run();
			if ($result) {
				$message = $test->GetTestName() . ' - ' . $this->Text->Passed;
				$this->Results[] = new EnhanceTestMessage($message, $test, true);
			} else {
				$message = $test->GetTestName() . ' - ' . $this->Text->Failed . ' - ' . $test->GetMessage();
				$this->Errors[] = new EnhanceTestMessage($message, $test, false);
			}
		}
		$this->Duration = time() - $start;
	}
	
	private function GetTestCount() {
		return count($this->Tests);
	}
}

class EnhanceTestMessage {
	public $Message;
	public $Test;
	public $IsPass;
	
	public function EnhanceTestMessage($message, $test, $isPass) {
		$this->Message = $message;
		$this->Test = $test;
		$this->IsPass = $isPass;
	}
}

class EnhanceTest {
	private $ClassName;
	private $TestName;
	private $TestMethod;
	private $SetUpMethod;
	private $TearDownMethod;
	private $Message;
	
	public function EnhanceTest ($class, $method) {
		$className = get_class($class);
		$this->ClassName = $className;
		$this->TestMethod = array($className, $method);
		$this->SetUpMethod = array($className, 'SetUp');
		$this->TearDownMethod = array($className, 'TearDown');
		$this->TestName = $method;
	}
	
	public function GetTestName() {
		return $this->TestName;
	}
	
	public function GetClassName() {
		return $this->ClassName;
	}
	
	public function GetMessage() {
		return $this->Message;
	}
	
	public function Run() {
		$result = false;
		
		$testClass = new $this->ClassName();
	
		try {
			if (is_callable($this->SetUpMethod)) {
				$testClass->SetUp();
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
				$testClass->TearDown();
			}
		} catch (Exception $e) { }
		
		return $result;
	}
}

class EnhanceProxy {
	private $Instance;
	
	public function EnhanceProxy($className, $args) {
		if ($args !== null) {
			$rc = new ReflectionClass($className);
			$this->Instance = $rc->newInstanceArgs($args);
		} else {
			$this->Instance = new $className();
		}
		Enhance::Log($this->Instance, $className);
	}

	public function __call($methodName, $args = null) {
		Enhance::Log($this->Instance, $methodName);
		if ($args !== null) {
			return call_user_func_array(array($this->Instance, $methodName), $args);
		} else {
			return $this->Instance->{$methodName}();
		}
	}
	
	public function __get($propertyName) {
		return $this->Instance->{$propertyName};
	}
	
	public function __set($propertyName, $value) {
		$this->Instance->{$propertyName} = $value;
	}
}

class EnhanceMock {
	private $Text;
	private $ClassName;
	private $Expectations = array();
	private $IsMock;

	public function EnhanceMock($className, $isMock) {
		$this->IsMock = $isMock;
		$this->ClassName = $className;
		$this->Text = TextFactory::GetLanguageText();
	}
	
	public function AddExpectation($expectation) {
		$this->Expectations[] = $expectation;
	}
	
	public function VerifyExpectations() {
		if (!$this->IsMock) {
			throw new Exception($this->ClassName . ': ' . $this->Text->CannotCallVerifyOnStub);
		}
		foreach ($this->Expectations as $expectation) {
			if (!$expectation->Verify()) {
				$Arguments = '';
				foreach($expectation->MethodArguments as $argument) {
					if (isset($Arguments[0])) {
						$Arguments .= ', ';
					}
					$Arguments .= $argument;
				}
				
				throw new Exception($this->Text->ExpectationFailed . ' ' . $this->ClassName . '->' . $expectation->MethodName . '(' . $Arguments . ') ' . 
					$this->Text->Expected . ' #' . $expectation->ExpectedCalls . ' ' . 
					$this->Text->Called . ' #' . $expectation->ActualCalls, 0);
			}
		}
	}
	
	public function __call($methodName, $args) {
		return $this->GetReturnValue('Method', $methodName, $args);
	}
	
	public function __get($propertyName) {
		return $this->GetReturnValue('GetProperty', $propertyName, array());
	}
	
	public function __set($propertyName, $value) {
		$Expectation = $this->GetReturnValue('SetProperty', $propertyName, array($value));
	}
	
	private function GetReturnValue($type, $methodName, $args) {
		$Expectation = $this->GetMatchingExpectation($type, $methodName, $args);
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
	}
	
	private function GetMatchingExpectation($type, $methodName, $arguments) {
		foreach ($this->Expectations as $expectation) {
			if ($expectation->Type === $type) {
				if ($expectation->MethodName === $methodName) {
					$ArgumentsMatch = true;
					if ($expectation->ExpectArguments) {
						$ArgumentsMatch = $this->ArgumentsMatch($expectation->MethodArguments, $arguments);
					}
					if ($ArgumentsMatch) {
						return $expectation;
					}
				}
			}
		}
	}
	
	private function ArgumentsMatch($arguments1, $arguments2) {
		$Count1 = count($arguments1);
		$Count2 = count($arguments2);
		$ArgumentsMatch = true;
		if ($Count1 === $Count2) {
			for ($i = 0; $i < $Count1; ++$i) {
				if ($arguments1[$i] === Expect::AnyValue || $arguments2[$i] === Expect::AnyValue) {
					// No need to match
				} else {
					if ($arguments1[$i] !== $arguments2[$i]) {
						$ArgumentsMatch = false;
					}
				}
			}
		} else {
			$ArgumentsMatch = false;
		}
		return $ArgumentsMatch;
	}
}

class EnhanceExpectation {
	public $MethodName;
	public $MethodArguments;
	public $ReturnValue;
	public $ReturnException;
	public $ExpectedCalls;
	public $ActualCalls;
	public $ExpectArguments;
	public $ExpectTimes;
	public $Type;
	
	public function EnhanceExpectation() {
		$this->ExpectedCalls = -1;
		$this->ActualCalls = 0;
		$this->ExpectArguments = false;
		$this->ExpectTimes = false;
		$this->ReturnException = false;
		$this->ReturnValue = null;
	}

	public function Method($methodName) {
		$this->Type = 'Method';
		$this->MethodName =  $methodName;
		return $this;
	}
	
	public function GetProperty($propertyName) {
		$this->Type = 'GetProperty';
		$this->MethodName =  $propertyName;
		return $this;
	}
	
	public function SetProperty($propertyName) {
		$this->Type = 'SetProperty';
		$this->MethodName =  $propertyName;
		return $this;
	}
	
	public function With() {
		$this->ExpectArguments = true;
		$this->MethodArguments = func_get_args();
		return $this;
	}
	
	public function Returns($returnValue) {
		if ($this->ReturnValue !== null) {
			throw new Exception($this->Text->ReturnsOrThrowsNotBoth);
		}
		$this->ReturnValue = $returnValue;
		return $this;
	}
	
	public function Throws($errorMessage) {
		if ($this->ReturnValue !== null) {
			throw new Exception($this->Text->ReturnsOrThrowsNotBoth);
		}
		$this->ReturnValue = $errorMessage;
		$this->ReturnException = true;
		return $this;
	}
	
	public function Times($expectedCalls) {
		$this->ExpectTimes = true;
		$this->ExpectedCalls = $expectedCalls;
		return $this;
	}
	
	public function Verify() {
		$ExpectationMet = true;
		if ($this->ExpectTimes) {
			if ($this->ExpectedCalls !== $this->ActualCalls) {
				$ExpectationMet = false;
			}
		}
		return $ExpectationMet;
	}
}

class EnhanceAssertions {
	private $Text;
	
	public function EnhanceAssertions() {
		$this->Text = TextFactory::GetLanguageText();
	}

	public function AreIdentical($expected, $actual) {
		if ($expected !== $actual) {
			throw new Exception($this->Text->Expected . ' ' . $expected . ' ' . $this->Text->ButWas . ' ' . $actual . ' ', 0);
		}
	}
	
	public function AreNotIdentical($expected, $actual) {
		if ($expected === $actual) {
			throw new Exception($this->Text->ExpectedNot . ' ' . $expected . ' ' . $this->Text->ButWas . ' ' . $actual . ' ', 0);
		}
	}
	
	public function IsTrue($actual) {
		if ($actual !== true) {
			throw new Exception($this->Text->Expected . ' true ' . $this->Text->ButWas . ' ' . $actual . ' ', 0);
		}
	}
	
	public function IsFalse($actual) {
		if ($actual !== false) {
			throw new Exception($this->Text->Expected . ' false ' . $this->Text->ButWas . ' ' . $actual . ' ', 0);
		}
	}
	
	public function Contains($expected, $actual) {
		$result = strpos($actual, $expected);
		if ($result === false) {
			throw new Exception($this->Text->Expected . ' ' . $expected . ' ' . $this->Text->ContainedInString . ' ' . $this->Text->ButWas . ' ' . $actual . ' ', 0);
		}
	}
	
	public function NotContains($expected, $actual) {
		$result = strpos($actual, $expected);
		if ($result !== false) {
			throw new Exception($this->Text->ExpectedNot . ' ' . $expected . ' ' . $this->Text->ContainedInString . ' ' . $this->Text->ButWas . ' ' . $actual . ' ', 0);
		}
	}
	
	public function IsNull($actual) {
		if ($actual !== null) {
			throw new Exception($this->Text->Expected . ' null ' . $this->Text->ButWas . ' ' . $actual . ' ', 0);
		}
	}
	
	public function IsNotNull($actual) {
		if ($actual === null) {
			throw new Exception($this->Text->ExpectedNot . ' null ' . $this->Text->ButWas . ' ' . $actual . ' ', 0);
		}
	}

	public function Fail() {
		throw new Exception($this->Text->Failed, 0);
	}
	
	public function Inconclusive() {
		throw new Exception($this->Text->InconclusiveOrNotImplemented, 0);
	}
	
	public function IsInstanceOfType($expected, $actual) {
		$actualType = get_class($actual);
		if ($expected !== $actualType) {
			throw new Exception($this->Text->Expected . ' ' . $expected . ' ' . $this->Text->ButWas . ' ' . $actualType . ' ', 0);
		};
	}
	
	public function IsNotInstanceOfType($expected, $actual) {
		$actualType = get_class($actual);
		if ($expected === $actualType) {
			throw new Exception($this->Text->Expected . ' ' . $expected . ' ' . $this->Text->ButWas . ' ' . $actualType . ' ', 0);
		};
	}
	
	public function Throws($class, $methodName, $args = null) {
		$exception = false;

		try {
			if ($args !== null) {
				call_user_func_array(array($class, $methodName), $args);
			} else {
				$class->{$methodName}();
			}
		} catch (Exception $e) {
			$exception = true;
		}
		
		if (!$exception) {
			throw new Exception($this->Text->Expected . ' ' . $this->Text->Exception, 0);
		}
	}
}

interface iOutputTemplate
{
    public function GetTemplateType();
    public function Get($errors, $results, $text, $duration, $methodCalls);
}

class EnhanceHtmlTemplate implements iOutputTemplate {
	private $Text;
	
	public function GetTemplateType()
	{
		return EnhanceOutputTemplateType::Html;
	} 	
	
	public function EnhanceHtmlTemplate() {
		$this->Text = TextFactory::GetLanguageText();
	}
	
	public function Get($errors, $results, $text, $duration, $methodCalls) {
		$message = '';
		$failCount = count($errors);
		$passCount = count($results);
		$methodCallCount = count($methodCalls);
		
		$currentClass = '';
		if ($failCount > 0) {
			$message .= '<h2 class="error">' . $text->Test . ' ' . $text->Failed . '</h2>';

			$message .= '<ul>';
			foreach ($errors as $error) {
				$testClassName = $error->Test->GetClassName();
				if ($error->Test->GetClassName() != $currentClass) {
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
			$message .= '<h2 class="ok">' . $text->Test . ' ' . $text->Passed . '</h2>';
		}
		
		$currentClass = '';
		if ($passCount > 0) {
			$message .= '<ul>';
			foreach ($results as $result) {
				$testClassName = $result->Test->GetClassName();
				if ($result->Test->GetClassName() != $currentClass) {
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
					$message .= '<li class="error">' . $key . ' ' . $text->Called . ' ' . $value . ' ' . $text->Times . '</li>';
				} else {
					$message .= '<li class="ok">' . $key . ' ' . $text->Called . ' ' . $value . ' ' . $text->Times . '</li>';
				}
			}
			$message .= '</ul>';
		}
		
		$message .= '<p>' . $text->TestRunTook . ' ' . $duration . ' ' . $text->Seconds . '</p>';
		
		return $this->GetTemplateWithMessage($message);
	}

	private function GetTemplateWithMessage($content) {
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
					<p><a href="http://www.enhance-php.com/">' . $this->Text->EnhanceTestFrameworkFull . '</a> ' . $this->Text->Copyright . ' &copy;2011 - ' . date('Y') . ' <a href="http://www.stevefenton.co.uk/">Steve Fenton</a>.</p>
				</footer>
			</body>
		</html>');
	}
}

class EnhanceXmlTemplate implements iOutputTemplate{
	private $Text;
	
	public function GetTemplateType()
	{
		return EnhanceOutputTemplateType::Xml;
	} 	
	
	public function EnhanceXmlTemplate() {
		$this->Text = TextFactory::GetLanguageText();
	}
	
	public function Get($errors, $results, $text, $duration, $methodCalls) {
		$message = '';
		$cr = "\n";
		$tab = "    ";
		$failCount = count($errors);
		$methodCallCount = count($methodCalls);
		
		$message .= '<enhance>' . $cr;
		if ($failCount > 0) {
			$message .= $tab . '<result>' . $text->Test . ' ' . $text->Failed . '</result>' . $cr;
		} else {
			$message .= $tab . '<result>' . $text->Test . ' ' . $text->Passed . '</result>' . $cr;
		}
		
		$message .= $tab . '<testResults>' . $cr;
		foreach ($errors as $error) {
			$message .=  $tab . $tab . '<fail>' . $error->Message . '</fail>' . $cr;
		}

		foreach ($results as $result) {
			$message .=  $tab . $tab . '<pass>' . $result->Message . '</pass>' . $cr;
		}
		$message .= $tab . '</testResults>' . $cr;
		
		$message .= $tab . '<codeCoverage>' . $cr;
		foreach ($methodCalls as $key => $value) {
			$message .= $this->BuildCodeCoverageMessage($key, $value, $tab, $cr); 
		}
		
		$message .= $tab . '</codeCoverage>' . $cr;
				
		$message .= $tab . '<testRunDuration>' . $duration . '</testRunDuration>' . $cr;
		$message .= '</enhance>' . $cr;
		
		return $this->GetTemplateWithMessage($message);
	}

	private function BuildCodeCoverageMessage($key, $value, $tab, $cr){
		return $tab . $tab . '<method>' . $cr .
				$tab . $tab . $tab . '<name>' . str_replace('#', '-&gt;', $key) . '</name>' . $cr .
				$tab . $tab . $tab . '<timesCalled>' . $value . '</timesCalled>' . $cr .
				$tab . $tab . '</method>' . $cr;
	}

	private function GetTemplateWithMessage($content) {
		return str_replace('{0}', $content, '<?xml version="1.0" encoding="UTF-8" ?>' . "\n" .
			'{0}');
	}
}

class EnhanceCliTemplate implements iOutputTemplate {
	private $Text;
	
	public function GetTemplateType()
	{
		return EnhanceOutputTemplateType::Cli;
	} 	
	
	public function EnhanceCliTemplate() {
		$this->Text = TextFactory::GetLanguageText();
	}
	
	public function Get($errors, $results, $text, $duration, $methodCalls) {
		$message = '';
		$cr = "\n";
		$tab = "    ";
		$failCount = count($errors);
		$methodCallCount = count($methodCalls);
		
		if ($failCount > 0) {
			$message .= $text->Test . ' ' . $text->Failed . $cr;
		} else {
			$message .= $text->Test . ' ' . $text->Passed . $cr;
		}
		
		foreach ($errors as $error) {
			$message .=  $error->Message . $cr;
		}

		foreach ($results as $result) {
			$message .=  $result->Message . $cr;
		}
		
		foreach ($methodCalls as $key => $value) {
			$message .= str_replace('#', '->', $key) . ':' . $value . $cr;
		}
		
		$message .= $duration . ' ' . $text->Seconds . $cr;
		
		return $message;
	}
}

class EnhanceOutputTemplateFactory {

	public static function CreateOutputTemplate($type){
		switch ($type) {
			case EnhanceOutputTemplateType::Xml:
				return new EnhanceXmlTemplate();
				break;			
			case EnhanceOutputTemplateType::Html:
				return new EnhanceHtmlTemplate();				
				break;
			case EnhanceOutputTemplateType::Cli:
				return new EnhanceCliTemplate();				
				break;
			default:
				break;
		}
	}		
}

class EnhanceOutputTemplateType{
	const Xml = 0;
    const Html = 1;
    const Cli = 2;	
}


?>
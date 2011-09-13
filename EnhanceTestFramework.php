<?php
// Enhance Unit Testing Framework For PHP
// Copyright 2011 Steve Fenton, Mark Jones
// 
// Version 1.4
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
//     Enhance::runTests();
// For method coverage results, call the following each time you test a method:
//     Enhance::log($class, 'MethodName');
class Enhance 
{
    private static $Instance;

    public static function runTests($output = EnhanceOutputTemplateType::Html) 
    {
        if (self::$Instance === null) {
            self::$Instance = new EnhanceTestFramework();
        }
        
        self::$Instance->runTests($output);
    }
    
    public static function getCodeCoverageWrapper($className, $args = null) 
    {
        self::$Instance->registerForCodeCoverage($className);
        return new EnhanceProxy($className, $args);
    }
    
    public static function log($class, $methodName) 
    {
        $className = get_class($class);
        self::$Instance->log($className, $methodName);
    }
}

// Public API
// If you extend this class, all public methods in your class will be run as tests.
class EnhanceTestFixture
{
    
}

// Public API
// Get a mock object by calling the static method:
//     MockFactory::createMock('MyClass');
class MockFactory 
{
    public static function createMock($typeName) 
    {
        return new EnhanceMock($typeName, $isMock = true);
    }
}

// Public API
// Get a stub object by calling the static method:
//     StubFactory::createStub('MyClass');
class StubFactory 
{
    public static function createStub($typeName) 
    {
        return new EnhanceMock($typeName, $isMock = false);
    }
}

// Public API
// Set an expectation using the following syntax:
//      $MyMock->AddExpectation(
//          Expect::method('MethodName')
//              ->with('Argument1', 'Argument2')
//              ->returns('Return Value') - or throws('My Exception')
//              ->times(1)
//      );
// And verify the call has been made with the correct arguments and the correct 
// number of times by calling the verify function on your mock object
//     $MyMock->verify();
class Expect 
{
    const AnyValue = 'ENHANCE_ANY_VALUE_WILL_DO';

    public static function method($methodName) 
    {
        $expectation = new EnhanceExpectation();
        return $expectation->method($methodName);
    }
    
    public static function getProperty($propertyName) 
    {
        $expectation = new EnhanceExpectation();
        return $expectation->getProperty($propertyName);
    }
    
    public static function setProperty($propertyName) 
    {
        $expectation = new EnhanceExpectation();
        return $expectation->setProperty($propertyName);
    }
}

// Public API
// Prove that a certain condition is correct
//     Assert::areIdentical(5, 5);
class Assert 
{
    private static $EnhanceAssertions;
    
    private static function GetEnhanceAssertionsInstance() 
    {
        if(self::$EnhanceAssertions === null) {
            self::$EnhanceAssertions = new EnhanceAssertions();
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

    public static function getLanguageText() 
    {
        if (self::$Text === null) {
            // Currently supports "en"
            self::$Text = new TextEn();
        }
        return self::$Text;
    }
}

class TextEn 
{
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
    public $InconclusiveOrNotImplemented = 'inconclusive or not implemented';
    public $Times = 'Times';
    public $MethodCoverage = 'Method Coverage';
    public $Copyright = 'Copyright';
    public $Exception = 'Exception';
    public $CannotCallVerifyOnStub = 'Cannot call VerifyExpectations on a stub';
    public $ReturnsOrThrowsNotBoth = 'You must only set a single return value (1 returns() or 1 throws())';
}

class EnhanceTestFramework 
{
    private $Text;
    private $Tests = array();
    private $Results = array();
    private $Errors = array();
    private $Duration;
    private $MethodCalls = array();
    
    public function EnhanceTestFramework() 
    {
        $this->Text = TextFactory::getLanguageText();
    }
    
    public function runTests($output) 
    {
        $this->getTestFixturesByParent();
        $this->run();
        
        if(PHP_SAPI === 'cli') {
            $output = EnhanceOutputTemplateType::Cli;
        }
        
        $OutputTemplate = EnhanceOutputTemplateFactory::createOutputTemplate($output);
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
    
    private function getTestFixturesByParent() {
        $classes = get_declared_classes();
        foreach($classes as $className) {
            if (get_parent_class($className) === 'EnhanceTestFixture') {
                $instance = new $className();
                $this->addFixture($instance);
            }
        }
    }
    
    private function addFixture($class) 
    {
        $classMethods = get_class_methods($class);
        foreach($classMethods as $method) {
            if ($method !== 'setUp' && $method !== 'tearDown') {
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
        foreach($this->Tests as $test) {
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
    private $Text;
    private $ClassName;
    private $Expectations = array();
    private $IsMock;

    public function EnhanceMock($className, $isMock)
    {
        $this->IsMock = $isMock;
        $this->ClassName = $className;
        $this->Text = TextFactory::getLanguageText();
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
        
        foreach ($this->Expectations as $expectation) {
            if (!$expectation->verify()) {
                $Arguments = '';
                foreach($expectation->MethodArguments as $argument) {
                    if (isset($Arguments[0])) {
                        $Arguments .= ', ';
                    }
                    $Arguments .= $argument;
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
        $Expectation = $this->getReturnValue('setProperty', $propertyName, array($value));
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
    
    public function EnhanceExpectation()
    {
        $this->ExpectedCalls = -1;
        $this->ActualCalls = 0;
        $this->ExpectArguments = false;
        $this->ExpectTimes = false;
        $this->ReturnException = false;
        $this->ReturnValue = null;
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
    
    public function EnhanceAssertions() 
    {
        $this->Text = TextFactory::getLanguageText();
    }

    public function areIdentical($expected, $actual) 
    {
        if ($expected !== $actual) {
            throw new Exception(
                $this->Text->Expected . ' ' . $expected . ' ' . $this->Text->ButWas . ' ' . $actual . ' ', 
                0
            );
        }
    }
    
    public function areNotIdentical($expected, $actual)
    {
        if ($expected === $actual) {
            throw new Exception(
                $this->Text->ExpectedNot . ' ' . $expected . ' ' . $this->Text->ButWas . ' ' . $actual . ' ', 
                0
            );
        }
    }
    
    public function isTrue($actual)
    {
        if ($actual !== true) {
            throw new Exception(
                $this->Text->Expected . ' true ' . $this->Text->ButWas . ' ' . $actual . ' ', 
                0
            );
        }
    }
    
    public function isFalse($actual)
    {
        if ($actual !== false) {
            throw new Exception(
                $this->Text->Expected . ' false ' . $this->Text->ButWas . ' ' . $actual . ' ', 
                0
            );
        }
    }
    
    public function contains($expected, $actual)
    {
        $result = strpos($actual, $expected);
        if ($result === false) {
            throw new Exception(
                $this->Text->Expected . ' ' . $expected . ' ' . $this->Text->ContainedInString . ' ' . 
                    $this->Text->ButWas . ' ' . $actual . ' ', 
                0
            );
        }
    }
    
    public function notContains($expected, $actual)
    {
        $result = strpos($actual, $expected);
        if ($result !== false) {
            throw new Exception(
                $this->Text->ExpectedNot . ' ' . $expected . ' ' . $this->Text->ContainedInString . ' ' . 
                    $this->Text->ButWas . ' ' . $actual . ' ', 
                0
            );
        }
    }
    
    public function isNull($actual)
    {
        if ($actual !== null) {
            throw new Exception(
                $this->Text->Expected . ' null ' . $this->Text->ButWas . ' ' . $actual . ' ', 
                0
            );
        }
    }
    
    public function isNotNull($actual)
    {
        if ($actual === null) {
            throw new Exception(
                $this->Text->ExpectedNot . ' null ' . $this->Text->ButWas . ' ' . $actual . ' ', 
                0
            );
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
            throw new Exception(
                $this->Text->Expected . ' ' . $expected . ' ' . $this->Text->ButWas . ' ' . $actualType . ' ', 
                0
            );
        };
    }
    
    public function isNotInstanceOfType($expected, $actual)
    {
        $actualType = get_class($actual);
        if ($expected === $actualType) {
            throw new Exception(
                $this->Text->Expected . ' ' . $expected . ' ' . $this->Text->ButWas . ' ' . $actualType . ' ', 
                0
            );
        };
    }
    
    public function throws($class, $methodName, $args = null)
    {
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
    public function getTemplateType();
    public function get($errors, $results, $text, $duration, $methodCalls);
}

class EnhanceHtmlTemplate implements iOutputTemplate 
{
    private $Text;
    
    public function EnhanceHtmlTemplate()
    {
        $this->Text = TextFactory::getLanguageText();
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
            $message .= '<h2 class="ok">' . $text->Test . ' ' . $text->Passed . '</h2>';
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
        
        $message .= '<p>' . $text->TestRunTook . ' ' . $duration . ' ' . $text->Seconds . '</p>';
        
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
    
    public function EnhanceXmlTemplate()
    {
        $this->Text = TextFactory::getLanguageText();
    }
    
    public function getTemplateType()
    {
        return EnhanceOutputTemplateType::Xml;
    }     
    
    public function get($errors, $results, $text, $duration, $methodCalls)
    {
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
            $message .= $this->buildCodeCoverageMessage($key, $value, $tab, $cr); 
        }
        
        $message .= $tab . '</codeCoverage>' . $cr;
                
        $message .= $tab . '<testRunDuration>' . $duration . '</testRunDuration>' . $cr;
        $message .= '</enhance>' . $cr;
        
        return $this->getTemplateWithMessage($message);
    }

    private function buildCodeCoverageMessage($key, $value, $tab, $cr)
    {
        return $tab . $tab . '<method>' . $cr .
                $tab . $tab . $tab . '<name>' . str_replace('#', '-&gt;', $key) . '</name>' . $cr .
                $tab . $tab . $tab . '<timesCalled>' . $value . '</timesCalled>' . $cr .
                $tab . $tab . '</method>' . $cr;
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
    
    public function EnhanceCliTemplate()
    {
        $this->Text = TextFactory::getLanguageText();
    }
    
    public function getTemplateType()
    {
        return EnhanceOutputTemplateType::Cli;
    }    
    
    public function get($errors, $results, $text, $duration, $methodCalls)
    {
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

class EnhanceOutputTemplateFactory 
{
    public static function createOutputTemplate($type)
    {
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

class EnhanceOutputTemplateType
{
    const Xml = 0;
    const Html = 1;
    const Cli = 2;
}


?>
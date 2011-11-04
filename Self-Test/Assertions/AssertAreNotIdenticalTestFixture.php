<?php
class AssertAreNotIdenticalTestFixture extends \Enhance\TestFixture
 {
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp()
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertAreNotIdenticalWithDifferentIntegers()
    {
        $this->target->areNotIdentical(5, 4);
    }
    
    public function assertAreNotIdenticalWithIdenticalIntegers()
    {
        $verifyFailed = false;
        try {
            $this->target->areNotIdentical(5, 5);
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
    
    public function assertAreNotIdenticalWithDifferentStrings()
    {
        $this->target->areNotIdentical('Test', 'test');
    }
    
    public function assertAreNotIdenticalWithIdenticalStrings()
    {
        $verifyFailed = false;
        try {
            $this->target->areNotIdentical('Test', 'Test');
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
    
    public function assertAreNotIdenticalWithDifferentFloats()
    {
        $this->target->areNotIdentical(15.123346575, 15.123346574);
    }
    
    public function assertAreNotIdenticalWithIdenticalFloats()
    {
        $verifyFailed = false;
        try {
            $this->target->areNotIdentical(15.123346575, 15.123346575);
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}
?>
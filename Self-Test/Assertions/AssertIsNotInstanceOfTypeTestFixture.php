<?php
class SomeOtherType
{
    public $value;
}

class AssertIsNotInstanceOfTypeTestFixture extends \Enhance\TestFixture
{
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp()
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertIsNotInstanceOfTypeWithDifferentType()
    {
        $object = new SomeOtherType();
        $this->target->isNotInstanceOfType('SomeType', $object);
    }
    
    public function assertIsNotInstanceOfTypeWithIdenticalTypes()
    {
        $verifyFailed = false;
        $object = new SomeOtherType();
        try {
            $this->target->isNotInstanceOfType('SomeOtherType', $object);
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}

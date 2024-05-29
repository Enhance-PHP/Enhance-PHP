<?php
class SomeType
{
    public $value;
}

class AssertIsInstanceOfTypeTestFixture extends \Enhance\TestFixture
{
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp()
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertIsInstanceOfTypeWithIdenticalType()
    {
        $object = new SomeType();
        $this->target->isInstanceOfType('SomeType', $object);
    }
    
    public function assertIsInstanceOfTypeWithDifferentTypes()
    {
        $verifyFailed = false;
        $object = new SomeType();
        try {
            $this->target->isInstanceOfType('SomeOtherType', $object);
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}

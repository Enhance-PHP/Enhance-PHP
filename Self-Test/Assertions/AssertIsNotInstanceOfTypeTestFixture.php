<?php
class SomeOtherType
{
    public $value;
}

class AssertIsNotInstanceOfTypeTestFixture extends \Enhance\EnhanceTestFixture
{
    /** @var \Enhance\EnhanceAssertions $target */
    private $target;
    
    public function setUp()
    {
        $this->target = \Enhance\Enhance::getCodeCoverageWrapper('\Enhance\EnhanceAssertions', array(\Enhance\EnhanceLanguage::English));
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
?>
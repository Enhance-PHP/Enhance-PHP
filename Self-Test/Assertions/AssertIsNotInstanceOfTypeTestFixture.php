<?php
class SomeOtherType
{
    public $value;
}

class AssertIsNotInstanceOfTypeTestFixture extends EnhanceTestFixture
{
    /** @var EnhanceAssertions $target */
    private $target;
    
    public function setUp()
    {
        $this->target = Enhance::getCodeCoverageWrapper('EnhanceAssertions', array(EnhanceLanguage::English));
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
        Assert::isTrue($verifyFailed);
    }
}
?>
<?php
class SomeType
{
    public $value;
}

class AssertIsInstanceOfTypeTestFixture extends EnhanceTestFixture
{
    private $target;
    
    public function setUp()
    {
        $this->target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
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
        Assert::isTrue($verifyFailed);
    }
}
?>
<?php
class SomeType
{
    public $value;
}

class AssertIsInstanceOfTypeTestFixture
{
    private $target;
    
    public function setUp()
    {
        $this->target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
    }

    public function assertIsInstanceOfTypeWithIdenticalTypeTest()
    {
        $object = new SomeType();
        $this->target->isInstanceOfType('SomeType', $object);
    }
    
    public function assertIsInstanceOfTypeWithDifferentTypesTest()
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
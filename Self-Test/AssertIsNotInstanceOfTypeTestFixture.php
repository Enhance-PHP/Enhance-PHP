<?php
class SomeOtherType
{
    public $value;
}

class AssertIsNotInstanceOfTypeTestFixture
{
    private $target;
    
    public function setUp()
    {
        $this->target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
    }

    public function assertIsNotInstanceOfTypeWithDifferentTypeTest()
    {
        $object = new SomeOtherType();
        $this->target->isNotInstanceOfType('SomeType', $object);
    }
    
    public function assertIsNotInstanceOfTypeWithIdenticalTypesTest()
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
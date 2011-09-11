<?php
class SomeType {
    public $Value;
}

class AssertIsInstanceOfTypeTestFixture {
    private $Target;
    
    public function SetUp() {
        $this->Target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
    }

    public function AssertIsInstanceOfTypeWithIdenticalTypeTest() {
        $object = new SomeType();
        $this->Target->isInstanceOfType('SomeType', $object);
    }
    
    public function AssertIsInstanceOfTypeWithDifferentTypesTest() {
        $VerifyFailed = false;
        $object = new SomeType();
        try {
            $this->Target->isInstanceOfType('SomeOtherType', $object);
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        Assert::isTrue($VerifyFailed);
    }
}
?>
<?php
class SomeOtherType {
    public $Value;
}

class AssertIsNotInstanceOfTypeTestFixture {
    private $Target;
    
    public function SetUp() {
        $this->Target = Enhance::getCodeCoverageWrapper('EnhanceAssertions');
    }

    public function AssertIsNotInstanceOfTypeWithDifferentTypeTest() {
        $object = new SomeOtherType();
        $this->Target->isNotInstanceOfType('SomeType', $object);
    }
    
    public function AssertIsNotInstanceOfTypeWithIdenticalTypesTest() {
        $VerifyFailed = false;
        $object = new SomeOtherType();
        try {
            $this->Target->isNotInstanceOfType('SomeOtherType', $object);
        } catch (Exception $e) {
            $VerifyFailed = true;
        }
        Assert::isTrue($VerifyFailed);
    }
}
?>
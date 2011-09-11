<?php
class ExampleAnotherTestFixture {

    private $Assert;

    public function SetUp() {
    }
    
    public function TearDown() {
    
    }

    public function GetJoinedStringWithTwoStringsExpectJoinedResultTest() {
        $target = Enhance::getCodeCoverageWrapper('ExampleAnotherClass', array('xx', 'yy'));

        $result = $target->GetJoinedString('A', 'B');

        Assert::areIdentical('ABxx', $result);
    }
}
?>
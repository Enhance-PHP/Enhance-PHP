<?php
class ExampleAnotherTestFixture 
{
    public function getJoinedStringWithTwoStringsExpectJoinedResultTest()
    {
        $target = Enhance::getCodeCoverageWrapper('ExampleAnotherClass', array('xx', 'yy'));

        $result = $target->getJoinedString('A', 'B');

        Assert::areIdentical('ABxx', $result);
    }
}
?>
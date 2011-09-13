<?php
class ExampleAnotherClassTests extends EnhanceTestFixture
{
    public function getJoinedStringWithTwoStringsExpectJoinedResult()
    {
        $target = Enhance::getCodeCoverageWrapper('ExampleAnotherClass', array('xx', 'yy'));

        $result = $target->getJoinedString('A', 'B');

        Assert::areIdentical('ABxx', $result);
    }
}
?>
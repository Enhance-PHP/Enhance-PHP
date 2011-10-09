<?php
class ExampleAnotherClassTests extends EnhanceTestFixture
{
    public function getJoinedStringWithTwoStringsExpectJoinedResult()
    {
        /** @var ExampleAnotherClass $target */
        $target = Enhance::getCodeCoverageWrapper('ExampleAnotherClass', array('xx', 'yy'));

        $result = $target->getJoinedString('A', 'B');

        Assert::areIdentical('ABxx', $result);
    }
}
?>
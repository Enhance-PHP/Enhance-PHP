<?php
class ExampleAnotherClassTests extends \Enhance\TestFixture
{
    public function getJoinedStringWithTwoStringsExpectJoinedResult()
    {
        /** @var ExampleAnotherClass $target */
        $target = \Enhance\Enhance::getCodeCoverageWrapper('ExampleAnotherClass', array('xx', 'yy'));

        $result = $target->getJoinedString('A', 'B');

        \Enhance\Assert::areIdentical('ABxx', $result);
    }
}
?>
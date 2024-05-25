<?php
namespace FirstTest;

class ExampleAnotherClassTests extends \Enhance\TestFixture
{
    public function getJoinedStringWithTwoStringsExpectJoinedResult()
    {
        /** @var ExampleAnotherClass $target */
        $target = \Enhance\Core::getCodeCoverageWrapper('\FirstTest\ExampleAnotherClass', array('xx', 'yy'));

        $result = $target->getJoinedString('A', 'B');

        \Enhance\Assert::areIdentical('ABxx', $result);
    }
}

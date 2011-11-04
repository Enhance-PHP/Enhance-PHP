<?php
namespace Kata;

class StringCalculatorTests extends \Enhance\TestFixture
{
        private $target;

        public function setUp()
        {
                $this->target = \Enhance\Core::getCodeCoverageWrapper('\Kata\StringCalculator');
        }

        public function startWritingTests()
        {

        }
}
?>
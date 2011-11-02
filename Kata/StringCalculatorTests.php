<?php
namespace Kata;

class StringCalculatorTests extends \Enhance\TestFixture
{
        private $target;

        public function setUp()
        {
                $this->target = \Enhance\Enhance::getCodeCoverageWrapper('\Kata\StringCalculator');
        }

        public function startWritingTests()
        {

        }
}
?>
<?php
namespace Kata;

class StringCalculatorTests extends \Enhance\EnhanceTestFixture
{
        private $target;

        public function setUp()
        {
                $this->target = \Enhance\Enhance::getCodeCoverageWrapper('StringCalculator');
        }

        public function startWritingTests()
        {

        }
}
?>
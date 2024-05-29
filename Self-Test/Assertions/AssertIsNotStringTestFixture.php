<?php
class AssertIsNotStringTestFixture extends \Enhance\TestFixture
{
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp() 
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertIsNotStringWithInteger()
    {
        $this->target->isNotString(1);
    }

    public function assertIsNotStringWithString()
    {
        $verifyFailed = false;
        try {
            $this->target->isNotString('string');
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }

}

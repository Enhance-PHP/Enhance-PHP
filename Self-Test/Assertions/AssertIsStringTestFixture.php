<?php
class AssertIsStringTestFixture extends \Enhance\TestFixture
{
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp() 
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertIsStringWithString()
    {
        $this->target->isString('string');
    }

    public function assertIsStringWithInteger()
    {
        $verifyFailed = false;
        try {
            $this->target->isString(1);
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }

}

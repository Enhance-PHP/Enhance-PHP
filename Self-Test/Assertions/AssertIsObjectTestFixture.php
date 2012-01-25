<?php
class AssertIsObjectTestFixture extends \Enhance\TestFixture
{
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp() 
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertIsObjectWithObject()
    {
        $object = new \Enhance\TextFactory();
        $this->target->isObject($object);
    }

    public function assertIsObjectWithString()
    {
        $verifyFailed = false;
        try {
            $this->target->isObject('some string');
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}
?>
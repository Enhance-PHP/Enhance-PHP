<?php
class AssertIsNotObjectTestFixture extends \Enhance\TestFixture
{
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp() 
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertIsNotObjectWithString()
    {
        $this->target->isNotObject('some string');
    }

    public function assertIsNotObjectWithObject()
    {
        $verifyFailed = false;
        try {
            $object = new \Enhance\TextFactory();
            $this->target->isNotObject($object);
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}
?>
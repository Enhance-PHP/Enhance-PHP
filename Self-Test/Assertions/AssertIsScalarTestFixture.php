<?php
class AssertIsScalarTestFixture extends \Enhance\TestFixture
{
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp() 
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertIsScalarWithInteger()
    {
        $this->target->isScalar(1);
    }

    public function assertIsScalarWithFloat()
    {
        $this->target->isScalar(1.1);
    }

    public function assertIsScalarWithString()
    {
        $this->target->isScalar('xyz');
    }

    public function assertIsScalarWithBool()
    {
        $this->target->isScalar(true);
    }

    public function assertIsScalarWithArray()
    {
        $verifyFailed = false;
        try {
            $array = array();
            $this->target->isScalar($array);
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }

    public function assertIsScalarWithObject()
    {
        $verifyFailed = false;
        try {
            $object = new \Enhance\TextFactory();
            $this->target->isScalar($object);
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}
?>
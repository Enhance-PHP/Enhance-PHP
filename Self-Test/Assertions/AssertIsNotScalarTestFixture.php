<?php
class AssertIsNotScalarTestFixture extends \Enhance\TestFixture
{
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp() 
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertIsNotScalarWithArray()
    {
        $array = array();
        $this->target->isNotScalar($array);
    }

    public function assertIsNotScalarWithObject()
    {
        $object = new \Enhance\TextFactory();
        $this->target->isNotScalar($object);
    }

    public function assertIsNotScalarWithFloat()
    {
        $verifyFailed = false;
        try {
            $this->target->isNotScalar(1.1);
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }

    public function assertIsNotScalarWithString()
    {
        $verifyFailed = false;
        try {
            $this->target->isNotScalar('xyz');
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }

    public function assertIsNotScalarWithBool()
    {
        $verifyFailed = false;
        try {
            $this->target->isNotScalar(true);
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}
?>
<?php
class AssertIsArrayTestFixture extends \Enhance\TestFixture
{
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp() 
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertIsArrayWithEmptyArray()
    {
        $array = array();
        $this->target->isArray($array);
    }

    public function assertIsArrayWithArray()
    {
        $array = array('foo' => 'bar', 12 => true);
        $this->target->isArray($array);
    }
    
    public function assertIsArrayWithString()
    {
        $verifyFailed = false;
        try {
            $this->target->isArray('array');
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }

    public function assertIsArrayWithNumber()
    {
        $verifyFailed = false;
        try {
            $this->target->isArray(500);
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}

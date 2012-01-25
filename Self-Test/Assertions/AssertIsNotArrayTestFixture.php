<?php
class AssertIsNotArrayTestFixture extends \Enhance\TestFixture
{
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp() 
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertIsNotArrayWithString()
    {
        $this->target->isNotArray('array');
    }

    public function assertIsNotArrayWithNumber()
    {
        $array = 500;
        $this->target->isNotArray($array);
    }
    
    public function assertIsNotArrayWithEmptyArray()
    {
        $verifyFailed = false;
        try {
            $array = array();
            $this->target->isNotArray($array);
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }

    public function assertIsNotArrayWithArray()
    {
        $verifyFailed = false;
        try {
            $array = array('foo' => 'bar', 12 => true);
            $this->target->isNotArray($array);
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}
?>
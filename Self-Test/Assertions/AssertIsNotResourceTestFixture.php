<?php
class AssertIsNotResourceTestFixture extends \Enhance\TestFixture
{
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp() 
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertIsNotResourceWithString()
    {
        $this->target->isNotResource('some string');
    }

    public function assertIsNotResourceWithResource()
    {
        $verifyFailed = false;
        try {
            $resource = fopen('php://temp', 'r');
            $this->target->isNotResource($resource);
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}

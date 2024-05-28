<?php
class AssertIsResourceTestFixture extends \Enhance\TestFixture
{
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp() 
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertIsResourceWithResource()
    {
        $resource = fopen('php://temp', 'r');
        $this->target->isResource($resource);
    }

    public function assertIsResourceWithString()
    {
        $verifyFailed = false;
        try {
            $this->target->isResource('some string');
        } catch (\Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}

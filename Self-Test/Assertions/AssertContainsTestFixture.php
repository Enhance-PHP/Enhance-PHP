<?php
class AssertContainsTestFixture extends \Enhance\TestFixture
{
    /** @var \Enhance\Assertions $target */
    private $target;
    
    public function setUp()
    {
        $this->target = \Enhance\Core::getCodeCoverageWrapper('\Enhance\Assertions', array(\Enhance\Language::English));
    }

    public function assertContainsWithStringThatContains()
    {
        $this->target->contains('Test', 'Some Test String');
    }
    
    public function assertContainsWithStringThatEndsWith() 
    {
        $this->target->contains('Test', 'Some Test');
    }
    
    public function assertContainsWithStringThatStartsWith()
    {
        $this->target->contains('Test', 'Test Some String');
    }
    
    public function assertContainsWithStringThatDoesNotContain()
    {
        $verifyFailed = false;
        try {
            $this->target->contains('Test', 'Some Other String');
        } catch (Exception $e) {
            $verifyFailed = true;
        }
        \Enhance\Assert::isTrue($verifyFailed);
    }
}

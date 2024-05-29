<?php
class ExampleDependencyClassTests extends \Enhance\TestFixture
{
        public function verifyWithAMock() 
        {
                $mock = \Enhance\MockFactory::createMock('ExampleDependencyClass');
                $mock->addExpectation(
                    \Enhance\Expect::method('getSomething')
                        ->with(1, 'Arg2')
                        ->returns('Something')
                        ->times(1)
                );
                $target = new ExampleClass($mock);
                $result = $target->doSomething();
                $mock->verifyExpectations();
        }
}

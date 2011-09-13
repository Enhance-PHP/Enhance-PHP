<?php
class ExampleDependencyClassTests extends EnhanceTestFixture
{
        public function verifyWithAMockTest() 
        {
                $mock = MockFactory::createMock('ExampleDependencyClass');
                $mock->addExpectation(
                    Expect::method('getSomething')
                        ->with(1, 'Arg2')
                        ->returns('Something')
                        ->times(1)
                );
                $target = new ExampleClass($mock);
                $result = $target->doSomething();
                $mock->verifyExpectations();
        }
}
?>
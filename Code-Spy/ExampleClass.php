<?php
namespace CodespyTest;

class ExampleClass
{
    public function addTwoNumbers($a, $b)
    {
		if($a == 0) return $b;
		elseif($b==0)  return $a;
        return $a + $b;
    }
}

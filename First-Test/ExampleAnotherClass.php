<?php
namespace FirstTest;

class ExampleAnotherClass
{
    private $X;
    private $Y;

    public function ExampleAnotherClass($x, $y)
    {
        $this->X = $x;
        $this->Y = $y;
    }

    public function getJoinedString($a, $b)
    {
        return $a . $b . $this->X;
    }
    
    public function thisMethodIsNotCovered($x) 
    {
        return $x;
    }
}
?>
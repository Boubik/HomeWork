<?php

class Position
{
    public $x;
    public $y;

    function __construct($x, $y)
    {
        self::setPosition($x, $y);
    }

    function setX($x)
    {
        $this->x = $x;
    }

    function setY($y)
    {
        $this->y = $y;
    }

    function getX()
    {
        return $this->x;
    }

    function getY()
    {
        return $this->y;
    }

    function setPosition($x, $y)
    {
        self::setX($x);
        self::setY($y);
    }
}

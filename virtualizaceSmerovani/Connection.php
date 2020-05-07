<?php

class Connection
{
    public Node $nodeA;
    public Node $nodeB;
    public int $distance;

    function __construct(Node $nodeA, Node $nodeB, int $distance)
    {
        $this->setA($nodeA);
        $this->setB($nodeB);
        $this->setDistance($distance);
    }

    function setDistance(int $distance)
    {
        $this->distance = $distance;
    }

    function setA(Node $nodeA)
    {
        $this->nodeA = $nodeA;
    }

    function setB(Node $nodeB)
    {
        $this->nodeB = $nodeB;
    }

    function getDistance()
    {
        return $this->distance;
    }

    function getA()
    {
        return $this->nodeA;
    }

    function getB()
    {
        return $this->nodeB;
    }
}

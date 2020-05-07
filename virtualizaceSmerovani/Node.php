<?php
require_once "Position.php";
require_once "Connection.php";

class Node
{
    static public $nodes = array();
    public Position $position;
    public String $name;
    public $paths = array();

    function __construct($x, $y, String $name)
    {
        $this->position = new Position($x, $y);
        $this->name = $name;
    }

    function addPath(Connection $path)
    {
        $this->paths[] = $path;
    }

    static function addNode(Node $node)
    {
        self::$nodes[] = $node;
    }

    static function getNodes()
    {
        return self::$nodes;
    }

    function getPaths()
    {
        return $this->paths;
    }

    function getX()
    {
        return $this->position->getX();
    }

    function getPosition()
    {
        return $this->position;
    }

    function getY()
    {
        return $this->position->getY();
    }

    function getName()
    {
        return $this->name;
    }

    static function setFromCsv(string $file)
    {
        require_once "functions.php";
        $text = load_file($file);
        $lines = explode("\n", $text);
        foreach ($lines as $key => $values) {
            $lines[$key] = explode(";", $values);
            foreach ($lines[$key] as $key2 => $values2) {
                $lines[$key][$key2] = explode(",", $values2);
            }
        }

        //add nodes
        foreach ($lines as $node_paths) {
            $node = new Node($node_paths[0][0], $node_paths[0][1], $node_paths[0][2]);
            Node::addNode($node);
        }

        //add paths to nodes
        foreach ($lines as $node) {
            foreach ($node as $key => $values) {
                if ($key == 0) {
                    $nodeFrom = self::getPositionFromName($values[2]);
                } else {
                    $nodeTo = self::getPositionFromName($values[0]);
                    $nodeFrom->addPath(new Connection($nodeTo, $nodeFrom, $values[1]));
                }
            }
        }
    }

    private static function getPositionFromName(String $name)
    {
        foreach (Node::getNodes() as $node) {
            if ($node->getName() == $name) {
                return $node;
            }
        }
    }

    static function getOfsets()
    {
        $xmin = self::$nodes[0]->getX();
        $ymin = self::$nodes[0]->getX();
        $xmax = self::$nodes[0]->getX();
        $ymax = self::$nodes[0]->getX();

        foreach (self::$nodes as $node) {
            if ($node->getX() > $xmax) {
                $xmax = $node->getX();
            }
            if ($node->getX() < $xmin) {
                $xmin = $node->getX();
            }
            if ($node->getY() > $ymax) {
                $ymax = $node->getY();
            }
            if ($node->getY() < $ymin) {
                $ymin = $node->getY();
            }
        }
        return array("x" => $xmax + $xmin, "y" => $ymax + $ymin);
    }

    static function getNodeByName($name)
    {
        $name = strtoupper($name);
        foreach (self::$nodes as $node) {
            if (strtoupper($node->getName()) == $name) {
                return $node;
            }
        }
        echo "routr " . $name . " nebyl nalezen";
        exit();
    }

    static function getDistanceByNode($table, $node)
    {
        foreach ($table as $values) {
            if ($node == $values["node"]) {
                return $values["distance"];
            }
        }
    }
}

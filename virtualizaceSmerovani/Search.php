<?php
require_once "Node.php";
require_once "Connection.php";
class Search
{
    static public Node $start;
    static public Node $end;

    static function run(Node $start, Node $end)
    {
        $unvisited = Node::getNodes();
        $table = array();
        foreach ($unvisited as $node) {
            if ($node->getPosition() == $start->getPosition()) {
            } else {
            }
            if ($node->getPosition() == $start->getPosition()) {
                $table[] = array("node" => $node, "distance" => 0, "previus" => null);
            } else {
                $table[] = array("node" => $node, "distance" => 99999999, "previus" => null);
            }
        }
        unset($node);
        $paths = null;
        while (count($unvisited) != 0) {
            $curentNode = self::findLowesDistance($table, $unvisited, $start);
            $paths = $curentNode["node"]->getPaths();
            if (($key = array_search($curentNode["node"], $unvisited)) !== false) {
                unset($unvisited[$key]);
            }
            foreach ($curentNode["node"]->getPaths() as $key => $paths) {
                $otherNodeKey = self::findNodeRowKey($table, $paths->getA());
                $otherNode = $table[$otherNodeKey];
                if ($otherNode["distance"] === null or $curentNode["distance"] + $paths->getDistance() < $otherNode["distance"]) {
                    $table[$otherNodeKey]["distance"] = $curentNode["distance"] + $paths->getDistance();
                    $table[$otherNodeKey]["previus"] = $curentNode["node"];
                }
            }
            /*
            echo "Unvisited: ";
            foreach ($unvisited as $value) {
                echo " " . $value->getName();
            }
            echo "<br>";
            echo "Loking at: " . $curentNode["node"]->getName();
            echo "<br>";
            self::echoTable($table);
            echo "<br><br><br><br>";
            */
        }

        return $table;
    }

    static function findLowesDistance($table, $unvisited, $start)
    {
        $idk = array();
        if (in_array($start, $unvisited)) {
            foreach ($table as $key => $distance) {
                if ($distance["node"] == $start) {
                    return $table[$key];
                }
            }
            echo "<br> špatný start";
            exit();
        } else {
            foreach ($table as $key => $distance) {
                if (in_array($distance["node"], $unvisited)) {
                    $idk[$key] = $distance["distance"];
                }
            }
            $key = array_search(min($idk), $idk);

            return $table[$key];
        }
    }

    static function echoTable(array $table)
    {
        foreach ($table as $row) {
            if ($row["node"] === null) {
                echo "null";
            } else {
                echo $row["node"]->getName();
            }
            echo " ";
            if ($row["distance"] === null) {
                echo "null";
            } else {
                echo $row["distance"];
            }
            echo " ";
            if ($row["previus"] === null) {
                echo "null";
            } else {
                echo $row["previus"]->getName();
            }
            echo "<br>";
        }
    }

    static function findNodeRow($table, Node $node)
    {
        foreach ($table as $value) {
            if ($value["node"] == $node) {
                return $value;
            }
        }
    }

    static function findNodeRowKey($table, Node $node)
    {
        foreach ($table as $key => $value) {
            if ($value["node"] == $node) {
                return $key;
            }
        }
    }

    static function removeNode(Node $node, array $array)
    {
        foreach ($array as $key => $value) {
            if ($node == $value) {
                unset($array[$key]);
                return $array;
            }
        }
    }

    static function isNodeInArray(Node $node, array $array)
    {
        foreach ($array as $values) {
            if ($node == $values) {
                return true;
            }
        }
        return false;
    }
}

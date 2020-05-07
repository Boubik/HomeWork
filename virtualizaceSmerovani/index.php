<!DOCTYPE html>
<html lang="cz">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        <?php
        require_once "functions.php";
        require_once "Node.php";
        require_once "Search.php";

        Node::setFromCsv("grafs/network.csv");
        $ofsets = Node::getOfsets();
        echo "body {\n
            display: grid;\n}";
        ?>
    </style>
</head>

<body>
    <?php
    if (isset($_POST["start"])) {
        $start = Node::getNodeByName($_POST["start"]);
        $startName = $start->getName();
    } else {
        $start = "";
        $startName = "";
    }
    if (isset($_POST["end"])) {
        $end = Node::getNodeByName($_POST["end"]);
        $endName = $end->getName();
    } else {
        $end = "";
        $endName = "";
    }
    if ($start != "" and $end != "") {
        echo "<div style=\"grid-column: " .  1 . "/" . $ofsets["x"] . "; grid-row: " . 2 . "; justify-self: center;\">";
        $table = Search::run($start, $end);
        $distance = Node::getDistanceByNode($table, $end);
        echo "Cesta o délce " . $distance . ": ";
        $cesta = Search::getPathByTable($table, $end);
        foreach ($cesta as $key => $value) {
            if (count($cesta) - 1 != $key) {
                echo $value->getName() . "-->";
            } else {
                echo $value->getName();
            }
        };
        //Search::echoTable($table);
        echo "</div>";
    }
    echo "<div style=\"grid-column: " .  1 . "/" . $ofsets["x"] . "; grid-row: " . 1 . "; justify-self: center;\">";
    echo '<form method="POST" action="">';
    echo 'Start: <input type="text" name="start" placeholder="Jméno vysílajícího routru" value="' . $startName . '"><br>';
    echo 'Konec: <input type="text" name="end" placeholder="Jméno koncového routru" value="' . $endName . '"><br>';
    echo '<input type="submit" name="submit1"  value="najít cestu">';
    echo '</form>' . "\n";
    echo "</div>";
    echo "<div style=\"grid-column: " . $ofsets["x"] . "; grid-row: " . ($ofsets["y"] + 2) . ";\"></div>";
    foreach (Node::getNodes() as $key => $node) {
        echo "<div style=\"grid-column: " . $node->getX() . "; grid-row: " . ($node->getY() + 2) . ";\">" . $node->getName() . "</div>";
    }
    ?>
</body>

</html>
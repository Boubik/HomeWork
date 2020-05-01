<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        <?php
        require "functions.php";

        $text = load_file("grafs/network.csv");
        $lines = explode("\n", $text);
        foreach ($lines as $key => $values) {
            $lines[$key] = explode(";", $values);
            foreach ($lines[$key] as $key2 => $values2) {
                $lines[$key][$key2] = explode(",", $values2);
            }
        }
        $xmin = $lines[0][0][0];
        $x_max = $lines[0][0][0];
        $ymin = $lines[0][0][1];
        $y_max = $lines[0][0][1];
        foreach ($lines as $key => $values) {
            if ($values[0][0] < $xmin) {
                $xmin = $values[0][1];
            }
            if ($values[0][1] < $ymin) {
                $ymin = $values[0][1];
            }
            if ($values[0][0] > $x_max) {
                $x_max = $values[0][0];
            }
            if ($values[0][1] > $y_max) {
                $y_max = $values[0][1];
            }
        }

        $x_ofset = $x_max + $xmin;
        $y_ofset = $y_max + $ymin;
        echo "body {\n
            display: grid;\n}";
        ?>
    </style>
</head>

<body>
    <?php

    echo "<div style=\"grid-column: " . $x_ofset . "; grid-row: " . $y_ofset . ";\"></div>";
    foreach ($lines as $values) {
        foreach ($values as $key => $node_paths) {
            if ($key == 0) {
                echo "<div style=\"grid-column: " . $node_paths[0] . "; grid-row: " . $node_paths[1] . ";\">" . $node_paths[2] . "</div>";
            } else {
            }
        }
    }
    ?>
</body>

</html>
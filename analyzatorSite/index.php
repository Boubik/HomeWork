<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .none {
            display: none;
        }
    </style>
</head>

<body>
    <?php
    include "functions.php";
    ini_set('max_execution_time', 0);

    $networks = array();

    if (isset($_POST["network"])) {
        $network = $_POST["network"];
        $mask = $_POST["mask"];
        $subnet = $_POST["subnet"];
    } else {
        $network = "192.168.1.0";
        $mask = 24;
        $subnet = 4;
    }

    echo "<form method=\"post\">ip:&nbsp;&nbsp;&nbsp;";
    echo "<input name=\"network\" type=\"text\" value=\"" . $network . "\" required>/";
    echo "<input name=\"mask\" type=\"number\" min=\"0\" max=\"32\" value=\"" . $mask . "\" required>";
    echo "<br>";
    echo "sítí: <input name=\"subnet\" type=\"number\" min=\"1\" value=\"" . $subnet . "\" required>";
    echo "<br>";
    echo "<input name=\"submit\" type=\"submit\">";
    echo "</form>";

    echo "<br><br>";
    if ($subnet > 0) {
        if ($subnet == 1) {
            table(get_table($network, $mask));
        } else {
            $i = 1;
            while ((2 ** $i) < $subnet) {
                $i++;
            }
            $alt_mask = $mask + $i;
            $pc = 2 ** (32 - $alt_mask) + 1;
            if ($i + $mask < 31 and $pc > 3) {
                $k = 0;
                while ($k != $subnet) {
                    $network = get_network($network, $alt_mask);
                    $network = ip_bin_to_dec($network);
                    table(get_table($network, $alt_mask));
                    $network = ip_to_array($network);
                    $network[3] += $pc;
                    $network = ip_to_string($network);
                    echo "<br><br>";
                    $k++;
                }
            } else {
                echo "tato sít nejde";
            }
        }
    } else {
        echo "minimálně jedna sít";
    }

    ?>

</body>

</html>
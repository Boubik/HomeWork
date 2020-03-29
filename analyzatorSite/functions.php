<?php

function table($networks)
{
    echo "<table border=\"1|0\">\n";

    foreach ($networks as $values) {
        echo "<tr>\n";

        echo "<th>\n";
        echo "</th>\n";

        echo "<th>\n";
        echo "ip dec";
        echo "</th>\n";

        echo "<th>\n";
        echo "ip bin";
        echo "</th>\n";

        echo "</tr>\n";


        echo "<tr>\n";

        echo "<th>\n";
        echo "Network";
        echo "</th>\n";

        echo "<th>\n";
        $values["N"] = explode(".", $values["N"]);
        foreach ($values["N"] as $key => $value) {
            if ($key != 0) {
                echo ".";
            }
            echo bindec($value);
        }
        echo "</th>\n";
        echo "<th>\n";
        foreach ($values["N"] as $key => $value) {
            if ($key != 0) {
                echo ".";
            }
            echo $value;
        }
        echo "</th>\n";

        echo "</tr>\n";

        echo "<tr>\n";

        echo "<tr>\n";

        echo "<th>\n";
        echo "Mask";
        echo "</th>\n";

        echo "<th>\n";
        echo $values["M"];
        echo "</th>\n";
        echo "<th>\n";
        $values["M"] = explode(".", $values["M"]);
        foreach ($values["M"] as $key => $value) {
            if ($key != 0) {
                echo ".";
            }
            echo str_pad(decbin($value), 8, 0, STR_PAD_LEFT);
        }
        echo "</th>\n";

        echo "</tr>\n";

        echo "<th>\n";
        echo "First";
        echo "</th>\n";

        echo "<th>\n";
        $values["F"] = explode(".", $values["F"]);
        foreach ($values["F"] as $key => $value) {
            if ($key != 0) {
                echo ".";
            }
            echo bindec($value);
        }
        echo "</th>\n";
        echo "<th>\n";
        foreach ($values["F"] as $key => $value) {
            if ($key != 0) {
                echo ".";
            }
            echo $value;
        }
        echo "</th>\n";

        echo "</tr>\n";

        echo "<tr>\n";

        echo "<th>\n";
        echo "Last";
        echo "</th>\n";

        echo "<th>\n";
        $values["L"] = explode(".", $values["L"]);
        foreach ($values["L"] as $key => $value) {
            if ($key != 0) {
                echo ".";
            }
            echo bindec($value);
        }
        echo "</th>\n";
        echo "<th>\n";
        foreach ($values["L"] as $key => $value) {
            if ($key != 0) {
                echo ".";
            }
            echo $value;
        }
        echo "</th>\n";

        echo "</tr>\n";

        echo "<tr>\n";

        echo "<th>\n";
        echo "Broadcast";
        echo "</th>\n";

        echo "<th>\n";
        $values["B"] = explode(".", $values["B"]);
        foreach ($values["B"] as $key => $value) {
            if ($key != 0) {
                echo ".";
            }
            echo bindec($value);
        }
        echo "</th>\n";
        echo "<th>\n";
        foreach ($values["B"] as $key => $value) {
            if ($key != 0) {
                echo ".";
            }
            echo $value;
        }
        echo "</th>\n";

        echo "</tr>\n";

        echo "<tr>\n";

        echo "<th>\n";
        echo "Computers";
        echo "</th>\n";

        echo "<th>\n";
        echo $values["PC"];
        echo "</th>\n";
        echo "<th>\n";
        echo str_pad(decbin($values["PC"]), 8, 0, STR_PAD_LEFT);
        echo "</th>\n";

        echo "</tr>\n";
    }

    echo "</table>\n";
}


function get_table($network, $mask)
{
    //mask calculator
    $mask2 = $mask;
    $decmask = "";
    $i = 0;
    while ($mask2 / 8 > 1. or $mask2 / 8 == 1) {
        $mask2 -= 8;
        if ($i != 0) {
            $decmask .= ".";
        }
        $decmask .= "255";
        $i++;
    }
    if ($mask2 == 0) {
        while ($i != 4) {
            if ($i != 0) {
                $decmask .= ".";
            }
            $decmask .= "0";
            $i++;
        }
    } else {
        $k = 0;
        $imask = "";
        while ($mask2 != 0) {
            $imask .= "1";
            $mask2--;
        }
        while (strlen($imask) != 8) {
            $imask .= "0";
        }
        if ($i != 0) {
            $decmask .= ".";
        }
        $decmask .= bindec($imask);
        $i++;
        while ($i != 4) {
            if ($i != 0) {
                $decmask .= ".";
            }
            $decmask .= "0";
            $i++;
        }
    }

    //network
    $ip_no_dots = "";
    $network = explode(".", $network);
    foreach ($network as $value) {
        $ip_no_dots .= str_pad(decbin($value), 8, 0, STR_PAD_LEFT);
    }

    //network
    $i = 0;
    $network = "";
    while ($i != 32) {
        if ($i != 0 and $i % 8 == 0) {
            $network .= ".";
        }
        if ($i >= $mask) {
            $network .= "0";
        } else {
            $network .= $ip_no_dots[$i];
        }
        $i++;
    }

    //broadcast
    $broadcast = "";
    $i = 0;
    while ($i != 32) {
        if ($i != 0 and $i % 8 == 0) {
            $broadcast .= ".";
        }
        if ($i >= $mask) {
            $broadcast .= "1";
        } else {
            $broadcast .= $ip_no_dots[$i];
        }
        $i++;
    }

    //first
    $e_broadcast = explode(".", $broadcast);
    $e_network = explode(".", $network);
    $first = $e_network;
    $first[3] = str_pad($first[3] + decbin(1), 8, 0, STR_PAD_LEFT);
    $f = "";
    foreach ($first as $key => $value) {
        if ($key != 0) {
            $f .= ".";
        }
        $f .= $value;
    }
    $first = $f;


    //last
    $e_broadcast = explode(".", $broadcast);
    $last = $e_broadcast;
    $last[3] = str_pad($last[3] - decbin(1), 8, 0, STR_PAD_LEFT);
    $l = "";
    foreach ($last as $key => $value) {
        if ($key != 0) {
            $l .= ".";
        }
        $l .= $value;
    }
    $last = $l;

    $networks[] = array(
        "N" => $network,
        "F" => $first,
        "L" => $last,
        "B" => $broadcast,
        "M" => $decmask,
        "PC" => (2 ** (32 - $mask)) - 2
    );

    return $networks;
}

function get_network($ip, $mask)
{
    $ip_no_dots = "";
    $ip = explode(".", $ip);
    foreach ($ip as $value) {
        $ip_no_dots .= str_pad(decbin($value), 8, 0, STR_PAD_LEFT);
    }

    //network
    $i = 0;
    $network = "";
    while ($i != 32) {
        if ($i != 0 and $i % 8 == 0) {
            $network .= ".";
        }
        if ($i >= $mask) {
            $network .= "0";
        } else {
            $network .= $ip_no_dots[$i];
        }
        $i++;
    }
    return $network;
}

function ip_bin_to_dec($ip)
{
    $dec_ip = "";
    $ip = explode(".", $ip);
    foreach ($ip as $key => $value) {
        if ($key != 0) {
            $dec_ip .= ".";
        }
        $dec_ip .= bindec($value);
    }
    return $dec_ip;
}

function ip_to_array($ip)
{
    $ip = explode(".", $ip);
    return $ip;
}

function ip_to_string($ip)
{
    $string_ip = "";
    foreach ($ip as $key => $value) {
        if ($key != 0) {
            $string_ip .= ".";
        }
        $string_ip .= $value;
    }
    return $string_ip;
}

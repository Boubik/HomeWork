<?php
require "Template.php";

$data = array("title" => "States", "h1" => "<a href=\"index.php\">States</a>", "List" => "");
$xml = new SimpleXMLElement(load_file("staty.xml"));
foreach ($xml->state as  $value) {
    $data["List"] .= "<a href=\"index.php?q=" . $value->name->__toString() . "\">" . $value->name->__toString() . "</a><br>";
    if (isset($_GET["q"]) and $_GET["q"] == $value->name->__toString()) {
        $data["State"] = $value->name->__toString();
        $data["Population"] = $value->population->__toString();
        $data["Capital"] = $value->capital->__toString();
    }
}
if (!isset($data["State"])) {
    $data["State"] = $xml->state[0]->name->__toString();
    $data["Population"] = $xml->state[0]->population->__toString();
    $data["Capital"] = $xml->state[0]->capital->__toString();
}


$test = new Template();
$test->setData($data);
$test->setFileName("page.html");
$test->render();

/**
 * will load file in root folder of program
 * @param   String  $filename   filen name with end (.txt, etc)
 * @param   String  $mode       mode (w, a, etc)
 * @return  String  text in file
 */
function load_file($filename, $mode = "r")
{

    $handle = fopen($filename, $mode);
    $text = "";
    while (($line = fgets($handle)) !== false) {
        $text = $text . $line;
    }
    return $text;
}

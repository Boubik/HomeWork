<?php
require "Template.php";

$data = array(
    "title" => "Document",
    "message" => "zpráva",
    "h1" => "nadpis"
);

$test = new Template();
$test->setData($data);
$test->setFileName("page.html");
$test->render();

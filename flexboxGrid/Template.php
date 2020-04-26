<?php

class Template
{
    private $fileName;
    private $data;
    private $fileText;

    /**
     * vygeneruje nové dítě
     */
    function __constract()
    {
        $filename = "";
        $data = array();
        $filetext = "";
    }

    /**
     * nastaví data
     * @param Array $data data
     */
    function setData($data)
    {
        $this->data = $data;
    }


    /**
     * nastaví jméno souboru
     * @param String $filename jméno souboru
     */
    function setFileName($filename)
    {
        $this->fileText = $this->load_file($filename);
    }

    /**
     * vykreslí html stránku
     */
    function render()
    {
        foreach ($this->data as $key => $values) {
            $this->fileText = str_replace("{" . $key . "}", $values, $this->fileText);
        }
        $this->fileText = preg_replace("/{.*}/", "", $this->fileText);
        echo $this->fileText;
    }

    /**
     * nastaví jméno souboru
     * @param String $filename jméno souboru
     * @param String $mode mód (čtní, zápis...)
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
}

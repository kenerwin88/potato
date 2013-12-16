<?php
class Task
{
    public $description;
    public $url;

    function __construct($dsecription, $url)
    {
        $this->description = (string)$description;
        $this->url = (string)$url;
    }
}

?>
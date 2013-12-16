<?php
class Step
{
    public $id;
    public $name;
    public $taskList = array();

    function __construct($id, $name, $taskList)
    {
        $this->id = (string)$id;
        $this->name = (string)$name;
        $this->taskList = (string)$taskList;
    }
}

?>
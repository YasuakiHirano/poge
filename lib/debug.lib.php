<?php
class Debug
{
    public function Dump($data)
    {
        echo "<pre>";
        var_dump($data); 
        echo "</pre>";
    }

    public function DumpExit($data)
    {
        echo "<pre>";
        var_dump($data); 
        echo "</pre>";
        die;
    }

}

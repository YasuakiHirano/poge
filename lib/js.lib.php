<?php
class JSLib{
    public function _showAlertMessage($str)
    {
        echo "<script>(function(){alert('".$str."');})();</script>";
    }
}

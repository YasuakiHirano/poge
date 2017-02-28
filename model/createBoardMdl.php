<?php
class createBoardMdl extends fireSignMdl
{
    function insertBoard($arr){
       $arr['create_time'] = date("Y-m-d H:i:s");
       $arr['update_time'] = date("Y-m-d H:i:s");
       $this->db->insertQuery("board", $arr);
    }
}

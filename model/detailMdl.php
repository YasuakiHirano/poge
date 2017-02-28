<?php
class detailMdl extends fireSignMdl
{
    function getBoard($id){
        $ret = $this->db->selectQuery("board",null ," id = '{$id}'");
        return $ret;
    }

    function getMessage($id){
        $ret = $this->db->selectQuery("message",null ," board_id = '{$id}' order by create_time desc");
        return $ret;
    }

    function insertMessage($arr){
       $arr['create_time'] = date("Y-m-d H:i:s");
       $arr['update_time'] = date("Y-m-d H:i:s");
       $this->db->insertQuery("message", $arr);
    }

    function passwordCheck($delId, $delPassword){
        $ret = $this->db->selectQuery("board", "id", " id = '{$delId}' and password = '{$delPassword}'");

        $checkResult = false;
        if(empty($ret[0]["id"])){
            $checkResult = false;
        } else {
            $checkResult = true;
        }
        return $checkResult;
    }

    function deleteBoard($delId){
        $this->db->deleteQuery("board", " id = '{$delId}'");
        $this->db->deleteQuery("message", " board_id = '{$delId}'");
    }
}

<?php
class topMdl extends fireSignMdl
{
    function getBoardTitles(){
       $ret = $this->db->selectQuery("board", "name", " order by create_time desc");
       foreach($ret as $arrName){
            $retArr[] .= $arrName['name'];
       }
       return $retArr;
    }

    function getBoardIds(){
       $ret = $this->db->selectQuery("board", "id", " order by create_time desc");
       foreach($ret as $arrName){
            $retArr[] .= $arrName['id'];
       }
       return $retArr;
    }

    function getBoard(){
       $ret = $this->db->selectQuery("board", null, "1 = 1 order by create_time desc");
       return $ret;
    }

}

<?php
namespace Back\Model;
use Think\Model;

class MemberModel extends Model
{
    public  function selectAll(){
        return $this->select();
    }



}
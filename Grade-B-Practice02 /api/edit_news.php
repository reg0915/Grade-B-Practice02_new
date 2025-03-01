<?php
include_once "db.php";

if(isset($_POST['id'])){
    foreach($_POST['id']as $idx => $id) {
        if(isset($_POST['del']) && in_array($id,$_POST['del'])){
        $News->del($id);
        }else{
            $row=$News->find($id);
            $row['news']=$_POST['news'][$idx];
            $row['sh']=(isset($_POST['sh']) && $_POST['sh']==$id)?1:0;
            $News->save($row);
       }
    }
}

to("../admin.php?do=news");
?>
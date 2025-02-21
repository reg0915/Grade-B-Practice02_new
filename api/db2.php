<?php

session_start();

class DB {
protected $dsn="mysql:host=localhost;charset=utf8;dbname=db22";
protected $pdo;
protected $table;    

// public static $type={


// }

function __construct($table){
    $this->table=$table;
    $this->pdo=new DB($this->dsn,'root','');
}




function all(...$arg){
    $sql="SELECT * FROM $this->table";
    if(!empty($arg[0])){
        if(in_array($arg[0])){
            $where=$this->a2s($arg[0]);
            $sql=$sql . " WHERE " .join(" && " ,$where );
        }else{
            $sql .=$arg[0];
        }
    }
    if(!empty($arg[1])){
        $sql=$sql . $arg[1];
    }
 return $this->fetchOne($sql);

}




function find($id){

    $sql="SELECT * FROM $this->table";
 
        if(in_array($id[0])){
            $where=$this->a2s($id[0]);
            $sql=$sql . " WHERE " .join(" && " ,$where );
        }else{
           $sql .=" WHERE `id`='$id' "; 
        }
 return $this->fetchOne($sql);
    
}







function save(){

}

function del(){

}


function a2s(){

}







protected function math(){

}

function max(){

}
function min(){

}

function sum(){

}

function avg(){

}

function count(){

}





function fetchOne(){

}
function fetchALL(){
    
}

function dd(){

}

function to(){

}
function q(){

}
























}
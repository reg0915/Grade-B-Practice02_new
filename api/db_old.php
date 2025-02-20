<?php
date_default_timezone_set('Asia/Taipei');
session_start();


class DB{
protected $dsn="mysql:host=localhost;charset=utf8;dbname=db22";
protected $pdo;
protected $table;

function __construct($table){
    $this->table=$table;
    $this->pdo=new PDO($this->dsn,'root','');
}





function all(...$arg){
    $sql="select * from $this->table";
    if(!empty($arg[0]) && in_array($arg[0])){
        $tmp=$this->arrayToSQL($arg[0]);
        $sql .=" where " .join(" && ",$tmp);
    }else if(is_string($arg[0])){
        $sql .=$arg[0];
    }

    if(!empty($arg[1])){
        $sql .= $arg[1];
    }
    return $this->fetch_all($sql);
}






function find($array){
    $sql="select * from $this->table ";
    if(is_array($array)){
$tmp=$this->arrayToSQL($array);
$sql .=" where ".join(" && ",$tmp); 
    }else{
        $sql .=" where `id`='$array'";
    }
return $this->fetch_one($sql);
}





function save($array){
if(isset($array['id'])){
// update編輯
$id=$array['id'];
unset($array['id']);
$tmp=$this->arrayToSQL($array);
        $sql="update $this->table set ".join(",",$tmp)." where `id`='$id'";
}else{
        // insert
        $keys=join("`,`",array_keys($array));
        $values=join("','",$array);
        $sql="insert into $this->table (`{$keys}`) values('{$values }')";
}

return $this->pdo->exec($sql);
}




function del($array){

    $sql="delete from $this->table ";
    if(is_array($array) ){
$tmp=$this->arrayToSQL($array);
$sql .=" where ".join(" && ",$tmp); 
    }else{
        $sql .=" where `id`='$array'";
    }
    
    return $this->pdo->exec($sql);


}
function count(...$arg){
    $sql="select count(*) from $this->table ";
    if(!empty($arg[0]) && is_array($arg[0])){
        $tmp=$this->arrayToSQL($arg[0]);
        $sql .=" where ".join(" && ",$tmp);
    }else if(isset($arg[0]) && is_string($arg[0])){
        $sql .=$arg[0];
    }

    if(!empty($arg[1])){
        $sql .= $arg[1];
    }
    return $this->pdo->query($sql)->fetchColumn();
}





function sum($col,$where=[]){
    return $this->math('sum',$col,$where);
}



protected function math($math,$col='id',$where=[]){
    $sql="SELECT $math($col) FROM $this->table";

    if(!empty($where)){
        $tmp=$this->a2s($where);
        $sql=$sql . " WHERE " . join(" && ", $tmp);
    }

    return $this->pdo->query($sql)->fetchColumn();
}








function arrayTosql($array){
    // $tmp[];
    foreach($array as $key=>$value){
        $tmp[]="`$key`='$value'";
    }
    return $tmp;
}
function fetch_one($sql){
    return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
}
function fetch_all($sql){

        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
}




}










function to($url){ 
    header("location:" .$url);
} 

function q($sql){
$dsn="mysql:host=localhost;charset=utf8;dbname=db22";
$pdo=new PDO($dsn ,'root','');
return $pdo->query($sql)->fetchAll();

 
}

function dd($array){
echo "<pre>";
print_r($array);
echo "</pre>";
}

$Total=new DB('total');

if(!isset($_SESSION['view'])){
    if($Total->count(['date'=>date("Y-m-d")])>0){
        $total =$Total->find(['date'=>date("Y-m-d")]);
        $total['total']++;
        $Total->save($total);
    }else{
        $Total->save(['date'=>date("Y-m-d"),'total'=>1]);
    
    }
    $_SESSION['view']=1;
}
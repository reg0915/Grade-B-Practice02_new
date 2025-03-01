<?php
date_default_timezone_set('Asia/Taipei');
session_start();

class DB
{
    protected $dsn = "mysql:host=localhost;charset=utf8;dbname=db22";
    protected $pdo;
    protected $table;
    public static  $type=[
       1=> '健康新知',  
       2=> '菸害防治',
       3=> '癌症防治',
       4=> '慢性病防治'
        
    ];

function __construct($table){
    $this->table=$table;
    $this->pdo=new PDO($this->dsn,'root','');
    }

function all(...$arg){
    $sql="select * from $this->table ";
    if(!empty($arg[0]) && is_array($arg[0])){
        $tmp=$this->arrayToSQL($arg[0]);
        $sql .=" where ".join(" && ",$tmp);
    }else if(isset($arg[0]) && is_string($arg[0])){
        $sql .=$arg[0];
        }

        if (isset($arg[0])&& ! empty($arg[1])) {
            $sql .= $arg[1];
        }
        return $this->fetch_all($sql);
    }

    public function find($array)
    {
        $sql = "select * from $this->table ";
        if (is_array($array)) {
            $tmp = $this->arrayToSQL($array);
            $sql .= " where " . join(" && ", $tmp);
        } else {
            $sql .= " where `id`='$array'";
        }

        return $this->fetch_one($sql);
    }
    public function save($array)
    {
        if (isset($array['id'])) {
            //update
            $id = $array['id'];
            unset($array['id']);
            $tmp = $this->arrayToSQL($array);
            $sql = "update $this->table set " . join(",", $tmp) . " where `id`='$id'";

        } else {
            //insert
            $keys   = join("`,`", array_keys($array));
            $values = join("','", $array);
            $sql    = "insert into $this->table (`{$keys}`) values('{$values}')";
        }

        return $this->pdo->exec($sql);

    }
    public function del($array)
    {
        $sql = "delete  from $this->table ";
        if (is_array($array)) {
            $tmp = $this->arrayToSQL($array);
            $sql .= " where " . join(" && ", $tmp);
        } else {
            $sql .= " where `id`='$array'";
        }

        return $this->pdo->exec($sql);
    }
    public function count(...$arg)
    {
        $sql = "select count(*) from $this->table ";
        if (! empty($arg[0]) && is_array($arg[0])) {
            $tmp = $this->arrayToSQL($arg[0]);
            $sql .= " where " . join(" && ", $tmp);
        } else if (isset($arg[0]) && is_string($arg[0])) {
            $sql .= $arg[0];
        }

        if (! empty($arg[1])) {
            $sql .= $arg[1];
        }
        //echo $sql;
        return $this->pdo->query($sql)->fetchColumn();
    }

    public function arrayToSQL($array)
    {
        $tmp = [];
        foreach ($array as $key => $value) {
            $tmp[] = "`$key`='$value'";
        }

        return $tmp;

    }
    public function fetch_one($sql)
    {
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
    public function fetch_all($sql)
    {
        return $this->pdo->query($sql)->fetchALL(PDO::FETCH_ASSOC);
    }

}

function to($url)
{
    header("location:" . $url);
}

function q($sql)
{
    $dsn = "mysql:host=localhost;charset=utf8;dbname=db22";
    $pdo = new PDO($dsn, 'root', '');
    return $pdo->query($sql)->fetchALL();
}

function qCol($sql)
{
    $dsn = "mysql:host=localhost;charset=utf8;dbname=db22";
    $pdo = new PDO($dsn, 'root', '');
    return $pdo->query($sql)->fetchColumn();
}

function dd($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

$Total = new DB('total');
$User  = new DB('users');
$News  = new DB('news');
$Que   = new DB('que');
$Log   = new DB('log');

// if (! isset($_SESSION['view'])) {
//     if ($Total->count(['date' => date("Y-m-d")]) > 0) {
//         $total = $Total->find(['date' => date("Y-m-d")]);
//         $total['total']++;
//         $Total->save($total);
//     } else {
//         $Total->save(['date' => date("Y-m-d"), 'total' => 1]);
//     }
//     $_SESSION['view'] = 1;
// }


if(!isset($_SESSION['total'])){
    $today= date("Y-m-d");
    $total=$Total->find(['date'=>$today]);
    // 如果total有值
    if($total){
        // 更新今日瀏覽數
        $total['total']++;
        $Total->save($total);
    }else{
        // 如果total回傳沒有值
         // 新增當天的紀錄
        $Total->save(['date'=>$today,'total'=>1]);
    }
    // $grand_total=$Total->find(['id'=>1]); // 只存一筆累積數據
    // $grand_total['grand_total']++;
    // $Total->save($grand_total);
    $_SESSION['total']=1;
} 
<fieldset style='width:85%;margin:auto'>


    <legend>最新文章管理</legend>

    <form method="post" action="./api/edit_news.php">
    <table class="ct" style="width:100%">
        <tr>
            <th>編號</th>
            <th width="50%">標題</th>
            <th>顯示</th>
            <th>刪除</th>
        </tr>
        <?php
        // 分頁
$total=$News->count();
$div=3;
$pages=ceil($total/$div);
$now=$_GET['p']??1;
$start=($now-1)*$div;


$rows=$News->all(" Limit $start,$div");

foreach($rows as $idx=>$row):
?>
        <tr>
            <td><?=$start+$idx+1;?></td>
            <td><?=$row['title'];?></td>
            <td>
                <input type="checkbox" name="sh[]" value="<?=$row['id'];?>" <?=($row['sh']==1)?"checked":"";?>>
            </td>

            <td>
                <input type="checkbox" name="del[]" value="<?=$row['id'];?>">
            </td>
        </tr>
        <input type="hidden" name="id[]" value="<?=$row['id'];?>">
        <?php   endforeach;  ?>
    </table>
<div class="ct">
    <?php

    if(($now-1)>0){
        echo "<a href='?do=news&p=".($now-1)."'> &lt;</a>";
    }

for($i=1;$i<=$pages;$i++){
    $size=($i==$now)?"24px":"16px";
    echo "<a href='?do=news&p=$i' style='font-size:$size'> $i </a>";
}




    if(($now+1)<=$pages){
        echo "<a href='?do=news&p=".($now+1)."'> &gt;</a>";
    }

    ?>
</div>

<div class="ct">

    <button type="submit">確定修改</button>
</div>

</form>
</fieldset>
<!-- 
<script>

function edit(){
let ids=$("input[name='id[]']").map((idx,item)=>{return $(item).val()}).get();
console.log(ids);

}





</script> -->
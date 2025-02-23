<div>
    目前位置：首頁 > 分類網誌 > <span id='type'>健康新知</span>          
</div>
<style>
    .type{
        display:block;
        margin:10px;
        
    }
</style>

<fieldset style='width:150px;display:inline-block;vertical-align:top'>
    <legend>分類網誌</legend>
    <a href="#" class='type' data-type='1'>健康新知</a>
    <a href="#" class='type' data-type='2'>菸害防制</a>
    <a href="#" class='type' data-type='3'>癌症防治</a>
    <a href="#" class='type' data-type='4'>慢性病防治</a>
</fieldset>
<!-- vertiacl-align:top -->
<fieldset style='width:500px;display:inline-block'>
    <legend>文章列表</legend>
</fieldset> 

<script>
getlist(1)





    // 當type被點的時候，會發生什麼事情
$(".type").on("click",function(){
    // this這裡代表上面一段a標籤，點下去後顯示this的文字是什麼
    // console.log($(this).text())
    // #type的文字就代表$(this)的文字
    $("#type").text($(this).text())
let type=$(this).data('type')
getlist(type)
// $("postList").load(".api/get_list.php",{type})

})


function getlist(type){
    $("#postList").load("./api/get_list.php",{type})
}



</script>
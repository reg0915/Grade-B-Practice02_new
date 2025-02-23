<fieldset style="width:70%;margin:auto">
    <legend>新增問卷</legend>
    <form action="./api/add_que.php" method="post">
    <table style="width:100%">
        <tr>
            <td>問卷名稱</td>
            <td>
                <input type="text" name="subject" id="subject" style="width:80%">
            </td>
        </tr>
        <tr>
            <td colspan='2'>
                <div id="options">
                    選項<input type="text" name="options[]" id="" style="width:80%">
                    <input type="button" value="更多" onclick="more()">
                </div>
            </td>

        </tr>
    </table>
    <div>
        <!-- <button onclick="send()"> 新增</button>
        <button onclick="resetForm()">清空 </button> -->
        <input type="submit" value="新增">
        <input type="reset" value="清空">
    </div>
</form>
</fieldset>

<script>
function more() {
    let el = `<div>選項<input type="text" name="options[]" id="" style="width:80%"></div>`
    // $("#options")---->id
        $("#options").before(el)
    }
    
    function send(){
        
        let subject=$("#subject").val()
        let options=$("input[name='options[]']").map((id,item)=>$(item).val()).get()
        console.log(subject,options)
        
    }
    
    
    function resetForm(){
        $("input[type='text']").val("")
    }

</script>

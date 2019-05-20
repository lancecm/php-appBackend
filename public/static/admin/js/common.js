/**
 * form 通用提交数据的方法
 * @param form
 */
function save(form) {
    var data = $(form).serialize();
    // alert(data);
    var url = $(form).attr('url'); // current url

    $.post(url, data, function(result){
        if (result.code == 0) {
            layer.msg(result.msg, {icon: 5, time:2000});
        } else {
            self.location=result.data.jump_url;
        }
    }, 'JSON');
}

/**
 * timepicker 时间选择插件
 * @param flag
 */
function selecttime(flag){
    if(flag==1){
        // for start time
        var endTime = $("#countTimeend").val();
        if(endTime != ""){
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',maxDate:endTime})}
        else{
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})
        }
    }else{
        // for end time
        var startTime = $("#countTimestart").val();
        if(startTime != ""){
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:startTime})
        }else{
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})
        }
    }
}
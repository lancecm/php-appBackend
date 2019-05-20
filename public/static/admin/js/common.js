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

/**
 * 通用化删除操作
 * @param obj
 */
function app_del(obj) {
    // 获取模板中的url地址
    var url = $(obj).attr('del_url');
    // alert(url);
    layer.confirm('确认删除：', function(index) {
        $.ajax({
            type: 'post',
            url: url,
            dataType: 'json',
            success: function(data) {
                // if (data.code == 1) {
                //     // 执行跳转
                //     self.location = data.data['jump_url'];
                // } else if (data.code == 0) {
                //     layer.msg(data.msg, {icon: 2, time: 2000});
                // }
                // 页面不刷新方式
                if (data.code == 1) {
                    $(obj).parents("tr").remove();
                    layer.msg('已删除', {icon: 1, time: 1000});
                } else {
                    layer.msg(data.msg, {icon: 2, time: 2000});
                }
            },
            error: function(data) {
                console.log(data.msg);
            },
        })
    })
}

/**
 * 改变状态
 * @param obj
 */
function change_status(obj) {
    // 获取模板中的url地址
    var url = $(obj).attr('status_url');
    // alert(url);
    layer.confirm('改变状态?', function(index) {
        $.ajax({
            type: 'post',
            url: url,
            dataType: 'json',
            success: function(data) {
                if (data.code == 1) {
                    // 执行跳转
                    self.location = data.data['jump_url'];
                } else if (data.code == 0) {
                    layer.msg(data.msg, {icon: 2, time: 2000});
                }
            },
            error: function(data) {
                console.log(data.msg);
            },
        })
    })
}
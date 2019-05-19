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
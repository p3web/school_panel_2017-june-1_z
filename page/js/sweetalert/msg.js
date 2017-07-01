/**
 * Created by peymanvalikhanli on 5/1/17 AD.
 */

var message = {};


message.show = function (text, title, type, btn) {

    //try {
    //    swal({
    //        title: (title == '' || title == undefined ? '' : title),
    //        text: text,
    //        type: (type == '' || type == undefined ? '' : type ),
    //        confirmButtonText: (btn == '' || btn == undefined ? "OK" : btn)
    //    });
    //} catch (e) {
    //    console.log(e);
    //}
    alert(text);
    location.reload();

};
message.Confirm = function (text, title, CallBack, param, type) {
    //if (type == null) {
    //    type = 'warning';
    //}
    //swal({
    //    title: title,
    //    text: text,
    //    type: type,
    //    showCancelButton: true,
    //    confirmButtonColor: '#88d66d',
    //    cancelButtonColor: '#dd5e6d',
    //    confirmButtonText: 'Yes'
    //}).then(function () {
    //    CallBack(param);
    //})
    var r=confirm(text);
    if (r==true)
    {
        CallBack(param);
    }
    else
    {

    }
};
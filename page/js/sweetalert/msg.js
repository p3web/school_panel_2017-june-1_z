/**
 * Created by peymanvalikhanli on 5/1/17 AD.
 */

var message = {};



message.show = function (text , title , type , btn ) {

    try {
        swal({
            title: (title == '' || title == undefined ? '' : title),
            text: text,
            type: (type == '' || type == undefined ? '' : type ),
            confirmButtonText: (btn== '' || btn == undefined ? "OK" : btn)
        });
    }catch (e){
        console.log(e);
    }

<<<<<<< HEAD
=======
};
message.Confirm = function (text, title, CallBack, param, type) {
    if (type == null) {
        type = 'warning';
    }
    swal({
        title: title,
        text: text,
        type: type,
        showCancelButton: true,
        confirmButtonColor: '#88d66d',
        cancelButtonColor: '#dd5e6d',
        confirmButtonText: 'Yes'
    }).then(function () {
        CallBack(param);
    })
>>>>>>> b002a728f4dcec2aa087814e06be3fc5418d47a1
};
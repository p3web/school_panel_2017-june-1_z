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

};
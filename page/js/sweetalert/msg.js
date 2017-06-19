/**
 * Created by peymanvalikhanli on 5/1/17 AD.
 */

var message = {};



message.show = function (text , title , type , btn ) {

    try {
        swal({
            title: (title == '' || title == undefined ? '' : __lang.translate(title)),
            text: __lang.translate(text),
            type: (type == '' || type == undefined ? '' : __lang.translate(type) ),
            confirmButtonText: (btn== '' || btn == undefined ? __lang.translate("OK") : __lang.translate(btn))
        });
    }catch (e){
        console.log(e);
    }

}
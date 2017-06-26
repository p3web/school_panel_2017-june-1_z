<<<<<<< HEAD
<<<<<<< HEAD
var Map = {
    url: '/backend/controller_school_admin_panel.php'
};

Map.sendAction = function () {

};
Map.setValue = function () {
        var checked = document.querySelectorAll('.mapCheck:checked');
        var formData = new FormData();
        for(var i =0 ; i < checked.length ; i++){
            formData.append('formDoor[]' , checked[i].value);
        }
        ajax.sender_data_json_by_url_callback(Map.url , {act :'get_map' , formDoor:formData} , console.log);

};
=======
var Map = {
    url: '/backend/controller_school_admin_panel.php'
};

Map.sendAction = function () {

};
Map.setValue = function () {
    var checked = document.querySelectorAll('.mapCheck:checked');
    var formData = new FormData();
    for(var i =0 ; i < checked.length ; i++){
        formData.append('formDoor[]' , checked[i].value);
    }
    ajax.sender_data_json_by_url_callback(Map.url , {act :'get_map' , formDoor:formData} , console.log);

};
>>>>>>> 00fa650991cd8d44a416dda2eff7b5777dca6709
=======
var Map = {
    url: '/backend/controller_school_admin_panel.php'
};

Map.sendAction = function () {

};
Map.setValue = function () {
    var checked = document.querySelectorAll('.mapCheck:checked');
    var formData = new FormData();
    for(var i =0 ; i < checked.length ; i++){
        formData.append('formDoor[]' , checked[i].value);
    }
    ajax.sender_data_json_by_url_callback(Map.url , {act :'get_map' , formDoor:formData} , console.log);

};
>>>>>>> 00fa650991cd8d44a416dda2eff7b5777dca6709

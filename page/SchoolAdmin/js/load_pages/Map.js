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
>>>>>>> 6e97550486ba155f7a7cb6b86dfc474f92657f4b

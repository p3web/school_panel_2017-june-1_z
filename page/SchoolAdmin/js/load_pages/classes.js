/*Classes*/
var Classes = {};
Classes.LoadClassesTable = function () {
    ajax.sender_data_json_by_url_callback(Global.url, {act: 'get_tbl_classes'}, Classes.CreateClassesTblData);
};
Classes.CreateClassesTblData = function (Data) {
    var ClassesData = [];

    for (var i = 0; i < Data.length; i++) {
        var Rows = {};
        Rows['classname'] = Data[i].classname;
        Rows['option'] = {
            value: '',
            htmlTag: '<i class="glyphicon glyphicon-edit actionIcon" onclick="Classes.Edit(' + "'" + Data[i].classname + "'" + ')"></i>'
        };
        ClassesData.push(Rows);
    }
    Global.setData(ClassesData, ClassesGrid);
};

Classes.Edit = function (ClassName) {
    document.getElementById('ClassNameinp').value = ClassName;
    document.getElementById('CurrentClassName').value = ClassName;
    showModal('edit_Classes_Modal');
};
Classes.Update = function () {
    var NewClassName = document.getElementById('ClassNameinp').value;
    var currentClassName = document.getElementById('CurrentClassName').value;
    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'edit_class_by_schoolId',
        current_name: currentClassName,
        name: NewClassName
    }, Classes.Message);
};
Classes.Message = function (Data) {
    Global.ResultMessage(Data.data);
};
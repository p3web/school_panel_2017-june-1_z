/*Global*/
function setData(Data , gridName) {
    gridName.data = Data;
    gridName.render();
}
/*TEACHER TABLE*/
function LoadTeacherTable(){
    ajax.sender_data_json_by_url_callback('/backend/controller_school_admin_panel.php',{act:'check_login'},console.log); // TODO: set information
    ajax.sender_data_json_by_url_callback('/backend/controller_school_admin_panel.php',{act:'get_tbl_teachers'},CreateTeacherTblData);
}
function CreateTeacherTblData(data) {
    var TeacherData = [];
    for (var i = 0; i < data.length; i++) {

        var Rows = {};

        Rows['name'] = 'notSet';
        Rows['email'] = data[i].teacheremailid;
        Rows['status'] = data[i].status;
        if (data[i].status == 'active') {
            Rows['info'] = '<a href="#">View Profile</a>';
            Rows['option'] = '<i class="glyphicon glyphicon-remove"></i><i class="glyphicon glyphicon-edit"></i>';
        } else {
            Rows['info'] = 'pending';
            Rows['option'] = {value:'',htmlTag:'<i  class="glyphicon glyphicon-remove"></i>'};
        }
        TeacherData.push(Rows);
    }
    setData(TeacherData , TeacherGrid);
}
function showModal(ModalID) {
    $('#'+ModalID).modal('show');
}
/*Classes*/
function LoadClassesTable(){
    ajax.sender_data_json_by_url_callback('/backend/controller_school_admin_panel.php',{act:'get_tbl_classes'},CreateClassesTblData);
}
function CreateClassesTblData(Data) {
    var ClassesData = [];

    for(var i =0;i < Data.length ; i++){
        var Rows = {};
        Rows['classname'] = Data[i].classname;

        ClassesData.push(Rows);
    }
    setData(ClassesData , ClassesGrid);
}
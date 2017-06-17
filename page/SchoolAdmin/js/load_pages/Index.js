/*TEACHER TABLE*/
function LoadTable(){
    ajax.sender_data_json_by_url_callback('/backend/controller_school_admin_panel.php',{act:'check_login'},console.log); // TODO: set information
    ajax.sender_data_json_by_url_callback('/backend/controller_school_admin_panel.php',{act:'get_tbl_teachers'},CreateTeacherTblData);
}
function CreateTeacherTblData(data) {
    var TeacherData = [];
    var DataKey;
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
            Rows['option'] = '<i class="glyphicon glyphicon-remove"></i>';
        }
        TeacherData.push(Rows);
    }
    var TeacherGrid = new PSCO_grid('TeacherGrid');
    TeacherGrid.cols = [
        {name: 'name', thname: 'Employee Name'},
        {name: 'email', thname: 'Employee Email ID*'},
        {name: 'info', thname: 'Info'},
        {name: 'status', thname: 'Status'},
        {name: 'option', thname: 'Option'}
    ];
    TeacherGrid.RightToLeft = false;
    TeacherGrid.embeddedRow = [[{},{name:'Employee Name' , id:'NameInvite' , type:'inputtext'},{name:'Click here to add email address' , id:'EmailInvite' , type:'inputtext'},{},{},{name:'Invite', id:'InviteBTN' , type:'btn' , attribute:[{name:'class' , value:'btn btn-success'}]}]]

    TeacherGrid.data = TeacherData;
    TeacherGrid.render();
}

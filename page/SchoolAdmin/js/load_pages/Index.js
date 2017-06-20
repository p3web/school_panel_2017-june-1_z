var url = '/backend/controller_school_admin_panel.php';
/*Global*/
function setData(Data, gridName) {
    gridName.data = Data;
    gridName.render();
}
function showModal(ModalID) {
    $('#' + ModalID).modal('show');
}
function checkLogin(Data) {
    if (Data == false) {
        window.location = '/backend/login.php';
    } else {
        GlobalFunc.userDetials = Data;
        document.getElementById('UserFullName').innerText = Data.firstname + ' ' + Data.lastname;
        document.getElementById('SchoolName').innerText = Data.schoolname;
        document.getElementById('City').innerText = Data.city + '/' + Data.suburb;
    }
}
/*TEACHER TABLE*/
var Teacher = {};
Teacher.LoadTeacherTable = function () {
    ajax.sender_data_json_by_url_callback(url, {act: 'check_login'}, checkLogin);
    ajax.sender_data_json_by_url_callback(url, {act: 'get_tbl_teachers'}, Teacher.CreateTeacherTblData);
};
Teacher.CreateTeacherTblData = function (data) {
    var TeacherData = [];
    for (var i = 0; i < data.length; i++) {

        var Rows = {};

        Rows['name'] = data[i].name;
        Rows['email'] = data[i].teacheremailid;
        Rows['status'] = data[i].status;
        if (data[i].status == 'active') {
            Rows['info'] = '<a href="#">View Profile</a>';
            Rows['option'] = {
                value: '',
                htmlTag: '<i class="glyphicon glyphicon-remove actionIcon" onclick="Teacher.DeleteRow(' + "'" + data[i].teacheremailid + "'" + ')"></i>    <i class="glyphicon glyphicon-edit actionIcon"></i>'
            };
        } else {
            Rows['info'] = 'pending';
            Rows['option'] = {
                value: '',
                htmlTag: '<i class="glyphicon glyphicon-remove actionIcon" onclick="Teacher.DeleteRow(' + "'" + data[i].teacheremailid + "'" + ')"></i>'
            };
        }
        TeacherData.push(Rows);
    }
    setData(TeacherData, TeacherGrid);
};
Teacher.DeleteRow = function (TeacherEmail) {
    ajax.sender_data_json_by_url_callback(url, {
        act: 'delete_teacher_by_teacheremailid',
        teacheremailid: TeacherEmail
    }, console.log);
};

/*Classes*/
var Classes = {};
Classes.LoadClassesTable = function () {
    ajax.sender_data_json_by_url_callback(url, {act: 'get_tbl_classes'}, Classes.CreateClassesTblData);
};
Classes.CreateClassesTblData = function (Data) {
    var ClassesData = [];

    for (var i = 0; i < Data.length; i++) {
        var Rows = {};
        Rows['classname'] = Data[i].classname;

        ClassesData.push(Rows);
    }
    setData(ClassesData, ClassesGrid);
};


/*Key Facts*/
var KeyFacts = {};

KeyFacts.LoadKeyFact = function () {
    ajax.sender_data_json_by_url_callback(url , {act:'get_key_fact_json'} , KeyFacts.createKeyFact);
};

KeyFacts.createKeyFact = function (Data) {
    document.getElementById('Keyfact').innerHTML = Data.data;
};
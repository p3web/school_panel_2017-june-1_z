/**
 * Created by peymanvalikhanli on 6/29/17 AD.
 */

/*Classes*/
var student = {
    Edit:{}
};
student.LoadStudentTable = function () {
    ajax.sender_data_json_by_url_callback(Global.url, {act: 'get_tbl_classes'}, student.createClassDropDown);
    //ajax.sender_data_json_by_url_callback(Global.url, {act: 'get_tbl_classes'}, student.createClassDropDown);
    ajax.sender_data_json_by_url_callback(Global.url, {act: 'get_tbl_teachers'}, student.createTeacherDropDown);
};

student.createClassDropDown = function (data){
    data = Global.RemoveRepeate(data);
    var opt = '<optgroup label="Class name"></optgroup>';
    for(var i = 0 ; i<data.length ; i++){
        opt+= '<option value="'+data[i].classname+'">'+data[i].classname+'</option>';
    }
    $("#studentClassNameDropDown").html(opt);
    ///////// Get Data for Grid by first class
    Global.RefreshGrid('PstudentGrid' , {act:'get_tbl_student' , classname : data[0].classname} , Global.url , student.CreateStudentTblData)
};

student.getClassByTeacher = function(teacheremailid){
    ajax.sender_data_json_by_url_callback(Global.url , {act:'get_class_by_teacher_teacherEmailId' , teacheremailid:teacheremailid} ,student.createClassDropDown );
};


student.createTeacherDropDown = function (data){
    data = Global.RemoveRepeate(data);
    var opt = '<optgroup label="Student name"></optgroup>';
    for(var i = 0 ; i<data.length ; i++){
        opt+= '<option value="'+data[i].teacheremailid+'">'+data[i].name+'</option>';
    }
    $("#studentTeacherNameDropDown").html(opt);
};

student.CreateStudentTblData = function (Data) {
    var ClassesData = [];

    for (var i = 0; i < Data.length; i++) {
        var Rows = {};
        Rows['firstname'] = Data[i].firstname + Data[i].lastname ;
        Rows['studentemailid'] = Data[i].studentemailid;
        Rows['status'] = Data[i].status;
      if (Data[i].status == 'active') {
                   Rows['info'] = {
                       value: '',
                       htmlTag: '<a class="InheritactionLink" onclick="student.ViewProfile(' + "'" + Data[i].studentemailid + "'" + ')" href="#"><i class="glyphicon glyphicon-eye-open"></i></i></a> <i class="glyphicon glyphicon-edit actionIcon" onclick="student.Edit.Edit(' + "'" + Data[i].teacheremailid + "'" + ')""></i>'
                   };
                   Rows['option'] = {
                       value: '',
                       htmlTag: '<i class="glyphicon glyphicon-remove actionIcon" onclick=""></i>'
                   };
               } else {
                   Rows['info'] = 'Waiting approval';
                   Rows['option'] = {
                       value: '',
                       htmlTag: '<i class="glyphicon glyphicon-remove actionIcon" onclick=""></i>'
                   };
               }
        Rows['gender'] = Data[i].gender;
        Rows['lastname'] = Data[i].lastname;
        Rows['religion'] = Data[i].religion;
        Rows['schoolid'] = Data[i].schoolid;
        Rows['token'] = Data[i].token;
        Rows['classname'] = Data[i].classname;
        ClassesData.push(Rows);
    }

    Global.setData(ClassesData, StuGrid);

};

student.Edit.Edit = function (ClassName) {
    document.getElementById('ClassNameinp').value = ClassName;
    document.getElementById('CurrentClassName').value = ClassName;
    showModal('edit_Classes_Modal');
};
student.Update = function () {
    var NewClassName = document.getElementById('ClassNameinp').value;
    var currentClassName = document.getElementById('CurrentClassName').value;
    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'edit_class_by_schoolId',
        current_name: currentClassName,
        name: NewClassName
    }, student.Message);
};
student.Message = function (Data) {
    Global.ResultMessage(Data.data);
};

/* View Profile */
student.ViewProfile = function(){

};

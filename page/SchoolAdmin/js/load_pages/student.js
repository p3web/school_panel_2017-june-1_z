/**
 * Created by peymanvalikhanli on 6/29/17 AD.
 */

/*Classes*/
var student = {
    Edit: {}
};
student.LoadStudentTable = function () {
    ajax.sender_data_json_by_url_callback(Global.url, {act: 'get_tbl_classes'}, student.createClassDropDown);
    //ajax.sender_data_json_by_url_callback(Global.url, {act: 'get_tbl_classes'}, student.createClassDropDown);
    ajax.sender_data_json_by_url_callback(Global.url, {act: 'get_tbl_teachers'}, student.createTeacherDropDown);
};

student.createClassDropDown = function (data) {
    data = Global.RemoveRepeate(data, 'classname');
    var opt = '<optgroup label="Class name"></optgroup>';
    for (var i = 0; i < data.length; i++) {
        opt += '<option value="' + data[i].classname + '">' + data[i].classname + '</option>';
    }
    $("#studentClassNameDropDown").html(opt);
    ///////// Get Data for Grid by first class
    Global.RefreshGrid('PstudentGrid', {
        act: 'get_tbl_student',
        classname: data[0].classname
    }, Global.url, student.CreateStudentTblData)
};

student.getClassByTeacher = function (teacheremailid) {
    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'get_class_by_teacher_teacherEmailId',
        teacheremailid: teacheremailid
    }, student.createClassDropDown);
};


student.createTeacherDropDown = function (data) {
    data = Global.RemoveRepeate(data, 'teacheremailid');
    var opt = '<optgroup label="Student name"></optgroup>';
    for (var i = 0; i < data.length; i++) {
        opt += '<option value="' + data[i].teacheremailid + '">' + data[i].name + '</option>';
    }
    $("#studentTeacherNameDropDown").html(opt);
};

student.CreateStudentTblData = function (Data) {
    var ClassesData = [];

    for (var i = 0; i < Data.length; i++) {
        var Rows = {};
        Rows['firstname'] = Data[i].firstname + Data[i].lastname;
        if(Data[i].firstname != '*******') {
            Rows['studentemailid'] = Data[i].studentemailid;
            Rows['status'] = Data[i].status;
            if (Data[i].status == 'active') {
                Rows['info'] = {
                    value: '',
                    htmlTag: '<a class="InheritactionLink" onclick="student.ViewProfile(' + "'" + Data[i].studentemailid + "'" + ')" href="#"><i class="glyphicon glyphicon-eye-open"></i></i></a> <i class="glyphicon glyphicon-edit actionIcon" onclick="student.Edit.Edit(' + "'" + Data[i].studentemailid + "'" + ')""></i>'
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
        }else{
            Rows['status'] = Data[i].status;
            Rows['studentemailid'] = '*******';
            Rows['info'] = '';
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
student.ViewProfile = function () {

};

student.Edit.Edit = function (email) {
    /*document.getElementById('ClassNameinp').value = ClassName;
     document.getElementById('CurrentClassName').value = ClassName;
     showModal('edit_Classes_Modal');*/ //---->for class that deleted !!!
    $('#age_STU').load('../data_value/age_group_60.html');
    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'get_student_by_studentemailid',
        studentemailid: email
    }, student.Edit.fillData); /// ----> get user Details

    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'get_student_language_by_studentemailid',
        studentemailid: email
    }, student.Edit.createLanguage); // ----> get Languages
    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'get_student_age_group_by_studentemailid',
        studentemailid: email
    }, student.Edit.SelectAge); // ----> get ageGroup

    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'studentbirthplace',
        studentemailid: email
    }, student.Edit.fillBrith); // ----> get birthplace

    showModal('edit_Student_data_Modal');
};
student.Edit.Update = function () {
    var allInput = document.querySelectorAll('[data-EditStudent=true]'); //---?> get all inputs
    var param = {act: 'edit_student_user'}; // ---> send param
    for (var i = 0; i < allInput.length; i++) { //----> create Parameter from name and value ...
        param[allInput[i].name] = allInput[i].value;
    }
    ajax.sender_data_json_by_url_callback(Global.url, param, console.log);
};
student.Edit.fillData = function (data) {
    var allInput = document.querySelectorAll('[data-studentProfile=true]');
    data = data[0];
    var DataKey = Object.keys(data);
    for (var i = 0; i < allInput.length; i++) {
        for (var a = 0; a < DataKey.length; a++) {
            if (allInput[i].name == DataKey[a]) {
                try {
                    allInput[i].value = data[DataKey[a]];
                } catch (e) {
                }
                break;
            }
        }
    }

};

student.Edit.createLanguage = function (data) {
    var tag = '';
    var i;
    for (i = 0; i < data.length; i++) {
        tag += '<tr>' +
            '<td><select data-EditStudent="true"  class="PSCO_language form-control" name="lang_'+data[i].id+'" id="lang_' + data[i].id + '" ></select></td>' +
            '<td><select data-EditStudent="true"  class="PSCO_level form-control" name="levellang_'+data[i].id+'" id="langlevel_' + data[i].id + '"></select></td>' +
            '</tr>';
    }
    document.getElementById('LangEditTable_STU').innerHTML = tag;
    setTimeout(function () {
        $('.PSCO_language').load('../data_value/lanuage.html'); /// --- > load languiage & level
        $('.PSCO_level').load('../data_value/lanuage_level.html');
        setTimeout(function () {
            for (i = 0; i < data.length; i++) { //----> select language & level
                document.getElementById('lang_' + data[i].id).value = data[i].languagename;
                document.getElementById('langlevel_' + data[i].id).value = data[i].languagelevel;
            }
        }, 1050);
    }, 100);
};

student.Edit.SelectAge = function (data) {
    setTimeout(function () {
        try {
            document.getElementById('age_STU').value = data[0][0];
        } catch (e) {
        } // TODO : check with correct DATA ;
    }, 1000);
};
student.Edit.fillBrith = function (data) {
    data = data[0];
    document.getElementById('tb_STU').value = data.studentbirthplace;
    document.getElementById('m_STU').value = data.studentmotherbirthplace;
    document.getElementById('gfm_STU').value = data.studentmothersfatherbirthplace;
    document.getElementById('gmm_STU').value = data.studentmothersmotherbirthplace;
    document.getElementById('f_STU').value = data.studentfatherbirthplace;
    document.getElementById('gff_STU').value = data.studentfathersfatherbirthplace;
    document.getElementById('gmf_STU').value = data.studentfathersmotherbirthplace;
};
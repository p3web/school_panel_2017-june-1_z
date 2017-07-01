/*Global*/
var Global = {
    url: '/backend/controller_school_admin_panel.php'
};
Global.ResultMessage = function (result) {
    if (result) {
        message.show('Update was successfull', 'Success', 'success');
    } else {
        message.show('Update was unsuccessfull', 'Error', 'error');
    }
};

<<<<<<< HEAD
Global.RefreshGrid = function (ContainerID , param , url , callBack) {
    document.getElementById(ContainerID).innerHTML = '';
    ajax.sender_data_json_by_url_callback(url , param ,callBack);
};
Global.RemoveRepeate= function(arr) {
    var arrResult = {};
    for (i = 0, n = arr.length; i < n; i++) {
        var item = arr[i];
        arrResult[ item.title + " - " + item.artist ] = item;
    }
    var i = 0;
    var nonDuplicatedArray = [];
    for(var item in arrResult) {
        nonDuplicatedArray[i++] = arrResult[item];
    }
    return nonDuplicatedArray;
};

function set_invite_class_name(data){
    var opt = '';//'<optgroup label="Class name"></optgroup>';
    for(var i = 0 ; i<data.length ; i++){
        opt+= '<option value="'+data[i].classname+'">'+data[i].classname+'</option>';
    }
    $("#classnameInvite").html(opt);
=======
function set_invite_class_name(data){
    var opt = '<optgroup label="Class name"></optgroup>';
    for(var i = 0 ; i<data.length ; i++){
        opt+= '<option value="'+data[i].classname+'">'+data[i].classname+'</option>';
    }
    $("#classInvite").html(opt);
>>>>>>> e1239fba462841e40c4d47613dc439a92857dc5d
}

Global.setData = function (Data, gridName) {
    gridName.data = Data;
    gridName.render();
    //peyman
<<<<<<< HEAD
/*    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'get_tbl_classes'
    }, set_invite_class_name);*/
=======
    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'get_tbl_classes'
    }, set_invite_class_name);
>>>>>>> e1239fba462841e40c4d47613dc439a92857dc5d
};




function showModal(ModalID) {
    $('#' + ModalID).modal('show');
}
function checkLogin(Data) {
    if (Data.data == false) {
        window.location = '/backend/login.php';
    } else {
        GlobalFunc.userDetials = Data;
        document.getElementById('UserFullName').innerText = Data.firstname + ' ' + Data.lastname;
        /*     document.getElementById('SchoolName').innerText = Data.schoolname;
         document.getElementById('City').innerText = Data.city + '/' + Data.suburb;*/
    }
}
/*TEACHER TAB*/
function Confirm(EmailID) {
    message.Confirm('Are you sure ?!', 'Confirm Delete', Teacher.DeleteRow, EmailID);
}
var Teacher = {
    AdminProfile: {},
    Profile: {},
    Edit: {
        trCounter: 0
    },
    Update: {
        Result: []
    }
};
Teacher.LoadTeacherTable = function () {
    ajax.sender_data_json_by_url_callback(Global.url, {act: 'check_login'}, checkLogin);
    ajax.sender_data_json_by_url_callback(Global.url, {act: 'get_tbl_teachers'}, Teacher.CreateTeacherTblData);
};
Teacher.CreateTeacherTblData = function (data) {
    var TeacherData = [];
    for (var i = 0; i < data.length; i++) {

        var Rows = {};
        if(data[i].name != null) {
            Rows['name'] = data[i].name;
        }else{
            Rows['name'] = '_';
        }
        Rows['email'] = data[i].teacheremailid;
        Rows['status'] = data[i].status;
        Rows['classname'] = data[i].classname;
        if (data[i].status == 'active') {
            Rows['info'] = {
                value: '',
                htmlTag: '<a class="InheritactionLink" onclick="Teacher.ViewProfile(' + "'" + data[i].teacheremailid + "'" + ')" href="#"><i class="glyphicon glyphicon-eye-open"></i></i></a> <i class="glyphicon glyphicon-edit actionIcon" onclick="Teacher.Edit.Edit(' + "'" + data[i].teacheremailid + "'" + ')""></i>'
            };
            Rows['option'] = {
                value: '',
<<<<<<< HEAD
                htmlTag: '<i class="glyphicon glyphicon-remove actionIcon" onclick="Confirm(' + "'" + data[i].teacheremailid+'||'+ data[i].classname + "'" + ')"></i>'
=======
                htmlTag: '<i class="glyphicon glyphicon-remove actionIcon" onclick="Confirm(' + "'" + data[i].teacheremailid+'||'+ data[i].classname + "'" + ')"></i>    <i class="glyphicon glyphicon-edit actionIcon" onclick="Teacher.Edit.Edit(' + "'" + data[i].teacheremailid + "'" + ')""></i>'
>>>>>>> e1239fba462841e40c4d47613dc439a92857dc5d
            };
        } else {
            Rows['info'] = 'Waiting approval';
            Rows['option'] = {
                value: '',
                htmlTag: '<i class="glyphicon glyphicon-remove actionIcon" onclick="Confirm(' + "'" +  data[i].teacheremailid+'||'+ data[i].classname + "'" + ')"></i>'
            };
        }
        TeacherData.push(Rows);
    }
    Global.setData(TeacherData, TeacherGrid);
};
Teacher.DeleteRow = function (data) {
    data = data.split("||");
    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'delete_teacher_by_teacherEmailId',
        teacheremailid: data[0],
        classname:data[1]
    }, console.log);
};
/*view Profile*/
Teacher.Profile.CreatePersonalDetails = function (Data) {
    Data = Data[0];
    var Tag = '<tbody>' +
        '<tr>' +
        '<td><label>Name:&nbsp;&nbsp;</label></td>' +
        '<td>' + Data.firstname + '&nbsp;' + Data.lastname + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td><label>Email:&nbsp;&nbsp;</label></td>' +
        '<td >' + Data.teacheremailid + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td><label>Gender:&nbsp;&nbsp;</label></td>' +
        '<td>' + Data.gender + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td ><label>Belief/Religion:&nbsp;&nbsp;</label></td>' +
        '<td >' + Data.religion + '</td>' +
        '</tr>' +
        '</tbody>';
    document.getElementById('TeacherPersonalTable').innerHTML = Tag;
};
Teacher.Profile.CreateAgeGroup = function (Data) {
    document.getElementById('ageGroup').innerText = Data[0].age;
};
Teacher.Profile.CreateBirthDetails = function (Data) {
    Data = Data[0];
    var Tag = '<tbody>' +
        '<tr>' +
        '<td><label>Brith Place:&nbsp;&nbsp;</label></td>' +
        '<td>' + Data.birthplace + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td align="center" colspan="2">' +
        '<hr style="padding 0; margin:1% auto; width:40%">' +
        '</td>' +
        '</tr>' +
        '<tr>' +
        '<td><label>Mother:&nbsp;&nbsp;</label></td>' +
        '<td>' + Data.motherbirthplace + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td><label>Grandfather:&nbsp;&nbsp;</label></td>' +
        '<td>' + Data.motherfatherbirthplace + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td><label>GrandMother:&nbsp;&nbsp;</label></td>' +
        '<td>' + Data.mothermotherbirthplace + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td align="center" colspan="2">' +
        '<hr style="padding 0; margin:1% auto; width:40%">' +
        '</td>' +
        '</tr>' +
        '<tr>' +
        '<td><label>Father:&nbsp;&nbsp;</label></td>' +
        '<td>' + Data.fatherbirthplace + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td><label>Grandfather:&nbsp;&nbsp;</label></td>' +
        '<td>' + Data.fatherfatherbirthplace + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td><label>GrandMother:&nbsp;&nbsp;</label></td>' +
        '<td>' + Data.fathermotherbirthplace + '</td>' +
        '</tr>' +
        '</tbody>';
    document.getElementById('TeacherBirthDetail').innerHTML = Tag;
};
Teacher.Profile.CreateLangDetails = function (Data) {
    var Datakeys = Object.keys(Data);
    var Tag = '<tbody>';
    for (var i = 0; i < Datakeys.length; i++) {
        Tag += '<tr>' +
            '<td><label>' + Data[Datakeys[i]].languagename + ':&nbsp;&nbsp;</label></td>' +
            '<td>' + Data[Datakeys[i]].languagelevel + '</td>' +
            '<td></td>' +
            '</tr>';
    }
    Tag += '</tbody>';
    document.getElementById('TeacherLangDetails').innerHTML = Tag;

};
Teacher.ViewProfile = function (EmailID) {
    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'get_teacher_by_teacheremailid',
        teacheremailid: EmailID
    }, Teacher.Profile.CreatePersonalDetails);
    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'get_teacher_birthDetails_by_teacherEmailId',
        teacheremailid: EmailID
    }, Teacher.Profile.CreateBirthDetails);
    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'get_teacher_lang_by_teacherEmailId',
        teacheremailid: EmailID
    }, Teacher.Profile.CreateLangDetails);
    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'get_teacher_age_group_by_teacherEmailId',
        teacheremailid: EmailID
    }, Teacher.Profile.CreateAgeGroup);
    setTimeout(function () {
        showModal('dataModal');
    }, 500);
};

/*Teacher Edit*/
Teacher.Edit.FillInputPersonal = function (Data) {
    Data = Data[0];
    document.getElementById('Teacheremail').value = Data.teacheremailid;
    document.getElementById('firstname').value = Data.firstname;
    document.getElementById('lastname').value = Data.lastname;
    document.getElementById('gender').value = Data.gender.toLowerCase();
    document.getElementById('beliefreligion').value = Data.religion;
};
Teacher.Edit.FillInputBirth = function (Data) {
    Data = Data[0];
    document.getElementById('tb').value = Data.birthplace;
    document.getElementById('m').value = Data.motherbirthplace;
    document.getElementById('gfm').value = Data.motherfatherbirthplace;
    document.getElementById('gmm').value = Data.mothermotherbirthplace;
    document.getElementById('f').value = Data.fatherbirthplace;
    document.getElementById('gff').value = Data.fatherfatherbirthplace;
    document.getElementById('gmf').value = Data.fathermotherbirthplace;
};
Teacher.Edit.FillInputLang = function (Data) {
    var DataKeys = Object.keys(Data);
    var Tag = '';
    var i;
    for (i = 0; i < DataKeys.length; i++) {
        Tag += '<tr>' +
            '<td><select id="edit_teacher_language' + i + '" name="lang_91" data-LangID="' + Data[DataKeys[i]].id + '" class="PSCO_employee_language form-control" data-placeholder="Choose a Language..." form="update_form">' +
            '</select>' +
            '</td>' +
            '<td>' +
            '<select id="edit_teacher_language_level' + i + '" name="langlevel_91" class="PSCO_employee_language_level form-control" data-placeholder="Choose a Language level..." form="update_form">' +
            '</select><br></td>' +
            '</tr>';
    }
    document.getElementById('LangEditTable').innerHTML = Tag;
    setTimeout(function () {
        $('.PSCO_employee_language').ready(function () {
            $('.PSCO_employee_language').load('../data_value/lanuage.html');
        });
        $('.PSCO_employee_language_level').ready(function () {
            $('.PSCO_employee_language_level').load('../data_value/lanuage_level.html');
        });

    }, 100);
    setTimeout(function () {
        for (i = 0; i < DataKeys.length; i++) {
            document.getElementById('edit_teacher_language' + i).value = Data[DataKeys[i]].languagename;
            document.getElementById('edit_teacher_language_level' + i).value = Data[DataKeys[i]].languagelevel;
        }
    }, 1000);
};
Teacher.Edit.FillInputAgeGroup = function (Data) {
    setTimeout(function () {
        var age = document.getElementById('age');
        age.value = Data[0].age;
        age.setAttribute('data-age', Data[0].id);
    }, 500);
};
Teacher.Edit.Edit = function (EmailID) {
    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'get_teacher_by_teacheremailid',
        teacheremailid: EmailID
    }, Teacher.Edit.FillInputPersonal);
    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'get_teacher_birthDetails_by_teacherEmailId',
        teacheremailid: EmailID
    }, Teacher.Edit.FillInputBirth);
    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'get_teacher_lang_by_teacherEmailId',
        teacheremailid: EmailID
    }, Teacher.Edit.FillInputLang);
    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'get_teacher_age_group_by_teacherEmailId',
        teacheremailid: EmailID
    }, Teacher.Edit.FillInputAgeGroup);
    setTimeout(function () {
        showModal('edit_data_Modal');
    }, 500);
};
/*add Language View*/
Teacher.Edit.AddLanguage = function () {

    var Tbody = document.querySelector('#LangEditTable');

    var tr = document.createElement('tr');
    tr.setAttribute('id', 'langtr' + Teacher.Edit.trCounter);

    var Langtd = document.createElement('td');
    var Leveltd = document.createElement('td');
    var DeleteTd = document.createElement('td');

    var Langselect = document.createElement('select');
    var Levelselect = document.createElement('select');
    var langoption = document.createElement('option');
    var leveloption = document.createElement('option');

    langoption.innerText = 'Select One';
    leveloption.innerText = 'Select One';

    var DeleteTrBtn = document.createElement('div');
    DeleteTrBtn.setAttribute('class', 'btn Anim-toptoleft btn-danger btn-block');

    Langselect.setAttribute('id', 'LangSelect' + Teacher.Edit.trCounter);
    Levelselect.setAttribute('id', 'LevelSelect' + Teacher.Edit.trCounter);
    Langselect.setAttribute('class', 'Anim-toptoleft form-control');
    Levelselect.setAttribute('class', 'Anim-toptoleft form-control');
    Langselect.setAttribute('data-addedLang', 'true'); //---> for select added select Tag in update function
    Levelselect.setAttribute('data-addedLevel', 'true'); //---> for select added select Tag in update function
    DeleteTrBtn.innerText = 'Delete This';
    DeleteTrBtn.setAttribute('onclick', "DeleteTr('langtr" + Teacher.Edit.trCounter + "')");

    // ______ AppendChild
    Langselect.appendChild(langoption);
    Levelselect.appendChild(leveloption);
    Langtd.appendChild(Langselect);
    Leveltd.appendChild(Levelselect);
    DeleteTd.appendChild(DeleteTrBtn);

    tr.appendChild(Langtd);
    tr.appendChild(Leveltd);
    tr.appendChild(DeleteTd);

    Tbody.appendChild(tr);
    setTimeout(function () {
        $('#LangSelect' + Teacher.Edit.trCounter).load('../data_value/lanuage.html');
        $('#LevelSelect' + Teacher.Edit.trCounter).load('../data_value/lanuage_level.html');
        Teacher.Edit.trCounter++;
    }, 200);

};
function DeleteTr(id) {
    var tr = document.getElementById(id);
    tr.parentNode.removeChild(tr);
}
/*Update Teacher*/

Teacher.Update.PersonalDetails = function () {
    var EmailID = document.getElementById('Teacheremail').value;
    var firstname = document.getElementById('firstname').value;
    var lastname = document.getElementById('lastname').value;
    var gender = document.getElementById('gender').value;
    var beliefreligion = document.getElementById('beliefreligion').value;
    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'edit_teacher_by_teacherEmailId',
        teacheremailid: EmailID,
        firstname: firstname,
        lastname: lastname,
        gender: gender,
        religion: beliefreligion
    }, Teacher.Update.CheckResult)
};
Teacher.Update.BrithDetails = function () {
    var EmailID = document.getElementById('Teacheremail').value;
    var TeacherBirth = document.getElementById('tb').value;
    var motherB = document.getElementById('m').value;
    var gfm = document.getElementById('gfm').value;
    var gmm = document.getElementById('gmm').value;
    var fatherB = document.getElementById('f').value;
    var gff = document.getElementById('gff').value;
    var gmf = document.getElementById('gmf').value;
    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'edit_teacher_birthDetails_by_teacherEmailId',
        teacheremailid: EmailID,
        birthplace: TeacherBirth,
        motherbirthplace: motherB,
        motherfatherbirthplace: gfm,
        mothermotherbirthplace: gmm,
        fatherbirthplace: fatherB,
        fatherfatherbirthplace: gff,
        fathermotherbirthplace: gmf
    }, Teacher.Update.CheckResult)
};
Teacher.Update.AgeGroup = function () {
    var ageGp = document.getElementById('age');
    var ageID = ageGp.getAttribute('data-age');
    ageGp = ageGp.value;
    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'edit_teacher_age_group_by_id',
        id: ageID,
        age: ageGp
    }, Teacher.Update.CheckResult);
};
Teacher.Update.LanguageDetails = function () {
    var Langs = document.getElementsByClassName('PSCO_employee_language');
    var Levels = document.getElementsByClassName('PSCO_employee_language_level');
    var Language = [];
    var id, lang, level;
    var i = 0;
    var Loop = function () {
        if (i < Langs.length) {
            setTimeout(function () {
                id = Langs[i].getAttribute('data-LangID');
                lang = Langs[i].value;
                level = Levels[i].value;

                ajax.sender_data_json_by_url_callback(Global.url, {
                    act: 'edit_teacher_lang_bylangId',
                    id: id, languagename: lang, languagelevel: level
                }, Teacher.Update.CheckResult);
                i++;
                Loop();
            }, 80);
        }
    };
    Loop();
    /*for (var i = 0; i < Langs.length; i++) {
     id = Langs[i].getAttribute('data-LangID');
     lang = Langs[i].value;
     level = Levels[i].value;

     ajax.sender_data_json_by_url_callback(Global.url, {
     act: 'edit_teacher_lang_bylangId',
     id: id, languagename: lang, languagelevel: level
     }, Teacher.Update.CheckResult);
     }*/

};
Teacher.Update.AddLanguage = function () {
    var EmailID = document.getElementById('Teacheremail').value;
    var Languages = document.querySelectorAll('select[data-addedLang=true]');
    var Levels = document.querySelectorAll('select[data-addedLevel=true]');
    var LangValue, LevelValue;
    var i = 0;
    var Loop = function () {
        if (i < Languages.length) {
            setTimeout(function () {
                LangValue = Languages[i].value;
                LevelValue = Levels[i].value;
                if (LangValue != '' && LevelValue != '' && LangValue != undefined && LevelValue != undefined) {
                    ajax.sender_data_json_by_url_callback(Global.url, {
                        act: 'set_teacher_lang_bylangId',
                        teacheremailid: EmailID, languagename: LangValue, languagelevel: LevelValue
                    }, console.log);
                }

                i++;
                Loop();
            }, 80);
        }
    };
    Loop();

};

Teacher.Update.Update = function () {
    Teacher.Update.Result = [];
    Teacher.Update.PersonalDetails();
    Teacher.Update.BrithDetails();
    Teacher.Update.AgeGroup();
    Teacher.Update.LanguageDetails();
    Teacher.Update.AddLanguage();
};
Teacher.Update.CheckResult = function (Data) {
    if (Data.data == true) {
        Teacher.Update.Result.push(true);
    } else {
        Teacher.Update.Result.push(false);
    }
    if (Teacher.Update.Result.length == 4) {
        var result = true;
        for (var i = 0; i < 4; i++) {
            if (!Teacher.Update.Result[i]) {
                result = false;
                break;
            }
        }
        Global.ResultMessage(result);
    }
};

Teacher.invite = function(){

    var email = $("#EmailInvite").val();
    var classname = $("#classInvite").val();
    var name = $("#NameInvite").val();
    var constraints = {from: {email: true}};
    if (validate({from: email}, constraints) != undefined) {
        message.show(__lang.translate("teacher email is not valid"),__lang.translate("Error"));
        return;
    }

    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'invite_teecher',
        invite : true ,
        name: name,
        email : email,
        classname : classname


    }, class_data.add_new_class.result);

    $("#EmailInvite").val("")
    $("#classInvite").val("");;
    $("#NameInvite").val("");
}
Teacher.invite.result = function(data){}



/*Key Facts*/
var KeyFacts = {};

KeyFacts.LoadKeyFact = function () {
    ajax.sender_data_json_by_url_callback(Global.url, {act: 'get_key_fact_json'}, KeyFacts.createKeyFact);
};

KeyFacts.createKeyFact = function (Data) {
    document.getElementById('Keyfact').innerHTML = Data.data;
};


/*Admin Profile*/
Teacher.AdminProfile.ShowProfile = function () {
    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'get_school_profile_by_adminemailid',
        adminemailid: GlobalFunc.userDetials.adminemailid
    }, Teacher.AdminProfile.setData);
};
Teacher.AdminProfile.btn_user_profile_edit = function () {
    var btn_edit = $('#btn_profile_edit');
    if (btn_edit.attr('name') == 'edit') {
        $('.psco_readonly').prop('readonly', false);
        $('#SchoolName').prop('disabled', false);
        $('.PSCO_country').prop('disabled', false);
        btn_edit.html('Save');
        btn_edit.attr('name', 'save');
        $('#user_profile_header').html('Edit user profile');
    } else {
        Teacher.AdminProfile.Update();
        $('.psco_readonly').prop('readonly', true);
        $('#SchoolName').prop('disabled', true);
        $('.PSCO_country').prop('disabled', true);
        $('.PSCO_language').prop('disabled', true);
        $('.PSCO_language_level').prop('disabled', true);
        btn_edit.html('Edit');
        btn_edit.attr('name', 'edit');
        $('#user_profile_header').html('User profile');
    }
};
Teacher.AdminProfile.Update = function () {
    var adminemailid = document.getElementById('Adminemail').value;
    var firstname = document.getElementById('Adminfirstname').value;
    var lastname = document.getElementById('Adminlasttname').value;

    var country = document.getElementById('Admincountry').value;
    var city = document.getElementById('Admincity').value;
    var state = document.getElementById('Adminstate').value;
    var suburb = document.getElementById('Adminsuburb').value;
    var postcode = document.getElementById('Adminpostcode').value;
    var schoolid = document.getElementById('AdminSchoolID').value;
    var SchoolName = document.getElementById('SchoolName').value;
    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'edit_school_profile_by_adminemailid',
        schoolid: schoolid,
        postcode: postcode,
        suburb: suburb,
        state: state,
        city: city,
        country: country,
        lastname: lastname,
        firstname: firstname,
        adminemailid: adminemailid,
        schoolname: SchoolName
    })
};
Teacher.AdminProfile.ChangePass = function () {

};
// ____ set Admin Data in profile inputs
Teacher.AdminProfile.setData = function (Data) {
    Data = Data[0];
    //______ if country is australia ---> create select Tag and fill australia School from dataValue folder
    var schoolTD = document.getElementById('schoolNameTd');
    schoolTD.innerHTML = '';
    if (Data.country.toLowerCase() == 'australia') {
        var selectTag = document.createElement('select');
        selectTag.setAttribute('id', 'SchoolName');
        selectTag.setAttribute('class', 'form-control');
        selectTag.setAttribute('disabled', 'true');
        schoolTD.appendChild(selectTag);
        setTimeout(function () {
            $('#SchoolName').load('../data_value/AustraliaSchool.html', function () {
                $('#SchoolName').val(Data.schoolname);
            });
        }, 200);
    } else { //if not australia ----> create input Text
        var input = document.createElement('input');
        input.setAttribute('class', 'psco_readonly form-control');
        input.setAttribute('type', 'text');
        input.setAttribute('placeholder', 'School Name');
        input.setAttribute('readonly', 'true');
        input.setAttribute('id', 'SchoolName');
        input.value = Data.schoolname;
        schoolTD.appendChild(input);
    }

    document.getElementById('Adminemail').value = Data.adminemailid;
    document.getElementById('Adminfirstname').value = Data.firstname;
    document.getElementById('Adminlasttname').value = Data.lastname;

    document.getElementById('Admincountry').value = Data.country;
    document.getElementById('Admincity').value = Data.city;
    document.getElementById('Adminstate').value = Data.state;
    document.getElementById('Adminsuburb').value = Data.suburb;
    document.getElementById('Adminpostcode').value = Data.postcode;
    document.getElementById('AdminSchoolID').value = Data.schoolid;
    showModal('modal_Admin_profile');

    /*    setTimeout(function () {


     $('#frm_edit_user_age').val('30-35');

     $('#edit_profile_language0').val('English');
     $('#edit_profile_language_level0').val('advanced');

     $('#edit_profile_language1').val('Greek');
     $('#edit_profile_language_level1').val('intermediate');

     $('#edit_profile_language2').val('Italian');
     $('#edit_profile_language_level2').val('basic');

     $('#profile_country_self').val('Australia');
     $('#profile_country_Mother').val('Greece');
     $('#profile_country_Mother_Grandfather').val('Turkey');
     $('#profile_country_Father').val('Greece');
     $('#profile_country_Father_Grandfather').val('Turkey');
     $('#profile_country_Father_GrandMother').val('Greece');

     }, 3000);*/
};


//____________add className
var class_data = {};

class_data.add_new_class = function(){
    var classname = $('#classNameAdd').val();
    if(classname == "" || classname == undefined || classname == null){
        message.show(__lang.translate("please Enter class name"),__lang.translate("Error"));
        return;
    }
    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'set_class_by_schoolId',
        name: classname
    }, class_data.add_new_class.result);

    $('#classNameAdd').val("");
<<<<<<< HEAD
};
class_data.add_new_class.result = function(data){};

=======
}
class_data.add_new_class.result = function(data){};





>>>>>>> e1239fba462841e40c4d47613dc439a92857dc5d

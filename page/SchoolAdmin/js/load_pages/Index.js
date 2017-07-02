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

Global.RefreshGrid = function (ContainerID, param, url, callBack) { //----> send reQuest with this func and then refresh Grid ajax
    document.getElementById(ContainerID).innerHTML = '';
    ajax.sender_data_json_by_url_callback(url, param, callBack);
};
Global.RemoveRepeate =function(originalArray, prop) {
    var objInArray = [];
    for(var a = 0 ; a < originalArray.length ; a++){
        objInArray.push(originalArray[a]);
    }
    originalArray = objInArray;
    var newArray = [];
    var lookupObject  = {};

    for(var i in originalArray) {
        lookupObject[originalArray[i][prop]] = originalArray[i];
    }

    for(i in lookupObject) {
        newArray.push(lookupObject[i]);
    }
    return newArray;
};

/*Add Language*/

var Profile = {
    LangCounter: 0,
    CanAdd: true, //----> for one language add
    deletedTrid: undefined,
    currentTableId: undefined // ---- > save Id off current modal LanguageTable
};



/* AddLanguage View */
Profile.Addlanguage = function (TableID) {
    /*if (Profile.CanAdd) {*/
    Profile.currentTableId = TableID;
    var Tbody = document.querySelector('#' + TableID + ' > tbody');

    var tr = document.createElement('tr');
    tr.setAttribute('id', 'langtr' + Profile.LangCounter);
    tr.setAttribute('class', 'newLang');

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
    DeleteTrBtn.setAttribute('class', 'btn Anim-toptoleft btn-danger');

    Langselect.setAttribute('id', 'LangSelect' + Profile.LangCounter);
    Levelselect.setAttribute('id', 'LevelSelect' + Profile.LangCounter);
    Langselect.setAttribute('class', 'Anim-toptoleft form-control');
    Levelselect.setAttribute('class', 'Anim-toptoleft form-control');
    /*Langselect.setAttribute('data-addedLang', 'true'); //---> for select added select Tag in update function
     Levelselect.setAttribute('data-addedLevel', 'true'); //---> for select added select Tag in update function*/
    //DeleteTrBtn.innerText = 'Delete This';
    DeleteTrBtn.innerHTML = '<i class="glyphicon glyphicon-minus"></i>'; //----> add delete New Row btn
    DeleteTrBtn.setAttribute('onclick', "DeleteTr('langtr" + Profile.LangCounter + "')");


    var AddlanguageBTN = document.getElementById('AddlanguageBTN'); // --- > get Add BTN
    AddlanguageBTN.setAttribute('class', 'Anim-toptoleft btn btn-primary');
    // ______ AppendChild
    Langselect.appendChild(langoption);
    Levelselect.appendChild(leveloption);
    Langtd.appendChild(Langselect);
    Leveltd.appendChild(Levelselect);
    DeleteTd.appendChild(DeleteTrBtn);

    DeleteTd.appendChild(AddlanguageBTN); //-----> cut addBtn in last Row

    tr.appendChild(Langtd);
    tr.appendChild(Leveltd);
    tr.appendChild(DeleteTd);

    Tbody.appendChild(tr);
    setTimeout(function () {
        $('#LangSelect' + Profile.LangCounter).load('page/data_value/lanuage.html');
        $('#LevelSelect' + Profile.LangCounter).load('page/data_value/lanuage_level.html');
        Profile.LangCounter++;
    }, 200);

    /*var AddlanguageBTN = document.getElementById('AddlanguageBTN');
     AddlanguageBTN.innerText = 'Save this language';
     AddlanguageBTN.setAttribute('onclick', 'Profile.SaveLang()');
     AddlanguageBTN.setAttribute('class', 'btn btn-block btn-success');
     Profile.isrRegisetrNewLang = false;*/
    /*}*/

};

//____ create All language select in profile after save one new language

Profile.getAllLang = function (Data) {
    var langtd, leveltd, btntd, tr, langselect, levelSelect, tbody, btn;
    var Table = document.querySelector('#' + Profile.currentTableId);
    Table.innerHTML = '';
    tbody = document.createElement('tbody');
    for (var i = 0; i < Data.length; i++) {
        tr = document.createElement('tr');

        langtd = document.createElement('td');
        leveltd = document.createElement('td');
        /*  btntd = document.createElement('td');*/

        langselect = document.createElement('select');
        levelSelect = document.createElement('select');
        /*btn = document.createElement('div');
         */
        langselect.setAttribute('class', 'PSCO_language form-control');
        levelSelect.setAttribute('class', 'PSCO_language_level form-control');

        langselect.setAttribute('name', 'lang_' + Data[i].id);
        levelSelect.setAttribute('name', 'langlevel_' + Data[i].id);

        langselect.setAttribute('id', 'lang_' + Data[i].id);
        levelSelect.setAttribute('id', 'langlevel_' + Data[i].id);

        /*btn.setAttribute('class', 'btn btn-block btn-danger');
         btn.setAttribute('onclick', 'DeleteLanguage(this)');
         btn.innerText = 'Delete language';
         */
        langtd.appendChild(langselect);
        leveltd.appendChild(levelSelect);
        //btntd.appendChild(btn);

        tr.appendChild(langtd);
        tr.appendChild(leveltd);
        //tr.appendChild(btntd);

        tbody.appendChild(tr);
    }
    Table.appendChild(tbody);
    Profile.CreateAdd(Profile.currentTableId);
    Profile.setAddLang();
    setTimeout(function () {
        //_____ loade countries and levels
        $('.PSCO_language').load('page/data_value/lanuage.html');
        $('.PSCO_language_level').load('page/data_value/lanuage_level.html');
        setTimeout(function () {
            // ___ fill Country
            var i = 0;
            var fillcountry = function () {
                if (i < Data.length) {
                    setTimeout(function () {
                        document.getElementById('lang_' + Data[i].id).value = Data[i].languagename;
                        i++;
                        fillcountry();
                    }, 20);
                }
            };
            fillcountry();
        }, 1000);
        setTimeout(function () {
            // ___ fill level
            var a = 0;
            var fillLevel = function () {
                if (a < Data.length) {
                    setTimeout(function () {
                        document.getElementById('langlevel_' + Data[a].id).value = Data[a].languagelevel;
                        a++;
                        fillLevel();
                    }, 30);
                }
            };
            fillLevel();
        }, 1000)
    }, 700);
};

function DeleteLanguage(DeleteBtn) {
    Profile.deletedTrid = DeleteBtn.parentElement.parentElement; //---> tr deleted
    var LanguageID = Profile.deletedTrid.children[0].children[0];
    LanguageID = LanguageID.name; //-----> get name of select tag from
    LanguageID = LanguageID.split('_');
    LanguageID = LanguageID[1];
    var emailID;
    if (Profile.currentTableId == 'employee_lang_edit_profile') {
        emailID = 'studentemail'
    } else {
        emailID = 'emailId';
    }

    var email = document.getElementById(emailID).value;
    email = email.toLowerCase();
    if (Profile.currentTableId == 'employee_lang_edit_profile') { //--- > delete student language
        ajax.sender_data_json_by_url_callback(Profile.Url, {
            act: 'delete_student_language',
            id: LanguageID,
            studentemailid: email
        }, console.log);
    }
    else {
        ajax.sender_data_json_by_url_callback(Profile.Url, { //--- > delete teacher language
            act: 'delete_teacher_language',
            id: LanguageID,
            teacheremailid: email
        }, console.log);

    }
    var tr = Profile.deletedTrid;
    tr.style.display = 'none';
    //Profile.setAddLang();


    var Tbody = document.querySelector('#' + Profile.currentTableId + '> tbody');

    // _____ check if this tr is last add btn then cut add btn in last row - 1
    if (Tbody.children[Tbody.childElementCount - 1].style.display == 'none') {
        var addBtn = document.getElementById('AddlanguageBTN');
        Tbody.children[Tbody.childElementCount - 2].lastChild.appendChild(addBtn);
    }
    tr.parentNode.removeChild(tr);
}

Profile.SaveLang = function () {
    /* var lang = document.getElementById('LangSelect' + (Profile.LangCounter - 1)).value;
     var level = document.getElementById('LevelSelect' + (Profile.LangCounter - 1)).value;*/
    var NewLang, NewLevel, i;
    var lang = [];
    var level = [];
    var newLangTrs = document.getElementsByClassName('newLang');
    for (i = 0; i < newLangTrs.length; i++) {
        NewLang = newLangTrs[i].children[0].children[0];
        NewLevel = newLangTrs[i].children[1].children[0];
        if (NewLang.value != '' && NewLevel.value != '') {
            lang.push(NewLang.value);
            level.push(NewLevel.value);
        }
    }
    var emailID;
    if (Profile.currentTableId == 'employee_lang_edit_profile') {
        emailID = 'studentemail';
    } else {

        emailID = 'emailId';

    }
    var email = document.getElementById(emailID).value;
    email = email.toLowerCase();

    i = 0;
    var SendNewLang = function () {
        if (i < lang.length) {
            setTimeout(function () {
                if (Profile.currentTableId == 'employee_lang_edit_profile') {
                    ajax.sender_data_json_by_url_callback(Profile.Url, {
                        act: 'set_student_language',
                        languagename: lang[i],
                        languagelevel: level[i],
                        studentemailid: email
                    }, console.log);


                } else {
                    ajax.sender_data_json_by_url_callback(Profile.Url, {
                        act: 'set_teacher_language',
                        languagename: lang[i],
                        languagelevel: level[i],
                        teacheremailid: email
                    }, console.log);

                }
                // _____ submit form if all Language sent
                if (i == lang.length - 1) {
                    if (Profile.currentTableId == 'employee_lang_edit_profile') {
                        document.getElementById('update_form').submit();
                    } else {
                        document.getElementById('frm_edit_user').submit();
                    }
                }
                i++;
                SendNewLang();
            }, 2000)
        }
    };
    if(lang.length == 0){
        if (Profile.currentTableId == 'employee_lang_edit_profile') {
            document.getElementById('update_form').submit();
        } else {
            document.getElementById('frm_edit_user').submit();
        }
    }else {
        SendNewLang();
    }
    /*if (lang != 'Select One' && level != 'Select One') {
     if (Profile.currentTableId == 'employee_lang_edit_profile') {
     ajax.sender_data_json_by_url_callback(Profile.Url, {
     act: 'set_student_language',
     languagename: lang,
     languagelevel: level,
     studentemailid: email
     }, Profile.getAllLang)
     } else {
     ajax.sender_data_json_by_url_callback(Profile.Url, {
     act: 'set_teacher_language',
     languagename: lang,
     languagelevel: level,
     teacheremailid: email
     }, Profile.getAllLang)
     }
     }*/
};

// ____ reset addLanguage when open profileModal

Profile.ResetAdd = function () {
    var Addedtr, i, DeleteTd;
    var deleteBtn = document.getElementsByClassName('glyphicon-minus');
    //_______ Delete td of delete BTN
    for (i = 0; i < deleteBtn.length; i++) {
        DeleteTd = deleteBtn[i].parentNode.parentNode;
        DeleteTd.parentNode.removeChild(DeleteTd);
    }
    for (i = 0; i < Profile.LangCounter; i++) {
        Addedtr = document.getElementById('langtr' + i);
        try {
            Addedtr.parentNode.removeChild(Addedtr); ///---remove tr
        } catch (e) {
        }
    }

    var addBtn = document.getElementById('AddlanguageBTN');
    try {
        addBtn.parentNode.removeChild(addBtn); /// --- remove add btn
    } catch (e) {
    }
    Profile.currentTableId = undefined;
    // Profile.CanAdd = true;
    Profile.LangCounter = 0;
};

function DeleteTr(id) {
    var tr = document.getElementById(id);
    tr.style.display = 'none';
    //Profile.setAddLang();


    var Tbody = document.querySelector('#' + Profile.currentTableId + '> tbody');

    // _____ check if this tr is last add btn then cut add btn in last row - 1
    if (Tbody.children[Tbody.childElementCount - 1].style.display == 'none') {
        var addBtn = document.getElementById('AddlanguageBTN');
        Tbody.children[Tbody.childElementCount - 2].lastChild.appendChild(addBtn);
    }
    tr.parentNode.removeChild(tr);
}

Profile.CreateAdd = function (TableId) {
/*    if (Profile.currentTableId == 'edit_data_Modal') { // --->disable Editable Teacher Profile
        DisableTeacherProfile();
    }*/
    // reset AddLanguage
    Profile.ResetAdd();
    //_______ create Delete Language Btn
    Profile.currentTableId = TableId;
    var Tbody = document.querySelector('#' + TableId + ' > tbody');
    if (Tbody != null) {
        for (var i = 0; i < Tbody.childElementCount; i++) {
            var deletetd = document.createElement('td');
            var deletebtn = document.createElement('div');
            deletebtn.setAttribute('onclick', 'DeleteLanguage(this)');
            deletebtn.setAttribute('class', 'btn btn-danger');
            //deletebtn.innerText = 'Delete language';
            deletebtn.innerHTML = '<i class="glyphicon glyphicon-minus"></i>';
            deletetd.appendChild(deletebtn);
            var last_td = Tbody.childElementCount - 1;
            if (Profile.currentTableId != 'employee_lang') {
                last_td = Tbody.childElementCount - 2;
            }
            if (i == last_td) {
                var AddBTN = document.createElement('div');
                AddBTN.setAttribute('class', 'btn btn-primary');
                AddBTN.setAttribute('id', 'AddlanguageBTN');
                AddBTN.setAttribute('onclick', "Profile.Addlanguage('" + TableId + "')");
                AddBTN.style.marginLeft = '5px';
                AddBTN.innerHTML = '<i class="glyphicon glyphicon-plus"></i>';
                deletetd.appendChild(AddBTN);
            }
            Tbody.children[i].appendChild(deletetd);
        }
    } else {
        Tbody = document.createElement('tbody');
        var table = document.getElementById(TableId);
        table.appendChild(Tbody);
    }
    /*    // create add language
     var tfoot = document.createElement('tfoot');
     var tr = document.createElement('tr');
     var td = document.createElement('td');
     td.setAttribute('colspan', '3');
     var btn = document.createElement('div');
     btn.setAttribute('class', 'btn btn-primary btn-block');
     btn.setAttribute('onclick', "Profile.Addlanguage('" + TableId + "')");
     btn.setAttribute('id', 'AddlanguageBTN');
     btn.innerText = 'Add Language';
     // append Child
     td.appendChild(btn);
     tr.appendChild(td);
     tfoot.appendChild(tr);
     document.getElementById(TableId).appendChild(tfoot);*/
};




/*End Add Language*/

function set_invite_class_name(data) {
    var opt = '';//'<optgroup label="Class name"></optgroup>';
    for (var i = 0; i < data.length; i++) {
        opt += '<option value="' + data[i].classname + '">' + data[i].classname + '</option>';
    }
    $("#classnameInvite").html(opt);
}

Global.setData = function (Data, gridName) {
    gridName.data = Data;
    gridName.render();
    //peyman
    /*    ajax.sender_data_json_by_url_callback(Global.url, {
     act: 'get_tbl_classes'
     }, set_invite_class_name);*/
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
    AdminProfile: {
        isAustralia: false
    },
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
        if (data[i].name != null) {
            Rows['name'] = data[i].name;
        } else {
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
                htmlTag: '<i class="glyphicon glyphicon-remove actionIcon" onclick="Confirm(' + "'" + data[i].teacheremailid + '||' + data[i].classname + "'" + ')"></i>'
            };
        } else {
            Rows['info'] = 'Waiting approval';
            Rows['option'] = {
                value: '',
                htmlTag: '<i class="glyphicon glyphicon-remove actionIcon" onclick="Confirm(' + "'" + data[i].teacheremailid + '||' + data[i].classname + "'" + ')"></i>'
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
        classname: data[1]
    }, console.log);
    ///// refresh grid after delete Row
    Global.RefreshGrid('PGrid', {act: 'get_tbl_teachers'}, Global.url, Teacher.CreateTeacherTblData)
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
        Profile.CreateAdd('employee_lang'); //____ Create Add Button
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

/*
function DeleteTr(id) {
    var tr = document.getElementById(id);
    tr.parentNode.removeChild(tr);
}
*/

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

Teacher.invite = function () {

    var email = $("#EmailInvite").val();
    var classname = $("#classInvite").val();
    var name = $("#NameInvite").val();
    var constraints = {from: {email: true}};
    if (validate({from: email}, constraints) != undefined) {
        message.show(__lang.translate("teacher email is not valid"), __lang.translate("Error"));
        return;
    }

    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'invite_teecher',
        invite: true,
        name: name,
        email: email,
        classname: classname


    }, class_data.add_new_class.result);

    $("#EmailInvite").val("")
    $("#classInvite").val("");
    ;
    $("#NameInvite").val("");
}
Teacher.invite.result = function (data) {
}


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
    var input = document.createElement('input');
    input.setAttribute('class', 'psco_readonly form-control');
    input.setAttribute('id', 'SchoolName');
try {
    if (Data.country.toLowerCase() == 'australia') {
        /*        var selectTag = document.createElement('select');
         selectTag.setAttribute('id', 'SchoolName');
         selectTag.setAttribute('class', 'form-control');
         selectTag.setAttribute('disabled', 'true');
         schoolTD.appendChild(selectTag);
         setTimeout(function () {
         $('#SchoolName').load('../data_value/AustraliaSchool.html', function () {
         $('#SchoolName').val(Data.schoolname);
         });
         }, 200);*/
        input.setAttribute('list', 'SchoolList');
        var List = document.createElement('datalist');
        List.setAttribute('id', 'SchoolList');
        schoolTD.appendChild(List);
        ajax.sender_data_json_by_url_callback(Global.url, {act: 'get_australia_school'}, Teacher.AdminProfile.FillSchools);
        Teacher.AdminProfile.isAustralia = true;

    } else { //if not australia ----> create input Text
        input.setAttribute('type', 'text');
    }
}catch (e){}
    input.setAttribute('placeholder', 'School Name');
    input.setAttribute('readonly', 'true');
    schoolTD.appendChild(input);
    input.value = Data.schoolname;

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
//----> if country change to australia school name change to list else change to text
Teacher.AdminProfile.ChangeCountry = function (elem){
    var List;
    var schoolName = document.getElementById('SchoolName');
    if (elem.value.toLowerCase() == 'australia') {
        var SchoolTd = schoolName.parentNode;
        /*
         SchoolTd.removeChild(schoolName);
         var select = document.createElement('select');
         select.setAttribute('id' , )*/
        schoolName.setAttribute('type', '');
        schoolName.setAttribute('list', 'SchoolList');
        List = document.createElement('datalist');
        List.setAttribute('id', 'SchoolList');
        SchoolTd.appendChild(List);
        Teacher.AdminProfile.isAustralia = true;
        ajax.sender_data_json_by_url_callback(Global.url , {act:'get_australia_school'} , Teacher.AdminProfile.FillSchools);
    }else{
        if(Teacher.AdminProfile.isAustralia){ //--- if past country is australia change input type
            List = document.getElementById('SchoolList');
            List.parentNode.removeChild(List);
            schoolName.setAttribute('type' , 'text');
            schoolName.setAttribute('list' , '');
            Teacher.AdminProfile.isAustralia = false;
        }
    }
};
// ----> get australia SchoolName List
Teacher.AdminProfile.FillSchools = function(Data){
  var options = '';
  for(var i = 0 ; i < Data.length ; i++){
      options += '<option value="'+Data[i].schoolname+'">'+Data[i].schoolname+'</option>';
  }
  document.getElementById('SchoolList').innerHTML = options;
};

//____________add className
var class_data = {};

class_data.add_new_class = function () {
    var classname = $('#classNameAdd').val();
    if (classname == "" || classname == undefined || classname == null) {
        message.show(__lang.translate("please Enter class name"), __lang.translate("Error"));
        return;
    }
    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'set_class_by_schoolId',
        name: classname
    }, class_data.add_new_class.result);

    $('#classNameAdd').val("");
};
class_data.add_new_class.result = function (data) {
};


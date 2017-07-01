<<<<<<< HEAD
<<<<<<< HEAD
var Profile = {
    Url: '/backend/controller_teacher_admin.php',
    LangCounter: 0,
    CanAdd: true, //----> for one language add
    deletedTrid: undefined,
    currentTableId: undefined // ---- > save Id off current modal LanguageTable
};

/*AddLanguage View*/
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
Profile.setAddLang = function () {
    /*  var AddlanguageBTN = document.getElementById('AddlanguageBTN');
     AddlanguageBTN.innerText = 'Add Language';
     AddlanguageBTN.setAttribute('class', 'btn btn-block btn-primary');
     AddlanguageBTN.setAttribute('onclick', "Profile.Addlanguage('" + Profile.currentTableId + "')");
     */  //Profile.CanAdd = true;
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
/*function hideDeletedTr() {
 Profile.deletedTrid.style.display = 'none';
 }*/
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
    if (Profile.currentTableId == 'employee_lang') { // --->disable Editable Teacher Profile
        DisableTeacherProfile();
    }
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
function DisableTeacherProfile() {
    var btn_edit = $('#btn_profile_edit');
    $('.psco_readonly').prop('readonly', true);
    $('#frm_edit_user_gender').prop('disabled', true);
    $('#frm_edit_user_department').prop('disabled', true);
    $('#frm_edit_user_religion').prop('disabled', true);
    $('#frm_edit_user_age').prop('disabled', true);
    $('.PSCO_country').prop('disabled', true);
    $('.PSCO_language').prop('disabled', true);
    $('.PSCO_language_level').prop('disabled', true);
    btn_edit.html('Edit');
    btn_edit.attr('name', 'edit');
    $('#user_profile_header').html('User profile');
}

/*
function sendLanguage(lang, level, email, act, student) {
    var paramName;
    if(student == null){
        paramName = 'teacheremailid';
    }
    else{
        paramName = 'studentemailid';
    }
    var xhttp = new XMLHttpRequest();
    if (window.XMLHttpRequest) {
        // code for modern browsers
        xhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //document.getElementById("demo").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", Profile.Url, true);
    xhttp.setRequestHeader("languagename", lang);
    xhttp.setRequestHeader("languagelevel", level);
    xhttp.setRequestHeader(paramName, email);
    xhttp.setRequestHeader("act", act);
    xhttp.send("");
}
*/
=======
var Profile = {
    Url: '/backend/controller_teacher_admin.php',
    LangCounter: 0,
    CanAdd: true, //----> for one language add
    deletedTrid: undefined,
    currentTableId: undefined // ---- > save Id off current modal LanguageTable
};

/*AddLanguage View*/
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
Profile.setAddLang = function () {
    /*  var AddlanguageBTN = document.getElementById('AddlanguageBTN');
     AddlanguageBTN.innerText = 'Add Language';
     AddlanguageBTN.setAttribute('class', 'btn btn-block btn-primary');
     AddlanguageBTN.setAttribute('onclick', "Profile.Addlanguage('" + Profile.currentTableId + "')");
     */  //Profile.CanAdd = true;
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
/*function hideDeletedTr() {
 Profile.deletedTrid.style.display = 'none';
 }*/
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
    if (Profile.currentTableId == 'employee_lang') { // --->disable Editable Teacher Profile
        DisableTeacherProfile();
    }
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
function DisableTeacherProfile() {
    var btn_edit = $('#btn_profile_edit');
    $('.psco_readonly').prop('readonly', true);
    $('#frm_edit_user_gender').prop('disabled', true);
    $('#frm_edit_user_department').prop('disabled', true);
    $('#frm_edit_user_religion').prop('disabled', true);
    $('#frm_edit_user_age').prop('disabled', true);
    $('.PSCO_country').prop('disabled', true);
    $('.PSCO_language').prop('disabled', true);
    $('.PSCO_language_level').prop('disabled', true);
    btn_edit.html('Edit');
    btn_edit.attr('name', 'edit');
    $('#user_profile_header').html('User profile');
}

/*
function sendLanguage(lang, level, email, act, student) {
    var paramName;
    if(student == null){
        paramName = 'teacheremailid';
    }
    else{
        paramName = 'studentemailid';
    }
    var xhttp = new XMLHttpRequest();
    if (window.XMLHttpRequest) {
        // code for modern browsers
        xhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //document.getElementById("demo").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", Profile.Url, true);
    xhttp.setRequestHeader("languagename", lang);
    xhttp.setRequestHeader("languagelevel", level);
    xhttp.setRequestHeader(paramName, email);
    xhttp.setRequestHeader("act", act);
    xhttp.send("");
}
*/
>>>>>>> e1239fba462841e40c4d47613dc439a92857dc5d
=======
var Profile = {
    Url: '/backend/controller_teacher_admin.php',
    LangCounter: 0,
    CanAdd: true, //----> for one language add
    deletedTrid: undefined,
    currentTableId: undefined // ---- > save Id off current modal LanguageTable
};

/*AddLanguage View*/
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
Profile.setAddLang = function () {
    /*  var AddlanguageBTN = document.getElementById('AddlanguageBTN');
     AddlanguageBTN.innerText = 'Add Language';
     AddlanguageBTN.setAttribute('class', 'btn btn-block btn-primary');
     AddlanguageBTN.setAttribute('onclick', "Profile.Addlanguage('" + Profile.currentTableId + "')");
     */  //Profile.CanAdd = true;
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
/*function hideDeletedTr() {
 Profile.deletedTrid.style.display = 'none';
 }*/
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
    if (Profile.currentTableId == 'employee_lang') { // --->disable Editable Teacher Profile
        DisableTeacherProfile();
    }
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
function DisableTeacherProfile() {
    var btn_edit = $('#btn_profile_edit');
    $('.psco_readonly').prop('readonly', true);
    $('#frm_edit_user_gender').prop('disabled', true);
    $('#frm_edit_user_department').prop('disabled', true);
    $('#frm_edit_user_religion').prop('disabled', true);
    $('#frm_edit_user_age').prop('disabled', true);
    $('.PSCO_country').prop('disabled', true);
    $('.PSCO_language').prop('disabled', true);
    $('.PSCO_language_level').prop('disabled', true);
    btn_edit.html('Edit');
    btn_edit.attr('name', 'edit');
    $('#user_profile_header').html('User profile');
}

/*
function sendLanguage(lang, level, email, act, student) {
    var paramName;
    if(student == null){
        paramName = 'teacheremailid';
    }
    else{
        paramName = 'studentemailid';
    }
    var xhttp = new XMLHttpRequest();
    if (window.XMLHttpRequest) {
        // code for modern browsers
        xhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //document.getElementById("demo").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", Profile.Url, true);
    xhttp.setRequestHeader("languagename", lang);
    xhttp.setRequestHeader("languagelevel", level);
    xhttp.setRequestHeader(paramName, email);
    xhttp.setRequestHeader("act", act);
    xhttp.send("");
}
*/
>>>>>>> e1239fba462841e40c4d47613dc439a92857dc5d

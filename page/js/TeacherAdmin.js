<<<<<<< HEAD
var Profile = {
    Url: '/backend/controller_teacher_admin.php',
    LangCounter: 0,
    CanAdd: true,
    deletedTrid: undefined
};

/*AddLanguage View*/
Profile.Addlanguage = function () {
    if (Profile.CanAdd) {
        var Tbody = document.querySelector('#employee_lang > tbody');

        var tr = document.createElement('tr');
        tr.setAttribute('id', 'langtr' + Profile.LangCounter);

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

        Langselect.setAttribute('id', 'LangSelect' + Profile.LangCounter);
        Levelselect.setAttribute('id', 'LevelSelect' + Profile.LangCounter);
        Langselect.setAttribute('class', 'Anim-toptoleft form-control');
        Levelselect.setAttribute('class', 'Anim-toptoleft form-control');
        Langselect.setAttribute('data-addedLang', 'true'); //---> for select added select Tag in update function
        Levelselect.setAttribute('data-addedLevel', 'true'); //---> for select added select Tag in update function
        DeleteTrBtn.innerText = 'Delete This';
        DeleteTrBtn.setAttribute('onclick', "DeleteTr('langtr" + Profile.LangCounter + "')");

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
            $('#LangSelect' + Profile.LangCounter).load('page/data_value/lanuage.html');
            $('#LevelSelect' + Profile.LangCounter).load('page/data_value/lanuage_level.html');
            Profile.LangCounter++;
        }, 200);
        var AddlanguageBTN = document.getElementById('AddlanguageBTN');
        AddlanguageBTN.innerText = 'Save this language';
        AddlanguageBTN.setAttribute('onclick', 'Profile.SaveLang()');
        AddlanguageBTN.setAttribute('class', 'btn btn-block btn-success');
        Profile.isrRegisetrNewLang = false;
    }

};
Profile.setAddLang = function () {
    var AddlanguageBTN = document.getElementById('AddlanguageBTN');
    AddlanguageBTN.innerText = 'Add Language';
    AddlanguageBTN.setAttribute('class', 'btn btn-block btn-primary');
    AddlanguageBTN.setAttribute('onclick', 'Profile.Addlanguage()');
    Profile.CanAdd = true;
};
//____ create All language select in profile after save one new language
Profile.getAllLang = function (Data) {
    var langtd, leveltd, btntd, tr, langselect, levelSelect, btn;
    var Table = document.querySelector('#employee_lang > tbody');
    Table.innerHTML = '';
    for (var i = 0; i < Data.length; i++) {
        tr = document.createElement('tr');

        langtd = document.createElement('td');
        leveltd = document.createElement('td');
        btntd = document.createElement('td');

        langselect = document.createElement('select');
        levelSelect = document.createElement('select');
        btn = document.createElement('div');

        langselect.setAttribute('class', 'PSCO_language form-control');
        levelSelect.setAttribute('class', 'PSCO_language_level form-control');

        langselect.setAttribute('name', 'lang_' + Data[i].id);
        levelSelect.setAttribute('name', 'langlevel_' + Data[i].id);

        langselect.setAttribute('id', 'lang_' + Data[i].id);
        levelSelect.setAttribute('id', 'langlevel_' + Data[i].id);

        btn.setAttribute('class', 'btn btn-block btn-danger');
        btn.setAttribute('onclick', 'DeleteLanguage(this)');
        btn.innerText = 'Delete language';

        langtd.appendChild(langselect);
        leveltd.appendChild(levelSelect);
        btntd.appendChild(btn);

        tr.appendChild(langtd);
        tr.appendChild(leveltd);
        tr.appendChild(btntd);

        Table.appendChild(tr);
    }
    Profile.setAddLang();
    setTimeout(function () {
        $('.PSCO_language').load('page/data_value/country.html', function () {
            for (var i = 0; i < Data.length; i++) {
                document.getElementById('lang_' + Data[i].id).value = Data[i].languagename;
            }
        });
        $('.PSCO_language_level').load('page/data_value/lanuage_level.html', function () {
            for (var i = 0; i < Data.length; i++) {
                document.getElementById('langlevel_' + Data[i].id).value = Data[i].languagelevel;
            }
        });
    }, 700);
};
function hideDeletedTr() {
    Profile.deletedTrid.style.display = 'none';
}
function DeleteLanguage(DeleteBtn) {
    Profile.deletedTrid = DeleteBtn.parentElement.parentElement; //---> tr deleted
    var LanguageID = Profile.deletedTrid.children[0].children[0];
    LanguageID = LanguageID.name; //-----> get name of select tag from
    LanguageID = LanguageID.split('_');
    LanguageID = LanguageID[1];
    ajax.sender_data_json_by_url_callback(Profile.Url, {
        act: 'delete_teacher_language',
        id: LanguageID
    },hideDeletedTr);
}
Profile.SaveLang = function () {
    var lang = document.getElementById('LangSelect' + (Profile.LangCounter - 1)).value;
    var level = document.getElementById('LevelSelect' + (Profile.LangCounter - 1)).value;
    var email = document.getElementById('emailId').value;
    email = email.toLowerCase();
    ajax.sender_data_json_by_url_callback(Profile.Url, {
        act: 'set_teacher_language',
        languagename: lang,
        languagelevel: level,
        email: email
    }, Profile.getAllLang)
};
function DeleteTr(id) {
    var tr = document.getElementById(id);
    tr.parentNode.removeChild(tr);
    Profile.setAddLang();
=======
var Profile = {
    LangCounter: 0
};

/*AddLanguage View*/
Profile.Addlanguage = function () {

    var Tbody = document.querySelector('#employee_lang > tbody');

    var tr = document.createElement('tr');
    tr.setAttribute('id', 'langtr' + Profile.LangCounter);

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

    Langselect.setAttribute('id', 'LangSelect' + Profile.LangCounter);
    Levelselect.setAttribute('id', 'LevelSelect' + Profile.LangCounter);
    Langselect.setAttribute('class', 'Anim-toptoleft form-control');
    Levelselect.setAttribute('class', 'Anim-toptoleft form-control');
    Langselect.setAttribute('data-addedLang', 'true'); //---> for select added select Tag in update function
    Levelselect.setAttribute('data-addedLevel', 'true'); //---> for select added select Tag in update function
    DeleteTrBtn.innerText = 'Delete This';
    DeleteTrBtn.setAttribute('onclick', "DeleteTr('langtr" + Profile.LangCounter + "')");

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
        $('#LangSelect' + Profile.LangCounter).load('../data_value/lanuage.html');
        $('#LevelSelect' + Profile.LangCounter).load('../data_value/lanuage_level.html');
        Profile.LangCounter++;
    }, 200);

};

function DeleteTr(id) {
    var tr = document.getElementById(id);
    tr.parentNode.removeChild(tr);
>>>>>>> 6e97550486ba155f7a7cb6b86dfc474f92657f4b
}
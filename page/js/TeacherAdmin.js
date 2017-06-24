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
}
<<<<<<< HEAD
var Export = {
    url: '/backend/controller_school_admin_panel.php'
};

Export.sendActions = function () {
    //ajax.sender_data_callback(Export.url , {act: 'TRMDO'} , Export.CreateMapData);
    ajax.sender_data_json_by_url_callback(Export.url, {act: 'get_religions'}, Export.CreateBarData);
    ajax.sender_data_json_by_url_callback(Export.url, {act: 'get_map_poster'}, Export.mapposter);
};
Export.sendDonutActions = function () {
    ajax.sender_data_json_by_url_callback(Export.url, {
        act: 'get_languge_by_gender',
        gender: 'all'
    }, Export.createDonutData);
};


/*Religion*/
Export.CreateBarData = function (data) {
    var series = [{
        name: 'language',
        colorByPoint: true,
        data: []
    }];
    for (var i = 0; i < data.length; i++) {
        var a = series[0].data;
        a.push({name: data[i].religion, y: parseInt(data[i].count)});
    }
    BarChart('BarChart', series);
};

/*Language*/
Export.createDonutData = function (Data) {
    var donutSeries = {
        name: 'language',
        data: []
    };
    for (var i = 0; i < Data.length; i++) {
        donutSeries.data.push([Data[i].languagename, parseInt(Data[i].count)]);
    }
    donutSeries.data.push({name: 'Proprietary or Undetectable', y: 0.2, dataLabels: {enabled: false}});
    DonutChart('DonutChart', donutSeries);
};


Export.CreateMapData = function (data) {
    // _____ for Map
    var MapDatas = [
        [
            "Country code", "af", "al", "dz", "as", "ad", "ao", "ai", "ar", "am", "aw", "au", "at", "az", "bs", "bh", "bd", "bb", "by", "be", "bz", "bj", "bm", "bt", "bo", "ba", "bw", "br", "bn", "bg", "bf", "bi", "kh", "cm", "ca", "cv", "ky", "cf", "td", "cl", "cn", "co", "km", "cd", "cg", "cr", "ci", "hr", "cu", "cw", "cy", "cz", "dk", "dj", "dm", "do", "ec", "eg", "sv", "gq", "er", "ee", "et", "fo", "fj", "fi", "fr", "pf", "ga", "gm", "ge", "de", "gh", "gr", "gl", "gd", "gu", "gt", "gn", "gw", "gy", "ht", "hn", "hk", "hu", "is", "in", "id", "ir", "iq", "ie", "im", "il", "it", "jm", "jp", "jo", "kz", "ke", "ki", "kp", "kr", "xk", "kw", "kg", "la", "lv", "lb", "ls", "lr", "ly", "li", "lt", "lu", "mo", "mk", "mg", "mw", "my", "mv", "ml", "mt", "mh", "mr", "mu", "yt", "mx", "fm", "md", "mc", "mn", "me", "ma", "mz", "mm", "na", "np", "nl", "nc", "nz", "ni", "ne", "ng", "mp", "no", "om", "pk", "pw", "pa", "pg", "py", "pe", "ph", "pl", "pt", "pr", "wa", "ro", "ru", "rw", "ws", "sm", "st", "sa", "sn", "rs", "sc", "sl", "sg", "sk", "si", "sb", "so", "za", "ss", "es", "lk", "kn", "lc", "mf", "vc", "sd", "sr", "sz", "se", "ch", "sy", "tj", "tz", "th", "tp", "tg", "to", "tt", "tn", "tr", "tm", "tc", "tv", "ug", "ua", "ae", "uk", "us", "uy", "uz", "vu", "ve", "vn", "vi", "ps", "eh", "ye", "zm", "zw"
        ],
        [
            "Country name", "Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas, The", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Colombia", "Comoros", "Congo, Dem. Rep.", "Congo, Rep.", "Costa Rica", "Cote d'Ivoire", "Croatia", "Cuba", "Curacao", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt, Arab Rep.", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Faeroe Islands", "Fiji", "Finland", "France", "French Polynesia", "Gabon", "Gambia, The", "Georgia", "Germany", "Ghana", "Greece", "Greenland", "Grenada", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Honduras", "Hong Kong SAR, China", "Hungary", "Iceland", "India", "Indonesia", "Iran, Islamic Rep.", "Iraq", "Ireland", "Isle of Man", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Dem. Rep.", "Korea, Rep.", "Kosovo", "Kuwait", "Kyrgyz Republic", "Lao PDR", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macao SAR, China", "Macedonia, FYR", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Fed. Sts.", "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nepal", "Netherlands", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Puerto Rico", "Qatar", "Romania", "Russian Federation", "Rwanda", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovak Republic", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Sudan", "Spain", "Sri Lanka", "St. Kitts and Nevis", "St. Lucia", "St. Martin (French part)", "St. Vincent and the Grenadines", "Sudan", "Suriname", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Tajikistan", "Tanzania", "Thailand", "Timor-Leste", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela, RB", "Vietnam", "Virgin Islands (U.S.)", "West Bank and Gaza", "Western Sahara", "Yemen, Rep.", "Zambia", "Zimbabwe"
        ],
        [
            "numb", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0"
        ]

    ];

    for (var i = 1; i < data.length; i++) {
        var Name = data[i][0];
        var numb = data[i][1];
        for (var c = 1; c < MapDatas[0].length; c++) {
            if (MapDatas[1][c].toLowerCase().search(Name.toLowerCase()) > -1) {
                MapDatas[2][c] = numb;
            }
        }
    }
    MapChart('MapContainer', MapDatas);
    try {
        var Table = document.getElementById('Table');
        var Tag = '';
        for (var i = 0; i < data.length; i++) {
            Tag += '<tr><td>' + data[i][0] + '</td><td>' + data[i][1] + '</td></tr>';
        }
        Table.innerHTML = Tag;
    } catch (err) {
    }
};

Export.mapposter = function (Data) {
    document.getElementById('schoolname').innerText = Data[0].schoolname;
    document.getElementById('schoolAddress').innerText = Data[0].country + '/' + Data[0].state;
    document.getElementById('AllCount').innerText = Data[3].count;
    document.getElementById('MaleCount').innerText = Data[2].count_male;
    document.getElementById('FemaleCount').innerText = Data[1].count_female;

};
/*var donutSeries = {
 name: 'Browser',
 data: [
 ['Firefox', 10.38],
 ['IE', 56.33],
 ['Chrome', 24.03],
 ['Safari', 4.77],
 ['Opera', 0.91],
 {
 name: 'Proprietary or Undetectable',
 y: 0.2,
 dataLabels: {
 enabled: false
 }
 }
 ]
 };*/

=======
var Export = {
    url: '/backend/controller_school_admin_panel.php'
};

Export.sendActions = function () {
    //ajax.sender_data_callback(Export.url , {act: 'TRMDO'} , Export.CreateMapData);
    ajax.sender_data_json_by_url_callback(Export.url, {act: 'get_religions'}, Export.CreateBarData);
};
Export.sendDonutActions = function () {
    ajax.sender_data_json_by_url_callback(Export.url, {act: 'get_languge_by_gender', gender: 'all'}, Export.createDonutData);
};


/*Religion*/
Export.CreateBarData = function (data) {
    var series = [{
        name: 'language',
        colorByPoint: true,
        data: []
    }];
    for (var i = 0; i < data.length; i++) {
        var a = series[0].data;
        a.push({name: data[i].religion, y: parseInt(data[i].count)});
    }
    BarChart('BarChart', series);
};

/*Language*/
Export.createDonutData = function (Data) {
    var donutSeries = {
        name: 'language',
        data: []
    };
    for (var i = 0; i < Data.length; i++) {
        donutSeries.data.push([Data[i].languagename, parseInt(Data[i].count)]);
    }
    donutSeries.data.push({name: 'Proprietary or Undetectable', y: 0.2, dataLabels: {enabled: false}});
    DonutChart('DonutChart', donutSeries);
};


Export.CreateMapData = function (data) {
    // _____ for Map
    var MapDatas = [
        [
            "Country code", "af", "al", "dz", "as", "ad", "ao", "ai", "ar", "am", "aw", "au", "at", "az", "bs", "bh", "bd", "bb", "by", "be", "bz", "bj", "bm", "bt", "bo", "ba", "bw", "br", "bn", "bg", "bf", "bi", "kh", "cm", "ca", "cv", "ky", "cf", "td", "cl", "cn", "co", "km", "cd", "cg", "cr", "ci", "hr", "cu", "cw", "cy", "cz", "dk", "dj", "dm", "do", "ec", "eg", "sv", "gq", "er", "ee", "et", "fo", "fj", "fi", "fr", "pf", "ga", "gm", "ge", "de", "gh", "gr", "gl", "gd", "gu", "gt", "gn", "gw", "gy", "ht", "hn", "hk", "hu", "is", "in", "id", "ir", "iq", "ie", "im", "il", "it", "jm", "jp", "jo", "kz", "ke", "ki", "kp", "kr", "xk", "kw", "kg", "la", "lv", "lb", "ls", "lr", "ly", "li", "lt", "lu", "mo", "mk", "mg", "mw", "my", "mv", "ml", "mt", "mh", "mr", "mu", "yt", "mx", "fm", "md", "mc", "mn", "me", "ma", "mz", "mm", "na", "np", "nl", "nc", "nz", "ni", "ne", "ng", "mp", "no", "om", "pk", "pw", "pa", "pg", "py", "pe", "ph", "pl", "pt", "pr", "wa", "ro", "ru", "rw", "ws", "sm", "st", "sa", "sn", "rs", "sc", "sl", "sg", "sk", "si", "sb", "so", "za", "ss", "es", "lk", "kn", "lc", "mf", "vc", "sd", "sr", "sz", "se", "ch", "sy", "tj", "tz", "th", "tp", "tg", "to", "tt", "tn", "tr", "tm", "tc", "tv", "ug", "ua", "ae", "uk", "us", "uy", "uz", "vu", "ve", "vn", "vi", "ps", "eh", "ye", "zm", "zw"
        ],
        [
            "Country name", "Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas, The", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Colombia", "Comoros", "Congo, Dem. Rep.", "Congo, Rep.", "Costa Rica", "Cote d'Ivoire", "Croatia", "Cuba", "Curacao", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt, Arab Rep.", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Faeroe Islands", "Fiji", "Finland", "France", "French Polynesia", "Gabon", "Gambia, The", "Georgia", "Germany", "Ghana", "Greece", "Greenland", "Grenada", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Honduras", "Hong Kong SAR, China", "Hungary", "Iceland", "India", "Indonesia", "Iran, Islamic Rep.", "Iraq", "Ireland", "Isle of Man", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Dem. Rep.", "Korea, Rep.", "Kosovo", "Kuwait", "Kyrgyz Republic", "Lao PDR", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macao SAR, China", "Macedonia, FYR", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Fed. Sts.", "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nepal", "Netherlands", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Puerto Rico", "Qatar", "Romania", "Russian Federation", "Rwanda", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovak Republic", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Sudan", "Spain", "Sri Lanka", "St. Kitts and Nevis", "St. Lucia", "St. Martin (French part)", "St. Vincent and the Grenadines", "Sudan", "Suriname", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Tajikistan", "Tanzania", "Thailand", "Timor-Leste", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela, RB", "Vietnam", "Virgin Islands (U.S.)", "West Bank and Gaza", "Western Sahara", "Yemen, Rep.", "Zambia", "Zimbabwe"
        ],
        [
            "numb", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0"
        ]

    ];

    for (var i = 1; i < data.length; i++) {
        var Name = data[i][0];
        var numb = data[i][1];
        for (var c = 1; c < MapDatas[0].length; c++) {
            if (MapDatas[1][c].toLowerCase().search(Name.toLowerCase()) > -1) {
                MapDatas[2][c] = numb;
            }
        }
    }
    MapChart('MapContainer', MapDatas);
    try {
        var Table = document.getElementById('Table');
        var Tag = '';
        for (var i = 0; i < data.length; i++) {
            Tag += '<tr><td>' + data[i][0] + '</td><td>' + data[i][1] + '</td></tr>';
        }
        Table.innerHTML = Tag;
    } catch (err) {
    }
};


/*var donutSeries = {
 name: 'Browser',
 data: [
 ['Firefox', 10.38],
 ['IE', 56.33],
 ['Chrome', 24.03],
 ['Safari', 4.77],
 ['Opera', 0.91],
 {
 name: 'Proprietary or Undetectable',
 y: 0.2,
 dataLabels: {
 enabled: false
 }
 }
 ]
 };*/

>>>>>>> 6e97550486ba155f7a7cb6b86dfc474f92657f4b

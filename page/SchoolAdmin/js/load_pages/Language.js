var Language = {
    Series:[],
    DonutSeries: []
};


Language.sendAction = function (gender) {
    if (gender == null){
        gender = 'all'
    }
    ajax.sender_data_json_by_url_callback(Global.url, {
        act: 'get_languge_by_gender',
        gender: gender
    }, Language.getData);
};

Language.getData = function (Data) {
    Language.CreateBarData(Data);
    Language.createDonutData(Data);
    Language.CreateTableData(Data);
};

Language.CreateBarData = function (Data) {
    var series = [{
        name: 'Language',
        colorByPoint: true,
        data: []
    }];
    for (var i = 0; i < Data.length; i++) {
        var a = series[0].data;
        a.push({name: Data[i].languagename, y: parseInt(Data[i].count)});
    }
    Language.Series = series;
    BarChart('LangChartContainer' , series);
};


Language.createDonutData = function (Data) {
    var donutSeries = {
        name: 'Language',
        data: []
    };
    for (var i = 0; i < Data.length; i++) {
        donutSeries.data.push([Data[i].languagename, parseInt(Data[i].count)]);
    }
    donutSeries.data.push({name: 'Proprietary or Undetectable', y: 0.2, dataLabels: {enabled: false}});
    Language.DonutSeries = donutSeries;
};

Language.CreateTableData = function (data) {
    TableData = {
        thName: ['Language', 'Count'],
        trData: []
    };
    for (var i = 0; i < data.length; i++) {
        TableData.trData.push([data[i].languagename, data[i].count]);
    }
    TabelCreateor(TableData, 'langTable');
};

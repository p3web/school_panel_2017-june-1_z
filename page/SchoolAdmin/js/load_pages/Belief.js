var Belief = {
    Series:[],
    DonutSeries:[]
};


Belief.sendAction=function () {
ajax.sender_data_json_by_url_callback(Global.url,{act:'get_religions'}, Belief.getData)
};

Belief.getData = function (Data) {
    Belief.CreateBarData(Data);
    Belief.createDonutData(Data);
    Belief.CreateTableData(Data);
};

Belief.CreateBarData = function (Data) {
    var series = [{
        name: 'Religion',
        colorByPoint: true,
        data: []
    }];
    for (var i = 0; i < Data.length; i++) {
        var a = series[0].data;
        a.push({name: Data[i].religion, y: parseInt(Data[i].count)});
    }
    Belief.Series = series;
    PieChart('ChartContainer', series);
};


Belief.createDonutData = function (Data) {
    var donutSeries = {
        name: 'Religion',
        data: []
    };
    for (var i = 0; i < Data.length; i++) {
        donutSeries.data.push([Data[i].religion, parseInt(Data[i].count)]);
    }
    donutSeries.data.push({name: 'Proprietary or Undetectable', y: 0.2, dataLabels: {enabled: false}});
  Belief.DonutSeries = donutSeries;
};

Belief.CreateTableData = function (data) {
    TableData = {
        thName: ['Religion', 'Count'],
        trData: [
        ]
    };
    for (var i = 0; i < data.length; i++) {
        TableData.trData.push([data[i].religion , data[i].count ]);
    }
    TabelCreateor(TableData, 'BeliefTable');
};
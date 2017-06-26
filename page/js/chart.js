/**
 * Created by peymanvalikhanli on 6/11/17 AD.
 */

var Chart_Type = {
    language: 'bar',
    belief: 'pie'
};

//_____ Check ChartLoad
var ChartScriptLoad = {
    highcharts: false,
    exporting: false,
    data: false,
    drilldown: false
};
function scriptLoad(scriptName) {
    ChartScriptLoad[scriptName] = true;
}
function CheckScriptChart() {
    if (ChartScriptLoad.highcharts && ChartScriptLoad.exporting && ChartScriptLoad.data && ChartScriptLoad.drilldown) {
        PieChart('ChartContainer_religion', series);
    } else {
        setTimeout(function () {
            CheckScriptChart();
        }, 100);
    }
}
// CheckScriptChart();
///_____ End Check load

function changeChartData(ContainerID, series, D_series, chartName) {
    var type;
    if (chartName == 'language') {
        type = Chart_Type.language;
    }
    else if (chartName == 'belief') {
        type = Chart_Type.belief;
    }
    if (type == 'pie') {
        PieChart(ContainerID, series);
    }
    else if (type == 'bar') {
        BarChart(ContainerID, series);
    } else {
        DonutChart(ContainerID, D_series)
    }
}


function BarChart(ContainerID, series, chartName) {
    // Create the chart
    document.getElementById(ContainerID).innerHTML = '';
    Highcharts.chart(ContainerID, {
        credits: {
            enabled: false
        },
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: ''
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        },

        series: series
    });

    if (chartName == 'language') {
        Chart_Type.language = 'bar';
    }
    else if (chartName == 'belief') {
        Chart_Type.belief = 'bar';
    }

}

function MapChart(ContainerID, MapData) {
    Highcharts.data({

        googleSpreadsheetKey: '0AoIaUO7wH1HwdFJHaFI4eUJDYlVna3k5TlpuXzZubHc',

        // custom handler when the spreadsheet is parsed
        parsed: function (columns) {
            columns = MapData;
            // Read the columns into the data array
            var data = [];
            $.each(columns[0], function (i, code) {
                data.push({
                    code: code.toUpperCase(),
                    value: parseFloat(columns[2][i]),
                    name: columns[1][i]
                });
            });


            // Initiate the chart
            Highcharts.mapChart(ContainerID, {
                credits: {
                    enabled: false
                },
                chart: {
                    borderWidth: 1
                },

                colors: ['#fff', 'rgba(19,64,117,0.2)', 'rgba(19,64,117,0.4)',
                    'rgba(19,64,117,0.5)', 'rgba(19,64,117,0.6)', 'rgba(19,64,117,0.8)', 'rgba(19,64,117,1)'],

                title: {
                    text: ''
                },

                mapNavigation: {
                    enabled: false
                },


                XAxis: {
                    labels: {
                        enabled: false
                    }
                    , enabled: false
                },

                colorAxis: {
                    labels: {
                        format: '{value}'
                    }
                },

                legend: {
                    layout: 'horizental',
                    align: 'left',
                    verticalAlign: 'bottom'
                },


                /*       colorAxis: {
                 dataClasses: [{
                 to: 8
                 }, {
                 from: 3,
                 to: 10
                 }, {
                 from: 10,
                 to: 30
                 }, {
                 from: 30,
                 to: 100
                 }, {
                 from: 100,
                 to: 300
                 }, {
                 from: 300,
                 to: 1000
                 }, {
                 from: 1000
                 }]
                 },*/

                series: [{
                    data: data,
                    mapData: Highcharts.maps['custom/world'],
                    joinBy: ['iso-a2', 'code'],
                    animation: true,
                    name: 'Population density',
                    states: {
                        hover: {
                            color: '#a4edba'
                        }
                    },
                    tooltip: {
                        valueSuffix: ''
                    }
                }]
            });
        },
        error: function () {
            $('#container').html('<div class="loading">' +
                '<i class="icon-frown icon-large"></i> ' +
                'Error loading data from Google Spreadsheets' +
                '</div>');
        }
    });

}

function PieChart(ContainerID, series , chartName) {
    document.getElementById(ContainerID).innerHTML = '';
    // Build the chart
    Highcharts.chart(ContainerID, {
        credits: {
            enabled: false
        },
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: series
    });

    if (chartName == 'language') {
        Chart_Type.language = 'pie';
    }
    else if (chartName == 'belief') {
        Chart_Type.belief = 'pie';
    }


}

//_____ examepl Data
/*
 var donutُSeries = {
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
 };

 */


function DonutChart(ContainerID, series , chartName) {
    document.getElementById(ContainerID).innerHTML = '';
    Highcharts.chart(ContainerID, {
        credits: {
            enabled: false
        },
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 0,
            plotShadow: false
        },
        title: {
            text: '',
            align: 'center',
            verticalAlign: 'middle',
            y: 40
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                dataLabels: {
                    enabled: true,
                    distance: 50,
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                },
                startAngle: -180,
                endAngle: 180,
                center: ['50%', '50%']
            }
        },
        series: [{
            type: 'pie',
            name: series.name,
            innerSize: '50%',
            data: series.data
        }]
    });

    if (chartName == 'language') {
        Chart_Type.language = 'Donut';
    }
    else if (chartName == 'belief') {
        Chart_Type.belief = 'Donut';
    }


}


//_____ <table> must be Exist ...
function TabelCreateor(data, tableId) {
    var i;
    var tableData = '<thead style="background-color:#FFD799 !important;"><tr><th>#</th>';
    for (i = 0; i < data.thName.length; i++) {
        tableData += '<td>' + data.thName[i] + '</td>';
    }
    tableData += '</tr></thead><tbody>';
    for (i = 0; i < data.trData.length; i++) {
        tableData += '<tr><td>' + (i + 1) + '</td>';
        for (var a = 0; a < data.trData[i].length; a++) {
            var tdata = data.trData[i][a]== null ? '-' : data.trData[i][a] ;
            tableData += '<td>' +tdata + '</td>';
        }
        tableData += '</tr>';
    }
    tableData += '</tbody>';
    document.getElementById(tableId).innerHTML = tableData;
}


/*MAPDETAILS*/
function CreateMapdetails(data) {
    //document.getElementById('SchoolTitle').innerText = data[0][0][0];
    //document.getElementById('addressTitle').innerText = data[0][0][1];
    document.getElementById('school').innerText = data[0][1][0];
    document.getElementById('address').innerText = data[0][1][1];
}
function CreateMapBottomDetails(data) {
    //document.getElementById('bottomTitle1').innerText = data[0][0][1] + '/' + data[0][0][1];
    //document.getElementById('bottom1').innerText = data[0][0][0];
    document.getElementById('bottomTitle2').innerText = data[0][1][1];
    document.getElementById('bottom2').innerText = data[0][1][0];
    document.getElementById('bottomTitle3').innerText = data[0][2][1];
    document.getElementById('bottom3').innerText = data[0][2][0];
    document.getElementById('bottomTitle4').innerText = data[0][3][1];
    document.getElementById('bottom4').innerText = data[0][3][0];

}
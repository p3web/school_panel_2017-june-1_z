/**
 * Created by peymanvalikhanli on 6/11/17 AD.
 */

var Chart_Type = 'pie';

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

function changeChartData(ContainerID, series,D_series) {
    if (Chart_Type == 'pie') {
        PieChart(ContainerID, series);
    }
    else if (Chart_Type == 'bar') {
        BarChart(ContainerID, series);
    }else {
        DonutChart(ContainerID,D_series)
    }
}


function BarChart(ContainerID, series) {
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
    Chart_Type = 'bar';

}
function PieChart(ContainerID, series) {
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
    Chart_Type = 'pie';

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


function DonutChart(ContainerID, series) {
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
    Chart_Type = 'Donut';
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
            tableData += '<td>' + data.trData[i][a] + '</td>';
        }
        tableData += '</tr>';
    }
    tableData += '</tbody>';
    document.getElementById(tableId).innerHTML = tableData;
}



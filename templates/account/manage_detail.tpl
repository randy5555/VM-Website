{nocache}
<style type="text/css">
.highcharts-figure, .highcharts-data-table table {
    min-width: 360px; 
    max-width: 100%;
    margin: 1em auto;
}

.highcharts-data-table table {
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
	border: 1px solid #EBEBEB;
	margin: 10px auto;
	text-align: center;
	width: 100%;
	max-width: 500px;
}
.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}
.highcharts-data-table th {
	font-weight: 600;
    padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
    padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}
.highcharts-data-table tr:hover {
    background: #f1f7ff;
}



</style>
<section class="services5 cid-qTkA127IK8 mbr-fullscreen mbr-parallax-background" id="services5-i">
<div class="container container-table">
    <div class="container"  style='min-height:30px'>
            
    </div>
    <h2 class="mbr-section-title mbr-fonts-style align-center pb-3 display-2">
          Virtual Machine: {$vm.vm_name}</h2>
    <div class="container" >
            
    </div>
    <div class="container card card-whitenb">
        <p>CPU: {$vm.vm_cpus}vCPU | RAM: {$vm.vm_ram}GB | Disk: {$vm.disk_space}GB | Current Status: {if $vm.vm_status eq 'off'}<span class='text-orange'><b>Powered Off</b></span>{elseif $vm.vm_status eq 'on'}<span class='text-green'><b>On</b></span>{elseif $vm.vm_status eq 'destroyed'}<span class='text-red'><b>Destroyed</b></span>{/if}</p>
    </div>
    
    <div class="table-wrapper">
        <div class="container align-center pb-3 display-2">
            <table>
                <tr>
                    <td><div class="navbar-buttons mbr-section-btn"><a class="btn btn-sm btn-success display-4" href="#" onclick="vm_start('{$vm.vm_id}');"><font face="MobiriseIcons"><br></font>Start<br></a></div></td>
                    <td><div class="navbar-buttons mbr-section-btn"><a class="btn btn-sm btn-primary display-4" href="#" onclick="vm_stop('{$vm.vm_id}');"><font face="MobiriseIcons"><br></font>Power off<br></a></div></td>
                    <td><div class="navbar-buttons mbr-section-btn"><a class="btn btn-sm btn-primary display-4" href="#" onclick="vm_shutdown('{$vm.vm_id}');"><font face="MobiriseIcons"><br></font>Shut down<br></a></div></td>
                    <td><div class="navbar-buttons mbr-section-btn"><a class="btn btn-sm btn-warning display-4" href="#" onclick="vm_destroy('{$vm.vm_id}');"><font face="MobiriseIcons"><br></font>Destroy<br></a></div></td>
                    <td><div class="navbar-buttons mbr-section-btn"><a class="btn btn-sm btn-info display-4" href="/noVNC-1.1.0/vnc.html?&host=analogocean.afxr.net&port={$vmport}&password=asouihfdiuk&encrypt=false&path=" target="_new"><font face="MobiriseIcons"><br></font>Console<br></a></div></td>
                </tr>
            </table>
        </div>
                    
        <hr>
        
        <div class="container card card-whitenb" style='min-height:360px' id="chart1">
            <figure class="highcharts-figure">
            <div id="container"></div>
            
        </figure>
        </div>
        
        <div class="container card card-whitenb" style='min-height:360px' id="chart2">
            <figure class="highcharts-figure">
            <div id="container2"></div>
            
        </figure>
        </div>
        
        <div class="container card card-whitenb" style='min-height:360px' id="chart3">
            <figure class="highcharts-figure">
            <div id="container3"></div>
            
        </figure>
        </div>
        
        <div class="container card card-whitenb" style='min-height:360px' id="chart4">
            <figure class="highcharts-figure">
            <div id="container4"></div>
            
        </figure>
        </div>
    </div>
</div>
</section>
<script>
    var vm_id = '{$vm.vm_id}';
{literal}
$(document).ready(function(){
var chart = Highcharts.getJSON(
    "/ajax/stats?ajax=true&method=cpustats_get&vm_id="+vm_id,
    function (data) {

        Highcharts.chart('container', {
            chart: {
                zoomType: 'x',
                width: $("#chart1").width()
            },
            title: {
                text: 'CPU Usage Graph'
            },
            subtitle: {
                text: document.ontouchstart === undefined ?
                    'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
            },
            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                title: {
                    text: 'CPU Usage Percentage'
                },
                min: 0,
                max:100
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },
            

            series: [{
                type: 'area',
                name: 'CPU Usage Percentage',
                data: data
            }]
        });
    }
);


var chart2 = Highcharts.getJSON(
    "/ajax/stats?ajax=true&method=ramstats_get&vm_id="+vm_id,
    function (data) {

        Highcharts.chart('container2', {
            chart: {
                zoomType: 'x',
                width: $("#chart2").width()
            },
            title: {
                text: 'RAM Usage Graph'
            },
            subtitle: {
                text: document.ontouchstart === undefined ?
                    'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
            },
            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                title: {
                    text: 'RAM Usage Percentage'
                },
                min: 0,
                max:100
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },
            

            series: [{
                type: 'area',
                name: 'RAM Usage Percentage',
                data: data
            }]
        });
    }
);

var chart3 = Highcharts.getJSON(
    "/ajax/stats?ajax=true&method=netstats_get&vm_id="+vm_id,
    function (data) {

        Highcharts.chart('container3', {
    chart: {
        type: 'spline',
        zoomType: 'x',
        width: $("#chart3").width()
    },
    title: {
        text: 'Network Statistics'
    },
    subtitle: {
                text: document.ontouchstart === undefined ?
                    'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
     },
    xAxis: {
                type: 'datetime'
            },
    yAxis: {
        title: {
            text: 'Network KB'
        },
        min: 0
    },
    tooltip: {
        formatter: function () {
            return this.points.reduce(function (s, point) {
                return s + '<br/><span style="color:' + point.series.color + '">' + point.series.name + '</span>: ' + point.y.toFixed(2) + "KB";
            }, '<b>' + Highcharts.dateFormat('%A, %b %e, %Y</b> %H:%M', this.x));
        },
        shared: true
    },

    plotOptions: {
        series: {
            marker: {
                enabled: true
            }
        }
    },

    colors: ['#6CF', '#06C', '#036', '#000'],

    // Define the data points. All series have a dummy year
    // of 1970/71 in order to be compared on the same x axis. Note
    // that in JavaScript, months start at 0 for January, 1 for February etc.
    series: data,

    responsive: {
        rules: [{
            condition: {
                maxWidth: 800
            },
            chartOptions: {
                plotOptions: {
                    series: {
                        marker: {
                            radius: 2.5
                        }
                    }
                }
            }
        }]
    }
});
    }
);


var chart4 = Highcharts.getJSON(
    "/ajax/stats?ajax=true&method=diskstats_get&vm_id="+vm_id,
    function (data) {

        Highcharts.chart('container4', {
    chart: {
        type: 'spline',
        zoomType: 'x',
        width: $("#chart4").width()
    },
    title: {
        text: 'Disk IO Statistics'
    },
    subtitle: {
                text: document.ontouchstart === undefined ?
                    'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
     },
    xAxis: {
                type: 'datetime'
            },
    yAxis: [{
        title: {
            text: 'Disk IO KB'
        },
        min: 0
    },{
        title: {
            text: 'Disk IO Count'
        },
        min: 0,
        opposite: true
    }],
    tooltip: {
        formatter: function () {
            return this.points.reduce(function (s, point) {
                return s + '<br/><span style="color:' + point.series.color + '">' + point.series.name + '</span>: ' + point.y;
            }, '<b>' + Highcharts.dateFormat('%A, %b %e, %Y</b> %H:%M', this.x));
        },
        shared: true
    },

    plotOptions: {
        series: {
            marker: {
                enabled: true
            }
        }
    },

    colors: ['#6CF', '#06C', '#036', '#000'],

    // Define the data points. All series have a dummy year
    // of 1970/71 in order to be compared on the same x axis. Note
    // that in JavaScript, months start at 0 for January, 1 for February etc.
    series: data,

    responsive: {
        rules: [{
            condition: {
                maxWidth: 800
            },
            chartOptions: {
                plotOptions: {
                    series: {
                        marker: {
                            radius: 2.5
                        }
                    }
                }
            }
        }]
    }
});
    }
);

//chart.setSize($("#chart1").width(), 360, doAnimation = false);
//chart2.setSize($("#chart2").width(), 360, doAnimation = false);

});


function vm_start(vm_id) {
    $.get("/ajax/account?ajax=true&method=account_start_vm&vm_id=" + vm_id, function(data) {
		if(data == 'success') {
			setInterval('location.reload()', 4000);
		} else {
			alert(data);
			
		}
	});
}

function vm_stop(vm_id) {
    $.get("/ajax/account?ajax=true&method=account_stop_vm&vm_id=" + vm_id, function(data) {
		if(data == 'success') {
			setInterval('location.reload()', 5000);
		} else {
			alert(data);
			
		}
	});
}

function vm_shutdown(vm_id) {
    $.get("/ajax/account?ajax=true&method=account_shutdown_vm&vm_id=" + vm_id, function(data) {
		if(data == 'success') {
			setInterval('location.reload()', 5000);
		} else {
			alert(data);
			
		}
	});
}

function vm_destroy(vm_id) {
    $.get("/ajax/account?ajax=true&method=account_destroy_vm&vm_id=" + vm_id, function(data) {
		if(data == 'success') {
			setInterval('location.reload()', 5000);
		} else {
			alert(data);
			
		}
	});
}

function vm_console(vm_id) {
    $.get("/ajax/account?ajax=true&method=account_start_vm_console&vm_id=" + vm_id, function(data) {
		if(data == 'success') {
			setInterval('location.reload()', 5000);
		} else {
			alert(data);
			
		}
	});
}

{/literal}
</script>
{/nocache}


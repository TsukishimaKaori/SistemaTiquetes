$(function () {
    $('#fechaI').datetimepicker({
        format: 'DD/MM/YYYY',
        locale: 'es'
    });
});
$(function () {
    $('#fechaF').datetimepicker({
        format: 'DD/MM/YYYY',
        locale: 'es'
    });
});



//Grafico de barras
var colorNames = Object.keys(window.chartColors);
var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
var color = Chart.helpers.color;
var barChartData = {
    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    datasets: [{
            label: 'Dataset 1',
            backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
            borderColor: window.chartColors.red,
            borderWidth: 1,
            data: [
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor()
            ]
        }, {
            label: 'Dataset 2',
            backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
            borderColor: window.chartColors.blue,
            borderWidth: 1,
            data: [
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor()
            ]
        }]

};

//Carga el gráfico lineal
var colorNames = Object.keys(window.chartColors);
//Grafico Lineal
var MONTHS = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'];
var configLineal = {
    type: 'line',
    data: {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        datasets: [{
                label: 'My Second dataset',
                fill: false,
                backgroundColor: window.chartColors.blue,
                borderColor: window.chartColors.blue,
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor()
                ],
            }]
    },
    options: {
        responsive: true,
        title: {
            display: true,
            text: 'Chart.js Line Chart'
        },
        tooltips: {
            mode: 'index',
            intersect: false,
        },
        hover: {
            mode: 'nearest',
            intersect: true
        },
        scales: {
            xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Month'
                    }
                }],
            yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Value'
                    }
                }]
        }
    }
};


//Carga todos los gráficos
window.onload = function () {
    graficoAreas();
    var ctx = document.getElementById('chart-area3').getContext('2d');
    window.myLine = new Chart(ctx, configLineal);
    var ctx = document.getElementById('canvas').getContext('2d');
    window.myBar = new Chart(ctx, {
        type: 'bar',
        data: barChartData,
        options: {
            responsive: true,
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Chart.js Bar Chart'
            }
        }
    });
};

//Cargar los gráficos 
function graficoAreas() {
    $("#chart-area").empty();
    var areasReportes = $('#comboAreasReportes option:selected').val();
    var fechaInicio = $('#fechaI').val();
    var fechaFinal = $('#fechaF').val();
    $('#tbodySolicitudClasificacionPorArea').empty();
    $.ajax({
        data: {'areasTematicasReportes': areasReportes, 'fechaInicio': fechaInicio, 'fechaFinal': fechaFinal},
        type: 'POST',
        url: '../control/SolicitudAjaxReportesTiquetes.php',
        success: function (response) {
            var vector = JSON.parse(response);
            var cantidad = [];
            var descripcion = [];
            var colores = [];
            for (var i in vector) {
                cantidad.push(vector[i]['cantidadClasificacion']);
                descripcion.push(vector[i]['descripcionClasificacion']);
                r = Math.floor(Math.random() * 200);
                g = Math.floor(Math.random() * 200);
                b = Math.floor(Math.random() * 200);
                color = 'rgb(' + r + ', ' + g + ', ' + b + ')';
                colores.push(color);

                var fila = '<tr><td>' + vector[i]['descripcionClasificacion'] + '</td><td>' + vector[i]['cantidadClasificacion'] + '</td></tr>';
                $('#tbodySolicitudClasificacionPorArea').append(fila);

            }
            if (typeof myPie == 'undefined') {
                config = {
                    type: 'pie',
                    data: {
                        datasets: [{
                                data: cantidad,
                                backgroundColor: colores,
                                label: 'Clasificaciones'
                            }],
                        labels: descripcion
                    },
                    options: {
                        responsive: true
                    }
                };
                var ctx = document.getElementById('chart-area').getContext('2d');
                window.myPie = new Chart(ctx, config);
            } else {
                config.data.datasets.splice(0, 1);
                var tamanio = config.data.labels.length;
                config.data.labels.splice(0, tamanio);
                var newDataset = {
                    data: cantidad,
                    backgroundColor: colores,
                    label: 'Clasificaciones'
                };
                var des= descripcion;
                config.data.datasets.push(newDataset);                 
                config.data.labels = descripcion;
                window.myPie.update();
            }
        }
    });
}



function graficoSolicitudesAtendidasPorAnio() {

}

function graficoRendimientoPorArea() {

}
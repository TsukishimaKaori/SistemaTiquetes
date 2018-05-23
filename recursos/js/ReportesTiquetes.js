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
$(function () {
    $('#fechaIGraficoBarras').datetimepicker({
        format: 'DD/MM/YYYY',
        locale: 'es'
    });
});
$(function () {
    $('#fechaFGraficoBarras').datetimepicker({
        format: 'DD/MM/YYYY',
        locale: 'es'
    });
});
//$(function () {
//    $('#datepickerAnio').datetimepicker({
//        format: "YYYY"
//
//    });
//});

$('#datepickerAnio').datetimepicker(
        {format: "YYYY"}).on('dp.change', function (e) {
    graficoSolicitudesAtendidasPorAnio();
});

//Carga todos los gráficos
window.onload = function () {
    graficoAreas();
    graficoRendimientoPorArea();
    graficoSolicitudesAtendidasPorAnio();

};

//Carga grafico de PIE
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
        beforeSend: function () {
            $("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none')
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
                var des = descripcion;
                config.data.datasets.push(newDataset);
                config.data.labels = descripcion;
                window.myPie.update();
            }
        }
    });
}

//Carga grafico de Barras
function graficoRendimientoPorArea() {
    $('#tbodyGraficoBarras').empty();
    var fechaInicioRendimientoPorArea = $('#fechaIGraficoBarras').val();
    var fechaFinalRendimientoPorArea = $('#fechaFGraficoBarras').val();

    $.ajax({
        data: {'fechaInicioRendimientoPorArea': fechaInicioRendimientoPorArea, 'fechaFinalRendimientoPorArea': fechaFinalRendimientoPorArea},
        type: 'POST',
        url: '../control/SolicitudAjaxReportesTiquetes.php',
        beforeSend: function () {
            $("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none')
            var vector = JSON.parse(response);
            var area = [];
            var atendidas = [];
            var calificadas = [];
            for (var i in vector) {
                area.push(vector[i]['nombreArea']);
                atendidas.push(vector[i]['totalAtendidas']);
                calificadas.push(vector[i]['totalCalificadas']);
                var porcentaje=0;
                if(vector[i]['totalAtendidas']!=0){
                porcentaje=(vector[i]['totalCalificadas']*100)/vector[i]['totalAtendidas'];}
              
                var fila = '<tr><td>' + vector[i]['nombreArea'] + '</td><td>' + vector[i]['totalCalificadas'] + '</td><td>' + vector[i]['totalAtendidas'] + '</td>'+
              '<td>' +porcentaje + '% </td></tr>';
                $('#tbodyGraficoBarras').append(fila);
            }
            var colorNames = Object.keys(window.chartColors);
            var MONTHS = area;
            var color = Chart.helpers.color;
            if (typeof myBar == 'undefined') {

                barChartData = {
                    labels: area,
                    datasets: [{
                            label: 'Solicitudes cumplidas',
                            backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
                            borderColor: window.chartColors.red,
                            borderWidth: 1,
                            data: calificadas
                        }, {
                            label: 'Solicitudes atendidas',
                            backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
                            borderColor: window.chartColors.blue,
                            borderWidth: 1,
                            data: atendidas
                        }]

                };
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
                            text: 'Cumplimiento por área '
                        }
                    }
                });

            } else {
                barChartData.datasets.splice(0, 2);
                var tamanio = config.data.labels.length;
                barChartData.labels.splice(0, tamanio);
                barChartData.labels = area;
                var colorName = colorNames[barChartData.datasets.length % colorNames.length];
                var dsColor = window.chartColors[colorName];
                var newDataset = {
                    label: 'Solicitudes cumplidas',
                    backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
                    borderColor: window.chartColors.red,
                    borderWidth: 1,
                    data: calificadas
                };
                var newDataset2 = {
                    label: 'Solicitudes atendidas ',
                    backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
                    borderColor: window.chartColors.blue,
                    borderWidth: 1,
                    data: atendidas
                };

                barChartData.datasets.push(newDataset);
                barChartData.datasets.push(newDataset2);
                window.myBar.update();
            }
        }
    });
}

//Carga grafico lineal
function graficoSolicitudesAtendidasPorAnio() {
    $('#tbodyGraficoLineas').empty();
    var datepickerAnio = $('#datepickerAnio').val();
    $.ajax({
        data: {'datepickerAnio': datepickerAnio},
        type: 'POST',
        url: '../control/SolicitudAjaxReportesTiquetes.php',
        beforeSend: function () {
            $("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none')
            var vector = JSON.parse(response);
            var cantidadMensuales = [];
            $('#tbodyGraficoLineas').append('<tr id = "trCantidad"></tr>');
            for (var i in vector) {
                cantidadMensuales.push(vector[i]['cantidadMensuales']);
                td = '<td>' + vector[i]['cantidadMensuales'] + '</td>';
                $('#trCantidad').append(td);
            }
            //Carga el gráfico lineal
            var colorNames = Object.keys(window.chartColors);
            var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'];
//Grafico Lineal
            if (typeof myLine == 'undefined') {
                configLineal = {
                    type: 'line',
                    data: {
                        labels: meses,
                        datasets: [{
                                label: 'Solicitudes atendidas por mes',
                                fill: false,
                                backgroundColor: window.chartColors.blue,
                                borderColor: window.chartColors.blue,
                                data: cantidadMensuales
                            }]
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Reporte de cantidad de tiquetes mensuales'
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

                var ctx = document.getElementById('chart-area3').getContext('2d');
                window.myLine = new Chart(ctx, configLineal);
            } else {
                configLineal.data.datasets.splice(0, 1);
                var tamanio = configLineal.data.labels.length;
                configLineal.data.labels.splice(0, tamanio);
                var newDataset = {
                    label: 'Solicitudes atendidas por mes',
                    fill: false,
                    data: cantidadMensuales,
                    backgroundColor: window.chartColors.blue,
                    borderColor: window.chartColors.blue

                };
                configLineal.data.datasets.push(newDataset);
                configLineal.data.labels = meses;
                window.myLine.update();
            }
        }
    });
}



function abrirModalCalificacionesEmpleados() {
    var codigo = $("#codigoAreaCalificacion").text();
    var nombre = $("#nombreAreaCalificacion").text();

    $.ajax({
        data: {'codigoAreaCalificacion': codigo
        },
        type: 'POST',
        url: '../control/SolicitudAjaxReportesTiquetes.php',
        beforeSend: function () {
            //$("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
         //   alert(response);
            $("#cuerpoModalCalificaciones").html(response);
            $("#tituloModalCalificaciones").text("Calificación de empleados para el área: " + nombre);
            $("#modalCalificaciones").modal("show");
        }

    });

}




$(document).ready(function () {

    tablaTiquetes();
    graficoAreas();
});

function tablaTiquetes() {
    $('#mitablaTiquetes').DataTable({
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Filtrar búsqueda",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }

        },

    });
}


function FiltrarTiquete(estado) {


    $.ajax({
        data: {'estado': estado
        },        
        type: 'POST',
        url: '../control/SolicitudAjaxReporteTiquetesEstado.php',
        beforeSend: function () {
            $("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none')            
            $('#mitablaTiquetes').DataTable().destroy();
            $("#TablaTiquetes").html(response);
            tablaTiquetes();
           
        }

    });
}
function mostrarDetalleTIquetes($codigo,event) {
  $(event).parent().parent().children('tr').css("background-color", "#ffffff");
    $(event).parent().css("background-color", "#dff0d8");
    $("#modalInfoTiquetes").modal("hide");
    $.ajax({
        data: {'codigo': $codigo
        },
        type: 'POST',
        url: '../control/SolicitudAjaxReporteTiquetesEstado.php',
        beforeSend: function () {
            $("#cargandoImagen").css('display', 'block');
        },
        success: function (response) {
            $("#cargandoImagen").css('display', 'none')
            $('#infoTiquete').html(response);
            $("#modalInfoTiquetes").modal("show");
           
        }

    });
}

function graficoAreas() {
    $("#chart-area").empty();
    $('#tbodySolicitudClasificacionPorArea').empty();
    $.ajax({
        data: {'graficoPieTiquetesEstado': true},
        type: 'POST',
        url: '../control/SolicitudAjaxReporteTiquetesEstado.php',
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
                cantidad.push(vector[i]['cantidad']);
                descripcion.push(vector[i]['descripcion']);
                r = Math.floor(Math.random() * 200);
                g = Math.floor(Math.random() * 200);
                b = Math.floor(Math.random() * 200);
                color = 'rgb(' + r + ', ' + g + ', ' + b + ')';
                colores.push(color);
                var fila = '<tr onclick="FiltrarTiquete(\'' + vector[i]['descripcion'] + '\')"><td>' + vector[i]['descripcion'] + '</td><td>' + vector[i]['cantidad'] + '</td></tr>';
                $('#tbodySolicitudClasificacionPorEstado').append(fila);

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
                var canvas = document.getElementById("chart-area");
                var myNewChart=window.myPie = new Chart(ctx, config);
                canvas.onclick = function (evt) {
                    var activePoints = myNewChart.getElementsAtEvent(evt);
                    if (activePoints[0]) {
                        var chartData = activePoints[0]['_chart'].config.data;
                        var idx = activePoints[0]['_index'];

                        var label = chartData.labels[idx];                        
                        FiltrarTiquete(label);
                    }
                };
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
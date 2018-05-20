<?php


if (isset($_POST['panel'])) {
    $id = $_POST['panel'];
    cargarContenido($id);
}



function cargarContenido($id) {
    switch ($id) {
        case "tiquetes1":
            tiquetes1();
            break;
        case "tiquetes2":
            tiquetes2();
            break;
        case "tiquetes3":
            tiquetes3();
            break;
        case "tiquetes4":
            break;
    }
}

function tiquetes1() {
    echo '<section id = "tiquetes1">
            <h3>Creación de un tiquete</h3>
            <p>Para la creación de un tiquete se deben seguir los siguientes pasos:</p>
        </section>';
}

function tiquetes2() {
    
}

function tiquetes3() {
    
}

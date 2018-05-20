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
               tiquetes4();
            break;
        case "tiquetes5":
            
            break;
        case "cicloVidaTiquete1":
            cicloVidaTiquete1();
            break;
        case "cicloVidaTiquete2":
            break;
        case "cicloVidaTiquete3":
            break;
        case "cicloVidaTiquete4":
            break;
        case "cicloVidaTiquete5":
            break;
        
    }
}

function tiquetes1() {
    echo '<section id = "tiquetes1">
        <h3>Creación de un tiquete</h3>
        <div style = "text-align:left;">
            <p>Para la creación de un tiquete se deben seguir los siguientes pasos:</br></p>
            <h4>Paso 1:</h4>
            <p> Dirigirse a la pestaña Tiquetes -> Crear tiquete </br></p> 
            <h4>Paso 2:</h4>
            <p>Una vez en la ventana, se mostrará un formulario que se debe llenar. El primer campo nombre,
            corresponde al nombre del usuario que creará el tiquete, es un campo deshabilitado
            por lo que el usuario no tiene que modificarlo. En el siguiente espacio el usuario 
            indica la clasificación relacionada al tiquete. (Campo requerido) </br>
            El siguiente campo corresponde a la fecha en la que el usuario necesita que la solicitud ya esté 
            atendida. (Campo requerido)</br>
            El espacio de comentarios indica el motivo del tiquete. (Campo requerido) </br>
            El botón de adjuntar archivo da la posibilidad de adjuntar un archivo si fuera necesario. (Campo opcional)
            </br></p>  
            <h4>Paso 3:</h4>
            <p>Dar click en enviar</br></p>
        </div>
        </section>';
}

function tiquetes2() {
    echo '<section id = "tiquetes2">
            <h3>Ver la información de un tiquete</h3>
            <div style = "text-align:left;">
            <p>Para ver la información de un tiquete se deben seguir los siguientes pasos:</br></p>
            <h4>Paso 1:</h4>
            <p>Dirigirse a la pestaña Mis tiquetes:</p>
            <h4>Paso 2:</h4>
            <p>Por defecto,se mostrará una bandeja con los tiquetes con estado de nuevo,
            y tiquetes que están finalizados listos para calificar. Si el tiquete
            que desea ver no se encuentra 
            en la lista de tiquetes, debe realizar un filtro de búsqueda
            (ver en ayuda en linea filtrado de tiquetes)</p>        
            <h4>Paso 3:</h4>
            <p>Dar click en el ícono con un ojo (En la columna de ver, botón celeste)</p>
            <h4>Paso 4:</h4>
            <p>Al dar click se redireccionará la página a una nueva con toda la información del tiquete seleccionado.</p>
 </div>       
</section>';
}

function tiquetes3() {
    echo '<section id = "tiquetes3">
            <h3>Ver el historial de un tiquete</h3>
            <div style = "text-align:left;">
            <p>Para ver el historial de un tiquete se deben seguir los siguientes pasos:</br></p>
            <h4>Paso 1:</h4>
            <p>Dirigirse a la pestaña Mis tiquetes:</p>
            <h4>Paso 2:</h4>
            <p>Por defecto,se mostrará una bandeja con los tiquetes con estado de nuevo,
            y tiquetes que están finalizados listos para calificar. Si el tiquete
            que desea ver no se encuentra en la lista de tiquetes,
            debe realizar un filtro de búsqueda
            (ver en ayuda en linea filtrado de tiquetes).</p>        
            <h4>Paso 3:</h4>
            <p>Dar click en la columna de historial (botón naranja)</p>
            <h4>Paso 4:</h4>
            <p>Al dar click se redireccionará la página a una nueva con toda el historial del tiquete seleccionado.</p>
 </div>       
</section>';
}


function tiquetes4() {
    echo '<section id = "tiquetes4">
            <h3>Filtrar búsqueda de tiquetes</h3>
            <div style = "text-align:left;">
            <p>Para filtrar la búsqueda de tiquetes se deben seguir los siguientes pasos:</br></p>
            <h4>Paso 1:</h4>
            <p>Dirigirse a la bandeja de tiquetes que se desea filtrar:</p>
            <h4>Paso 2:</h4>
            <p>Por defecto,se mostrará una bandeja con los tiquetes con estado de nuevo,
            y tiquetes que están finalizados listos para calificar. Si el tiquete
            que desea ver no se encuentra en la lista de tiquetes,
            debe realizar el filtro de búsqueda.</p>        
            <h4>Paso 3:</h4>
            <p>Dar click en el botón filtrar búsqueda (botón verde)</p>
            <h4>Paso 4:</h4>
            <p>El sistema mostrará una nueva pestaña con los posibles filtros a realizar. En este punto, elija los
            filtros que desea y de click en filtrar búsqueda (botón celeste).</p>
     
 </div>       
</section>';
}

function cicloVidaTiquete1() {
    echo '<section id = "tiquetes4">
            <h3>Filtrar tiquetes</h3>
            <div style = "text-align:left;">
            <p>Para filtrar la búsqueda de tiquetes se deben seguir los siguientes pasos:</br></p>
            <h4>Paso 1:</h4>
            <p>Dirigirse a la bandeja de tiquetes que se desea filtrar:</p>
            <h4>Paso 2:</h4>
            <p>Por defecto,se mostrará una bandeja con los tiquetes con estado de nuevo,
            y tiquetes que están finalizados listos para calificar. Si el tiquete
            que desea ver no se encuentra en la lista de tiquetes,
            debe realizar el filtro de búsqueda.</p>        
            <h4>Paso 3:</h4>
            <p>Dar click en el botón filtrar búsqueda (botón verde)</p>
            <h4>Paso 4:</h4>
            <p>El sistema mostrará una nueva pestaña con los posibles filtros a realizar. En este punto, elija los
            filtros que desea y de click en filtrar búsqueda (botón celeste).</p>
     
 </div>       
</section>';
}

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
            tiquetes5();
            break;
        case "tiquetes6":
            tiquetes6();
            break;
        case "tiquetes7":
            tiquetes7();
            break;
        case "tiquetes8":
            tiquetes8();
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

function tiquetes5() {
    echo '<section id = "tiquetes5">
            <h3>Bandeja mis tiquetes</h3>     
            <div style = "text-align:left;">
            <p>Muestar la lista de tiquetes que el usuario logueado ha creado. <br> Para ver mis tiquetes 
            en el menú principal da click a Tiquetes -> Mis tiquetes </p></div>
    </section>';
}

function tiquetes6() {
    echo '<section id = "tiquetes6">
            <h3>Bandeja tiquetes por asignar</h3>  
            <div style = "text-align:left;">
            <p>Muestra la lista de tiquetes que han sido creados pero aún, no han sido asignados a un responsable.<br>
            Para ver los tiquetes por asignar ir al menú principal da click a Administración de tiquetes -> Asignar tiquetes </p>  
            </div>      
</section>';
}

function tiquetes7() {
    echo '<section id = "tiquetes7">
            <h3>Bandeja tiquetes asignados</h3> 
             <div style = "text-align:left;">
            <p>Muestra la lista de tiquetes que me han sido asignados. <br>
            Para ver mis tiquetes asignados ir al menú principal y dar click a Administración de tiquetes -> tiquetes asignados </p>
 </div>       
</section>';
}

function tiquetes8() {
    echo '<section id = "tiquetes8">
        <h3>Bandeja todos los tiquetes</h3>
        <div style = "text-align:left;">            
            <p>Muestra la lista de los tiquetes que han sido creados. En un principio la bandeja de 
            tiquetes está vacía. Para mostrar los tiquetes realice un filtro de búsqueda (ver filtrar búsqueda de tiquetes)
            .</p>     
 </div>       
</section>';
}

function cicloVidaTiquete1() {
    echo '<section id = "cicloVidaTiquete1">
            <h3>¿Cómo asignar un tiquete?</h3>
            <div style = "text-align:left;">
            <p>Hay dos manera de asignar un tiquete, estás son desde la bandeja de tiquetes por asignar o desde donde se muestra la información del tiquete.</br></p>
            <h4>Desde la bandeja de tiquetes por asignar:</h4>
            <p>Dirigirse a la bandeja de tiquetes por asignar :</p>
            <h4>Paso 1:</h4>
            <p>Cada tiquete muestra un combo con las posibles personas a las que se le puede asignar el tiquete.</p>        
            <h4>Paso 2:</h4>
            <p>Dar click en el combo y elija a la persona a la que le desea asignar el tiquete</p>
            <h4>Paso 3:</h4>
            <p>Una vez asignado el tiquete, este desaparecerá de la bandeja de tiquetes por asignar.</p>
            
            <h4>Desde la información del tiquete:</h4>
            <p>Estando en la visualización del tiquete:</p>
            <h4>Paso 1:</h4>
            <p>Asegurarse que el combo de arriba se encuentra en la opción tiquetes por asignar.</p>        
            <h4>Paso 2:</h4>
            <p>Ir a la parte inferior del tiquete. Se visualizará un botón celeste que dice asignar </p>
            <h4>Paso 3:</h4>
            <p>Dar click en el botón asignar. Se abrirá una ventana con las posibles personas a las que se le pueden asignar la tarea, elija una y de click en aceptar.</p>
     
 </div>       
</section>';
}

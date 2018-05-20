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
        case "cicloVidaTiquete1":
            cicloVidaTiquete1();
            break;
        case "cicloVidaTiquete2":
            cicloVidaTiquete2();
            break;
        case "cicloVidaTiquete3":
            cicloVidaTiquete3();
            break;
        case "cicloVidaTiquete4":
            cicloVidaTiquete4();
            break;
        case "cicloVidaTiquete5":
            cicloVidaTiquete5();
            break;
        case "cicloVidaTiquete6":
            cicloVidaTiquete6();
            break;
        case "cicloVidaTiquete7":
            cicloVidaTiquete7();
            break;
        case "administracionRolesDeUsuario1":
            administracionRolesDeUsuario1();
            break;
        case "administracionRolesDeUsuario2":
            administracionRolesDeUsuario2();
            break;

        case "administracionRolesDeUsuario3":
            administracionRolesDeUsuario3();
            break;
        case "administracionRolesDeUsuario4":
            administracionRolesDeUsuario4();
            break;
        case "administracionRolesPermisos1":
            administracionRolesPermisos1();
            break;

        case "administracionRolesPermisos2":
            administracionRolesPermisos2();
            break;
        case "administracionRolesPermisos3":
            administracionRolesPermisos3();
            break;
        case "administracionRolesPermisos4":
            administracionRolesPermisos4();
            break;
        case "administracionRolesPermisos5":
            administracionRolesPermisos5();
            break;
        case "administracionAreasClasificaciones1":
            administracionAreasClasificaciones1();
            break;
        case "administracionAreasClasificaciones2":
            administracionAreasClasificaciones2();
            break;
        case "administracionAreasClasificaciones3":
            administracionAreasClasificaciones3();
            break;
        case "administracionAreasClasificaciones4":
            administracionAreasClasificaciones4();
            break;
        case "administracionAreasClasificaciones5":
            administracionAreasClasificaciones5();
            break;
        case "administracionAreasClasificaciones6":
            administracionAreasClasificaciones6();
            break;
        case "administracionAreasClasificaciones7":
            administracionAreasClasificaciones7();
            break;
        case "administracionAreasClasificaciones8":
            administracionAreasClasificaciones8();
            break;
    }
}

//Información de los tiquetes
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

//Información del ciclo de vida de los tiquetes
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

function cicloVidaTiquete2() {
    echo '<section id = "cicloVidaTiquete2">
            <h3>¿Cómo calificar tiquete?</h3>
            <div style = "text-align:left;">    
            <p>Una vez que el tiquete ha sido finalizado el usuario puede calificar el tiquete. Para esto, hay dos manera de calificar un tiquete, estás son desde la bandeja de mis tiquetes o desde ventana donde se muestra la información del tiquete.</br></p>
            <h4>Desde la bandeja de mis tiquetes:</h4>
            <p>Dirigirse a la bandeja de mis tiquetes:</p>
            <h4>Paso 1:</h4>
            <p>Cuando un tiquete puede ser calificado, este mostrará una etiqueta (que indica calificar)
            cuando el tiquete puede ser calificado por el usuario que lo creo.  </p>        
            <h4>Paso 2:</h4>
            <p>La calificación puede ser dada de 1 a 5 estrellas, donde 1 corresponde a la 
            calificación más baja (rendimiento bajo) y la quinta estrella indica 
            la calificación máxima (rendimiento alto).
            Una vez elegida las estrellas se le mostrará una ventana emergente en donde debe indicar el motivo 
            de la calificación asignada (este campo es obligatorio).</p>
            <h4>Paso 3:</h4>
            <p>Dar click en el botón aceptar.</p>  
            <h4>Paso 4:</h4>
            <p>Una vez calificado el tiquete este desaparecerá de la bandeja de mis tiquetes. 
            Si desea ver los tiquetes que han sido calificados debe realizar un filtro de búsqueda 
            (Ver Tiquetes-> Filtrar búsqueda de tiquetes).</p>   
            <h4>Desde la información del tiquete:</h4>
            <p>Estando en la visualización del tiquete:</p>
            <h4>Paso 1:</h4>
            <p>Asegurarse que el combo de arriba de la pantalla se encuentra en la opción mis tiquetes.</p>        
            <h4>Paso 2:</h4>
            <p>Ir a la parte inferior del tiquete. Se mostrarán unas estrellas.
            La calificación puede ser dada de 1 a 5 estrellas, donde 1 corresponde a la 
            calificación más baja (rendimiento bajo) y la quinta estrella indica 
            la calificación máxima (rendimiento alto).
            Una vez elegida las estrellas se le mostrará una ventana emergente en donde debe indicar el motivo 
            de la calificación asignada (este campo es obligatorio).
            </p>
            <h4>Paso 3:</h4>
            <p>Dar click en el botón aceptar.</p> 
            <h4>Nota:</h4>
              <p>El botón que dice calificar enfoca las estrellas, esto para indicar al usuario en donde debe calificar.</p> 
        </div>       
       </section>';
}

function cicloVidaTiquete3() {
    echo '<section id = "cicloVidaTiquete3">
            <h3>¿Cómo reprocesar tiquete?</h3>
            <div style = "text-align:left;">    
            <p>Una vez que el tiquete ha sido finalizado, y el usuario que envió el tiquete
            considera que la tarea no está finalizada puede colocar el tiquete en reproceso, 
            esto enviará el tiquete de nuevo a la lista de tiquetes por asignar para ser evaluado nuevamente.</br></p>
            <h4>Desde la información del tiquete:</h4>
            <p>Estando en la visualización del tiquete:</p>
            <h4>Paso 1:</h4>
            <p>Asegurarse que el combo de arriba de la pantalla se encuentra en la opción mis tiquetes.</p>        
            <h4>Paso 2:</h4>
            <p>Ir a la parte inferior del tiquete. Se mostrarán un botón que indica "Reprocesar". Dar click en el botón. </p>
            <h4>Paso 3:</h4>
            <p>Se mostrará una ventana emergente, en donde se debe indicar el motivo por el cual se desea reprocesar el tiquete.</p> 
            <h4>Paso 4:</h4>
            <p>Dar click en aceptar.</p> 
        </div>       
       </section>';
}

function cicloVidaTiquete4() {
    echo '<section id = "cicloVidaTiquete4">
            <h3>¿Cómo anular tiquete?</h3>
            <div style = "text-align:left;"> 
            <p>
                Una vez que el tiquete ha sido puesto en proceso, el responsable
                puede anular el tiquete cuando la tarea del tiquete no es clara.       
            </p>
            <h4>Desde la información del tiquete:</h4>
            <h4>Paso 1:</h4>
            <p>Asegurarse que el combo de arriba de la pantalla se encuentra en la opción tiquetes asignados.</p>        
            <h4>Paso 2:</h4>
            <p>Ir a la parte inferior del tiquete. Se mostrarán un botón que indica "Anular". Dar click en el botón. </p>
            <h4>Paso 3:</h4>
            <p>Se mostrará una ventana emergente, en donde se debe indicar 
            un comentario indicando el motivo por el cual se está anulando el tiquete.</p> 
            <h4>Paso 4:</h4>
            <p>Dar click en aceptar.</p>  
        </div>       
       </section>';
}

function cicloVidaTiquete5() {
    echo '<section id = "cicloVidaTiquete5">
            <h3>¿Cómo finalizar un tiquete?</h3>
            <div style = "text-align:left;">   
            <p>
                Una vez que el tiquete ha sido puesto en proceso, el responsable
                puede finalizar el tiquete cuando la tarea del tiquete haya sido
                realizada.
                <b>Restricción</b>
                Para colocar el tiquete en proceso, es necesario que el tiquete
                tenga una cantidad de horas trabajadas. Sí las horas trabajadas 
                son cero, el tiquete no podrá ser finalizado.
                </br>
            </p>
            <h4>Desde la información del tiquete:</h4>
            <h4>Paso 1:</h4>
            <p>Asegurarse que el combo de arriba de la pantalla se encuentra en la opción tiquetes asignados.</p>        
            <h4>Paso 2:</h4>
            <p>Ir a la parte inferior del tiquete. Se mostrarán un botón que indica "Finalizar". Dar click en el botón. </p>
            <h4>Paso 3:</h4>
            <p>Se mostrará una ventana emergente, en donde se debe indicar un comentario de finalización del tiquete.</p> 
            <h4>Paso 4:</h4>
            <p>Dar click en aceptar.</p>  
        </div>       
       </section>';
}

function cicloVidaTiquete6() {
    echo '<section id = "cicloVidaTiquete6">
            <h3>¿Cómo reasignar tiquete?</h3>
            <div style = "text-align:left;">  
              <p>
                Una vez que el tiquete ha sido asignado a un responsable, 
                pero dicho tiquete, por algún motivo,
                no corresponde al área asignada este puede ser reasignado.
                Cuando el tiquete se envía a reasignación, este tiquete regresa
                a la bandeja de tiquetes por asignar.</br>
              </p>
            <h4>Desde la información del tiquete:</h4>
            <h4>Paso 1:</h4>
            <p>Asegurarse que el combo de arriba de la pantalla se encuentra en la opción tiquetes asignados.</p>        
            <h4>Paso 2:</h4>
            <p>Ir a la parte inferior del tiquete. Se mostrarán un botón que indica "Enviar a reasignar". Dar click en el botón. </p>
            <h4>Paso 3:</h4>
            <p>Se mostrará una ventana emergente, en donde se debe indicar el motivo por el cual el tiquete debe ser reasignado.</p> 
            <h4>Paso 4:</h4>
            <p>Dar click en aceptar.</p>  
        </div>       
       </section>';
}

function cicloVidaTiquete7() {
    echo '<section id = "cicloVidaTiquete7">
            <h3>¿Cómo procesar un tiquete?</h3>
            <div style = "text-align:left;">  
            <p>Una vez que el tiquete ha sido asignado a un responsable, esta persona puede colocar el tiquete en proceso.</br></p>
            <h4>Desde la información del tiquete:</h4>
            <p>Estando en la visualización del tiquete:</p>
            <h4>Paso 1:</h4>
            <p>Asegurarse que el combo de arriba de la pantalla se encuentra en la opción tiquetes asignados.</p>        
            <h4>Paso 2:</h4>
            <p>Ir a la parte inferior del tiquete. Se mostrarán un botón que indica "En proceso". Dar click en el botón. </p>
            <h4>Paso 3:</h4>
            <p>Se mostrará una ventana emergente, en donde se debe indicar la fecha en la que la solicitud del tiquete estará lista.</p> 
            <h4>Paso 4:</h4>
            <p>Dar click en aceptar.</p>             
        </div>       
       </section>';
}

//Administración del sistema
//Administracion de usuarios 
function administracionRolesDeUsuario1() {
    echo '<section id = "administracionRolesDeUsuario1">
            <h3>Visualizar usuario activos y todos los usuarios</h3>
            <div style = "text-align:left;">  
            <p>Para visualizar los usuarios activos e inactivos se deben seguir los siguientes pasos:</p>
            <h4>Paso 1:</h4>
            <p>Dirigirse a la pestaña Administración del sistema -> Administración roles de usuario.</p>
            <h4>Paso 2:</h4>
            <p>Una vez en la ventana, elegir la opción que dice "ver todos los usuarios",
            para visualizar todos los posibles responsables. En caso de que se deseen ver solo los responsables activos
            seleccionar la opción que dice: "ver usuarios activos"</p>       
        </div>       
       </section>';
}

function administracionRolesDeUsuario2() {
    echo '<section id = "administracionRolesDeUsuario2">
            <h3> Modificar el área de un responsable</h3>
            <div style = "text-align:left;">  
            <p>Para modificar el área de un responsable se deben seguir los siguientes pasos:</p>
            <h4>Paso 1:</h4>
            <p>Dirigirse a la pestaña Administración del sistema -> Administración de roles de usuario.</p>
            <h4>Paso 2:</h4>
            <p>Una vez en la ventana, se mostrará una tabla con los posibles responsables,
            en la columna que dice: "Área", dar click en el combo, se desplegarán las posibles áreas a 
            las que el usuario puede ser asociado.
            Seleccionar el área a la que el responsable pertenece.
            <h4>Paso 3:</h4>
            Aparecerá una ventana emergente de confirmación, dar click en aceptar.
            </p>            
        </div>       
       </section>';
}

function administracionRolesDeUsuario3() {
    echo '<section id = "administracionRolesDeUsuario2">
            <h3>Modificar el rol de un responsable</h3>
            <div style = "text-align:left;">  
            <p>Para modificar el rol de un responsable se deben seguir los siguientes pasos:</p>
            <h4>Paso 1:</h4>
            <p>Dirigirse a la pestaña Administración del sistema -> Administración de roles de usuario.</p>
            <h4>Paso 2:</h4>
            <p>Una vez en la ventana, se mostrará una tabla con los posibles responsables,
            en la columna que dice: "Rol", dar click en el combo. Se desplegarán los posibles roles a 
            las que el usuario puede estar asociado.
            Seleccionar el rol al que desea asociar al responsable.
            <h4>Paso 3:</h4>
            Aparecerá una ventana emergente de confirmación, dar click en aceptar.
            </p>            
        </div>       
       </section>';
}

function administracionRolesDeUsuario4() {
    echo '<section id = "administracionRolesDeUsuario4">
            <h3>Activar o desactivar responsable</h3>
            <div style = "text-align:left;">  
            <p>Para activar o desactivar a un responsable se deben seguir los siguientes pasos:</p>
            <h4>Paso 1:</h4>
            <p>Dirigirse a la pestaña Administración del sistema -> Administración de roles de usuario.</p>
            <h4>Paso 2:</h4>
            <p>Una vez en la ventana, se mostrará una tabla con los posibles responsables,
            en la columna que dice: "Activo", se muestra un botón que indica si el usuario está activo o inactivo.</p>
            <br>
            <b>Nota importante:</b> 
            <p>Si el responsable no tiene un boton de activo o inactivo es debido a 
            que el rol al que pertenece es de tipo Administrador. Un administrador no puede ser puesto 
            como inactivo.  Si la persona con este rol debe ser inactivada, entonces debe colocarse 
            a otra persona como administradora y darle al responsable que se desea inactivar otro rol.
            </p>
            <h4>Paso 3:</h4>
            <p>Dar click a activo en caso de que se desee colocar como inactivo, o inactivo en caso de que se desee colocar
            como activo.            
            </p>             
        </div>       
       </section>';
}

//Administracion de roles y permisos
function administracionRolesPermisos1() {
    echo '<section id = "administracionRolesPermisos1">
            <h3>Agregar rol</h3>
            <div style = "text-align:left;">  
            <p>Para agregar un rol se deben seguir los siguientes pasos:</p>
            <h4>Paso 1:</h4>
            <p>Dirigirse a la pestaña Administración del sistema -> Administración de roles y permisos.</p>
            <h4>Paso 2:</h4>
            <p>Una vez en la ventana, se mostrará una tabla con los permisos asociados al rol seleccionado en el combo.
            A la par del combo de roles hay un botón con un signo de más (+) Dar click en el botón. Se abrirá una ventana emergente </p>    
            <h4>Paso 3:</h4>        
            <p>En la ventana, se muestra un campo de texto para colocar el nombre del rol que se desea agregar.
            Escribir el nombre del nuevo rol y dar click en "Guardar".
            </p>                        
        </div>       
       </section>';
}

function administracionRolesPermisos2() {
    echo '<section id = "administracionRolesPermisos2">
            <h3>Eliminar rol</h3>
            <div style = "text-align:left;">  
           <p>Para eliminar un rol se deben seguir los siguientes pasos:</p>
            <h4>Paso 1:</h4>
            <p>Dirigirse a la pestaña Administración del sistema -> Administración de roles y permisos.</p>
            <h4>Paso 2:</h4>
            <p>Una vez en la ventana, se mostrará una tabla con los permisos asociados al rol seleccionado en el combo.
            A la par del combo de roles hay un botón con un signo de menos (-) Dar click en el botón. Se abrirá una ventana emergente </p>    
            <h4>Paso 3:</h4>        
            <p>En la ventana, se muestra el rol que estaba seleccionado en el combo. Dar click en "Eliminar".            
            </p>            
        </div>       
       </section>';
}

function administracionRolesPermisos3() {
    echo '<section id = "administracionRolesPermisos2">
            <h3>Visualizar usuarios asociados a un rol</h3>
            <div style = "text-align:left;">  
            <p>Para ver los usuarios asociados a un rol se deben seguir los siguientes pasos:</p>
            <h4>Paso 1:</h4>
            <p>Dirigirse a la pestaña Administración del sistema -> Administración de roles y permisos.</p>
            <h4>Paso 2:</h4>
            <p>Una vez en la ventana, se mostrará una tabla con los permisos asociados al rol seleccionado en el combo.
            Seleccionar el rol en el cual desea ver los usuarios.</p>              
            <h4>Paso 3:</h4>     
            <p> A la par del combo de roles hay un botón celeste. Dar click en el botón. Se abrirá una ventana emergente </p>                         
             <h4>Paso 4:</h4>     
            <p> Si desea ver los demás usuarios asociados a un rol, basta con cambiar en el combo de la ventana emergente el rol deseado. </p>                         
       </div>       
       </section>';
}

function administracionRolesPermisos4() {
    echo '<section id = "administracionRolesPermisos2">
            <h3>Ver permisos asociados a un rol</h3>
            <div style = "text-align:left;">  
            <p>Para ver los permisos asociados a un rol se deben seguir los siguientes pasos:</p>
            <h4>Paso 1:</h4>
            <p>Dirigirse a la pestaña Administración del sistema -> Administración de roles y permisos.</p>
            <h4>Paso 2:</h4>
            <p>Una vez en la ventana, se mostrará una tabla con permisos.             
            <h4>Paso 3:</h4>     
            <p>El combo que está arriba de la tabla corresponde a los roles. 
            Elegir el rol al que quiere ver los permisos asociados. </p>                         
             <h4>Paso 4:</h4>     
            <p>Al dar click al combo se mostrarán todos los permisos.
            Los asociados al rol son aquellos que se encuentran con un
            check en la columna de Activo.  </p>             
        </div>       
       </section>';
}

function administracionRolesPermisos5() {
    echo '<section id = "administracionRolesPermisos2">
            <h3>Asociar o desasociar permisos a roles</h3>
            <div style = "text-align:left;">  
            <p>Para asociar o desasociar un permiso a un rol se deben seguir los siguientes pasos:</p>
            <h4>Paso 1:</h4>
            <p>Dirigirse a la pestaña Administración del sistema -> Administración de roles y permisos.</p>
            <h4>Paso 2:</h4>
            <p>Una vez en la ventana, se mostrará una tabla con permisos.             
            <h4>Paso 3:</h4>     
            <p>El combo que está arriba de la tabla corresponde a los roles. 
            Elegir el rol al que quiere ver los permisos asociados. </p>                         
             <h4>Paso 4:</h4>     
            <p>Al dar click al combo se mostrarán todos los permisos.
            Los asociados al rol son aquellos que se encuentran con un
            check en la columna de Activo. Pasa desasociarlo, de click en el check. </p>                     
             <h4>Paso 5:</h4>  
                <p>De click en el botón Guardar que se encuentra debajo de la tabla 
                de permisos.  </p>  
            <h4>Paso 6:</h4>  
            <p>Se abrirá una ventana emergente indicando si desea guardar los cambios. De click en "Aceptar". </p>                  
            </p> 
        </div>       
       </section>';
}



//Administracion de areas y clasificaciones
function administracionAreasClasificaciones1(){}

function administracionAreasClasificaciones2(){}


function administracionAreasClasificaciones3(){}


function administracionAreasClasificaciones4(){}


function administracionAreasClasificaciones5(){}


function administracionAreasClasificaciones6(){}


function administracionAreasClasificaciones7(){}


function administracionAreasClasificaciones8(){}

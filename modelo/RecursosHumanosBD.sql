 create table RecursosHumanos(
 nombreUsuario varchar(100),
 departamento varchar(100),
 jefatura varchar(100),
 correo varchar(100),
 codigoEmpleado varchar(50),
 numeroCedula int
 )
 GO


--Obtiene los datos de un empleado de la tabla de recursos humanos
--Recupera datos para el UsuarioLogueado.php, cuando el usuario no pertenece al departamento de TI
-- agregarTiquete
CREATE PROCEDURE PAobtenerDatosUsuario  
	@correo varchar(50)  
AS  
    SET NOCOUNT ON;
	select nombreUsuario, departamento, jefatura, correo, codigoEmpleado, numeroCedula from RecursosHumanos where @correo = correo;
GO
--exec PAobtenerDatosUsuario 'nubeblanca1997@outlook.com';


--Para llenar el combo de usuarios cuando se quiere asociar un activo 
CREATE PROCEDURE PAobtenerUsuariosParaAsociar   
AS  
    SET NOCOUNT ON;
	select nombreUsuario, departamento, jefatura, correo, codigoEmpleado, numeroCedula from RecursosHumanos;
GO
--exec PAobtenerUsuariosParaAsociar;



insert into RecursosHumanos (nombreUsuario, departamento, jefatura, correo, codigoEmpleado, numeroCedula) values ('Cristina Cascante', 'Tecnología de la Información', 'Cristina Cascante', 'nubeblanca1997@outlook.com', '12b3', 409860347);
insert into RecursosHumanos (nombreUsuario, departamento, jefatura, correo, codigoEmpleado, numeroCedula) values ('Luis González', 'Tecnología de la Información', 'Cristina Cascante', 'francini113@gmail.com', '1b65', 167829654);
insert into RecursosHumanos (nombreUsuario, departamento, jefatura, correo, codigoEmpleado, numeroCedula) values ('Alejandro Morales', 'Tecnología de la Información', 'Cristina Cascante', 'dannyalfvr97@gmail.com', '4g54',678262731);
insert into RecursosHumanos (nombreUsuario, departamento, jefatura, correo, codigoEmpleado, numeroCedula) values ('Gina Chacón', 'Tecnología de la Información', 'Cristina Cascante', 'gina@gmail.com', '787t',109870654);
 

 DROP TABLE RecursosHumanos;

DROP PROCEDURE PAobtenerDatosUsuario;
DROP PROCEDURE PAobtenerUsuariosParaAsociar;        --Simula recursos humanos


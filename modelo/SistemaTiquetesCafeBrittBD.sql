--Empresa BrittShop Costa Rica S.A

--Creacion de tablas

--Creaci?n de la tabla Permiso
CREATE TABLE Permiso(
 codigoPermiso int NOT NULL,
 descripcionPermiso varchar(100) NOT NULL,
 CONSTRAINT PKPermiso PRIMARY KEY(codigoPermiso),
 )
 GO
ALTER TABLE Permiso   
ADD CONSTRAINT AK_Permiso UNIQUE (descripcionPermiso);   
GO

--Creaci?n de la tabla Rol
CREATE TABLE Rol(
 codigoRol int NOT NULL IDENTITY(1,1),
 nombreRol varchar(100) NOT NULL,
 CONSTRAINT PKRol PRIMARY KEY(codigoRol),
 )
 GO
ALTER TABLE Rol   
ADD CONSTRAINT AK_Rol UNIQUE (nombreRol);   
GO

 --Creaci?n de la tabla RolPermisos
CREATE TABLE RolPermiso(
 codigoRol int NOT NULL,
 codigoPermiso int NOT NULL,
 CONSTRAINT PKRolPermiso PRIMARY KEY(codigoRol,codigoPermiso),
 CONSTRAINT FKRolPermisoPermiso FOREIGN KEY (codigoPermiso) REFERENCES Permiso(codigoPermiso),
 CONSTRAINT FKRolPermisoRol  FOREIGN KEY (codigoRol) REFERENCES Rol(codigoRol),
 )
 GO

 --Creaci?n de la tabla   Area
 CREATE TABLE Area(
 codigoArea int NOT NULL IDENTITY(1,1),
 nombreArea varchar(50) NOT NULL,
 activo bit NOT NULL,
 CONSTRAINT PKArea PRIMARY KEY(codigoArea),
 )
 GO
ALTER TABLE Area   
ADD CONSTRAINT AK_Area UNIQUE (nombreArea);   
GO

--Creaci?n de la tabla Responsable
CREATE TABLE Responsable(
 codigoResponsable int NOT NULL IDENTITY(1,1),
 codigoRol int,
 loginActivo bit NOT NULL, 
 codigoEmpleado varchar(30) NOT NULL,
 nombreResponsable varchar(30) NOT NULL, 
 codigoArea int,
 correo varchar(50) NOT NULL,
 CONSTRAINT PKResponsable PRIMARY KEY(codigoResponsable),
 CONSTRAINT FKResponsableRol FOREIGN KEY (codigoRol) REFERENCES Rol(codigoRol),
CONSTRAINT FKResponsableArea FOREIGN KEY (codigoArea) REFERENCES Area(codigoArea)
 )
 GO
ALTER TABLE Responsable   
ADD CONSTRAINT AK_Responsable UNIQUE (codigoEmpleado, correo);   
GO

 --Creaci?n de la tabla  Estado
CREATE TABLE Estado(
 codigoEstado int NOT NULL,
 nombreEstado varchar(30) NOT NULL,
 enviaCorreos bit NOT NULL,
  CONSTRAINT PKEstado PRIMARY KEY(codigoEstado),
 )
 GO
ALTER TABLE Estado   
ADD CONSTRAINT AK_Estado UNIQUE (nombreEstado);   
GO

 --Creaci?n de la tabla  EstadoPermitido
CREATE TABLE EstadoPermitido(
 codigoEstadoActual int NOT NULL,
 codigoEstadoSiguiente int NOT NULL,
 CONSTRAINT PKEstadoPermitido PRIMARY KEY(codigoEstadoActual,codigoEstadoSiguiente),
 CONSTRAINT FKEstadoPermitidoEstadoActual FOREIGN KEY (codigoEstadoActual) REFERENCES Estado(codigoEstado),
 CONSTRAINT FKEstadoPermitidoEstadoSiguiente FOREIGN KEY (codigoEstadoSiguiente) REFERENCES Estado(codigoEstado),
 )
 GO


 --Creaci?n de la tabla  Indicadores 
 CREATE TABLE Indicadores(
 codigoIndicador int NOT NULL,
 descripcionIndicador varchar(100) NOT NULL,
 CONSTRAINT PKIndicadores PRIMARY KEY(codigoIndicador),
 )
 GO
ALTER TABLE Indicadores   
ADD CONSTRAINT AK_Indicadores UNIQUE (descripcionIndicador);   
GO

  --Creaci?n de la tabla  Tiquete falta Clasificacion
 CREATE TABLE Clasificacion(
 codigoClasificacion int NOT NULL IDENTITY(1,1),
 descripcionClasificacion varchar(50) NOT NULL,
 activo bit NOT NULL,
 codigoPadre int NOT NULL,
 CONSTRAINT PKClasificacion PRIMARY KEY(codigoClasificacion)
 )
 GO
ALTER TABLE Clasificacion   
ADD CONSTRAINT AK_Clasificacion UNIQUE (descripcionClasificacion);   
GO

  --Creaci?n de la tabla AreaClasificacion
 CREATE TABLE AreaClasificacion(
 codigoArea int NOT NULL,
 codigoClasificacion int NOT NULL,
 CONSTRAINT PKAreaClasificacion PRIMARY KEY(codigoArea,codigoClasificacion),
 CONSTRAINT FKAreaClasificacionArea FOREIGN KEY (codigoArea) REFERENCES Area(codigoArea),
 CONSTRAINT FKAreaClasificacionClasificacion FOREIGN KEY (codigoClasificacion) REFERENCES Clasificacion(codigoClasificacion),
 )
 GO

 
 CREATE TABLE PrioridadTiquete(
 codigoPrioridad int NOT NULL,
 nombrePrioridad varchar(100) UNIQUE,
 CONSTRAINT PKPrioridadTiquete PRIMARY KEY(codigoPrioridad)
 )
 GO

   --Creaci?n de la tabla  Tiquete falta terminar 
CREATE TABLE Tiquete(
 codigoTiquete int NOT NULL identity(1, 1),
 usuarioIngresaTiquete varchar(100) NOT NULL,   --Correo 
 codigoEstado int NOT NULL,
 codigoResponsable int,
 codigoArea int,
 codigoClasificacion int ,
 fechaCreacion datetime,
 fechaFinalizado datetime,
 fechaCalificado datetime,
 fechaSolicitado datetime,
 fechaEnProceso datetime,
 fechaEntrega datetime,
 descripcion ntext,
 calificacion int,
 horasTrabajadas float,
 nombreUsuarioSolicitante varchar(100),
 departamentoUsuarioSolicitante varchar(60),
 jefaturaUsuarioSolicitante varchar(100), 
 codigoPrioridad int,
 CONSTRAINT PKTiquete PRIMARY KEY(codigoTiquete),
 CONSTRAINT FKTiqueteResponsable FOREIGN KEY (codigoResponsable) REFERENCES Responsable(codigoResponsable),
 CONSTRAINT FKTiqueteEstado FOREIGN KEY (codigoEstado) REFERENCES Estado(codigoEstado),
 CONSTRAINT FKTiqueteClasificacion FOREIGN KEY (codigoClasificacion) REFERENCES Clasificacion(codigoClasificacion),
 CONSTRAINT FKTiqueteArea FOREIGN KEY (codigoArea) REFERENCES Area(codigoArea),
 CONSTRAINT FKTiquetePrioridadTiquete FOREIGN KEY (codigoPrioridad) REFERENCES PrioridadTiquete(codigoPrioridad)
  )
 GO
 --ALTER TABLE Tiquete ADD fechaEntrega datetime;  
 
 --Creacion de la tabla HistorialTiquete
 CREATE TABLE HistorialTiquete(
 codigoHistorial int NOT NULL identity(1, 1),
 codigoTiquete int NOT NULL,
 codigoIndicador int NOT NULL,
 comentarioUsuario ntext,
 fechaHora dateTime,
 correoUsuarioCausante varchar(100) NOT NULL,
 nombreUsuarioCausante varchar(100) NOT NULL,
 codigoResponsable varchar(100),
 aclaracionSistema ntext,
 direccionAdjunto varchar(500),
 CONSTRAINT PKHistorialTiquete PRIMARY KEY(codigoHistorial),
 CONSTRAINT FKHistorialTiqueteTiquete FOREIGN KEY (codigoTiquete) REFERENCES Tiquete(codigoTiquete),
 CONSTRAINT FKHistorialTiqueteIndicador  FOREIGN KEY (codigoIndicador) REFERENCES Indicadores(codigoIndicador),
 )
 GO
 --drop table HistorialTiquete;

 create table RecursosHumanos(
 nombreUsuario varchar(100),
 departamento varchar(60),
 jefatura varchar(100),
 correo varchar(100),
 codigoEmpleado varchar(50)
 )
 GO
 
--Creaci?n de un procedimiento almacenado, no hay que ponerle return, ?l devuelve cosas como una funci?n almacenada
CREATE PROCEDURE PAconsultarPermisos   
AS  
    SET NOCOUNT ON;
    select codigoPermiso, descripcionPermiso from dbo.Permiso;  
GO

--verifica que un rol se asocia con un permiso
CREATE PROCEDURE [dbo].[PAverificarRolPermiso]   
    @cR int,   
    @cP int 
AS  
    SET NOCOUNT ON;                   --para que no se devuelva el recuento
    select codigoRol, codigoPermiso from dbo.RolPermiso 
	where codigoRol = @cR AND codigoPermiso = @cP;  

GO

--Devuelve todos los roles que hay en la base 
CREATE PROCEDURE PAconsultarRoles   
AS  
    SET NOCOUNT ON;
    select codigoRol, nombreRol from dbo.Rol;  
GO

--Obtiene un unico responsable
CREATE PROCEDURE PAobtenerResponsable  
	@correo varchar(50)  
AS  
    SET NOCOUNT ON;
	select resp.codigoRol, resp.codigoEmpleado, resp.nombreResponsable, resp.loginActivo, resp.codigoArea, area.nombreArea, area.activo, rol.nombreRol, resp.correo from
	(select codigoArea, nombreArea, activo from dbo.Area) area,
	(select codigoRol, nombreRol from dbo.Rol) rol,
    (select codigoRol, loginActivo, codigoEmpleado, nombreResponsable, codigoArea, correo from dbo.Responsable where loginActivo != 0 AND correo = @correo) resp 
	where area.codigoArea = resp.codigoArea AND rol.codigoRol =resp.codigoRol;
GO

--Obtiene el listado de todos los empleados de TI
CREATE PROCEDURE PAobtenerResponsables   
AS  
    SET NOCOUNT ON;
	select resp.codigoRol, resp.codigoEmpleado, resp.nombreResponsable, resp.loginActivo, resp.codigoArea, area.nombreArea, area.activo, rol.nombreRol, resp.correo from
	(select codigoArea, nombreArea, activo from dbo.Area) area,
	(select codigoRol, nombreRol from dbo.Rol) rol,
    (select codigoRol, loginActivo, codigoEmpleado, nombreResponsable, codigoArea, correo from dbo.Responsable where loginActivo != 0) resp 
	where area.codigoArea = resp.codigoArea AND rol.codigoRol =resp.codigoRol;
GO

--Obtener los permisos que un rol tiene asignados
CREATE PROCEDURE PAobtenerPermisosAsignadosRol
	@cR int    
AS  
    SET NOCOUNT ON;
	select rolPer.codigoPermiso from
	(select codigoRol, codigoPermiso from dbo.RolPermiso where codigoRol = @cR) rolPer,
	(select codigoRol from dbo.Rol) rol 
	where rol.codigoRol =rolPer.codigoRol;
GO

--Actualiza el rol de un responsable
CREATE PROCEDURE PAactualizarRolResponsable
	@cR int,
	@codiEmp varchar(30),
	@men int output
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
	 DECLARE
		@coE varchar(30)
		SET @coE = ISNULL((select UPPER(REPLACE(codigoEmpleado,' ','')) from dbo.Responsable where UPPER(REPLACE(@codiEmp,' ','')) = UPPER(REPLACE(codigoEmpleado,' ',''))), 'Error');
        IF @coE = 'Error'
        BEGIN
            Set @men = 2;
        END;

        UPDATE dbo.Responsable 
		SET codigoRol = @cR
		WHERE codigoEmpleado = @codiEmp;

    COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
		Set @men = 1; -- N'Ha ocurrido un error en la actualización.'
    END;
END CATCH;
GO

--Insertar una fila en la tabla RolPermiso
CREATE PROCEDURE PAinsertarPermisoRol
	@codiRol int,
	@codiPer int,
	@men int output	
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		insert into dbo.RolPermiso(codigoRol, codigoPermiso) values (@codiRol, @codiPer);

    COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
		SET @men = 1;
    END;
END CATCH;
GO

--Eliminar una fila de la tabla RolPermisos
CREATE PROCEDURE PAeliminarPermisoRol
	@codiRol int,
	@codiPer int,
	@men int output	
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		DECLARE
		@coE int
		SET @coE = ISNULL((select codigoRol from dbo.RolPermiso where codigoRol = @codiRol AND codigoPermiso = @codiPer), -1);
        IF @coE = -1
        BEGIN
            Set @men = 2;
        END;
		delete from dbo.RolPermiso where codigoRol = @codiRol AND codigoPermiso = @codiPer;

    COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
		SET @men = 1;
    END;
END CATCH;
GO

-- Procedimiento para agregar un rol a la tabla Rol
CREATE PROCEDURE PAagregarRol
	@nomRol varchar(20),
	@men int output
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
    DECLARE
    @nombre varchar(20)
    SET @nombre = ISNULL((select UPPER(REPLACE(nombreRol,' ','')) from dbo.Rol where UPPER(REPLACE(@nomRol,' ','')) = UPPER(REPLACE(nombreRol,' ',''))), 'Error');
        IF @nombre != 'Error'
        BEGIN
			SET @men = 1;-- N'Ya existe un rol con el nombre ' + @nomRol;
			THROW  50001, 'Ya existe el nombre de rol', 1;
        END;

		insert into dbo.Rol (nombreRol) values (@nomRol);
		COMMIT TRANSACTION;
END TRY
BEGIN CATCH
     ROLLBACK TRANSACTION;
	 if @nombre = 'Error'
	 BEGIN
		SET @men = 2;
	 END; 
END CATCH;
GO

--eliminar un rol de la tabla Rol, determina si tiene permisos o responsables asociados y devuelve
--un mensaje de error
CREATE PROCEDURE PAeliminarRol
	@codiRol int,
	@men int output	
AS 
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		DECLARE  
		@codigo int
		SET @codigo = ISNULL((select codigoRol from dbo.Rol where codigoRol = @codiRol), -1);
        IF @codigo = -1
        BEGIN
            SET @men = 1; --No existe el codigo de rol
            THROW  50001, 'No existe el código de rol ingresado', 1;
        END;

        delete from dbo.Rol where codigoRol = @codiRol;
        COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @codigo != -1
    BEGIN
        SET @men = 3; -- N'El rol tiene permisos o usuarios asociados';
	END;
END CATCH;
GO

-- Procedimiento para agregar un responsable a la tabla Responsable
CREATE PROCEDURE PAagregarResponsable
	@codRol int,
    @codEmp varchar(30),
    @nombre varchar(30),
    @codArea int,
    @corr varchar(50),
	@men int output
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
    DECLARE
    @coE varchar(30)
    SET @coE = ISNULL((select UPPER(REPLACE(codigoEmpleado,' ','')) from dbo.Responsable where UPPER(REPLACE(@codEmp,' ','')) = UPPER(REPLACE(codigoEmpleado,' ',''))), 'Error');
        IF @coE != 'Error'
        BEGIN
            SET @men = 1; -- N'Ya existe un usuario con el código de empleado ' + @codEmp;
            THROW  50001, 'Ya existe un usuario con ese código', 1;
        END;

        insert into dbo.Responsable(codigoRol, loginActivo, codigoEmpleado, nombreResponsable, codigoArea, correo) values (@codRol, 1,@codEmp, @nombre, @codArea, @corr);
        COMMIT TRANSACTION;
    
END TRY
BEGIN CATCH
     ROLLBACK TRANSACTION;
	 IF @coE = 'Error'
	 BEGIN
		SET @men = 2;
	 END;
END CATCH;
GO

--Procedimiento para inactivar un responsable de la tabla de responsables
CREATE PROCEDURE PAinactivarResponsable
    @codiEmp varchar(30),
	@men int output
AS 
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
    DECLARE
    @coE varchar(30)
    SET @coE = ISNULL((select UPPER(REPLACE(codigoEmpleado,' ','')) from dbo.Responsable where UPPER(REPLACE(@codiEmp,' ','')) = UPPER(REPLACE(codigoEmpleado,' ',''))), 'Error');
        IF @coE = 'Error'
        BEGIN
            SET @men = 1; -- N'No existe un usuario con el código ' + @codiEmp;
            THROW  50001, 'No existe un usuario con el código', 1;
        END;

        update dbo.Responsable set loginActivo = 0 where codigoEmpleado = @codiEmp;
        COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @coE != 'Error'
    BEGIN
		SET @men = 2;
	END;

END CATCH;
GO

--Procedimiento para actualizar un responsable de la tabla de responsables

CREATE PROCEDURE PAactualizarResponsable
    @codiEmp varchar(30),
    @nombre varchar(30),
	@login bit,
    @codArea int,
    @codRol int,
    @corr varchar(50),
	@men int output
AS 
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
    DECLARE
    @coE varchar(30)
    SET @coE = ISNULL((select UPPER(REPLACE(codigoEmpleado,' ','')) from dbo.Responsable where UPPER(REPLACE(@codiEmp,' ','')) = UPPER(REPLACE(codigoEmpleado,' ',''))), 'Error');
        IF @coE = 'Error'
        BEGIN
            SET @men = 1; --'No existe un usuario con el código ' + @codiEmp;
        END;

        update dbo.Responsable set nombreResponsable = @nombre, codigoArea = @codArea, 
		loginActivo = @login, codigoRol = @codRol, correo = @corr where codigoEmpleado = @codiEmp;
        COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
        SET @men = 2; --' Ha ocurrido un error actualizando el usuario';
    END;

END CATCH;
GO

--update dbo.Responsable set nombreResponsable = 'Danny Torrance', loginActivo = 0,
--        codigoArea = 3, codigoRol = 4, correo =  'docTorrance@shinning.com' where codigoEmpleado = '5612y';

--Procedimiento para obtener todas las areas de la tabla Area
CREATE PROCEDURE PAobtenerAreas   
	@men int output
AS  
    SET NOCOUNT ON;
	BEGIN TRY

    select codigoArea, nombreArea, activo from dbo.Area; 
	 
	END TRY
BEGIN CATCH
	SET @men = 1; --'Ha ocurrido un error';
END CATCH
GO

--drop PROCEDURE PAresponsablesAsignadosRol; 
--go
CREATE PROCEDURE PAobtenerResponsablesAsignadosRol  
	@codRol int,
	@men int output
AS  
    SET NOCOUNT ON;
	BEGIN TRY

    select resp.codigoRol, resp.codigoEmpleado, resp.nombreResponsable, resp.loginActivo, resp.codigoArea, area.nombreArea, area.activo, rol.nombreRol, resp.correo from
	(select codigoArea, nombreArea, activo from dbo.Area) area,
	(select codigoRol, nombreRol from dbo.Rol) rol,
    (select codigoRol, loginActivo, codigoEmpleado, nombreResponsable, codigoArea, correo from dbo.Responsable where loginActivo != 0) resp 
	where area.codigoArea = resp.codigoArea AND rol.codigoRol =resp.codigoRol AND resp.codigoRol = @codRol;
	 
	END TRY
BEGIN CATCH
	SET @men = 1; --'Ha ocurrido un error';
END CATCH
GO

--Obtener responsable con login activo o inactivo
CREATE PROCEDURE PAobtenerResponsablesCompletos   
AS  
    SET NOCOUNT ON;
	select resp.codigoRol, resp.codigoEmpleado, resp.nombreResponsable, resp.loginActivo, resp.codigoArea, area.nombreArea, area.activo, rol.nombreRol, resp.correo from
	(select codigoArea, nombreArea, activo from dbo.Area) area,
	(select codigoRol, nombreRol from dbo.Rol) rol,
    (select codigoRol, loginActivo, codigoEmpleado, nombreResponsable, codigoArea, correo from dbo.Responsable) resp 
	where area.codigoArea = resp.codigoArea AND rol.codigoRol =resp.codigoRol;
GO

--Agregar area a la tabla de Area
CREATE PROCEDURE PAagregarArea
	@nomArea varchar(20),
	@men int output
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
    DECLARE
    @nombre varchar(20)
    SET @nombre = ISNULL((select UPPER(REPLACE(nombreArea,' ','')) from dbo.Area where UPPER(REPLACE(@nomArea,' ','')) = UPPER(REPLACE(nombreArea,' ',''))), 'Error');
        IF @nombre != 'Error'
        BEGIN
			SET @men = 1;-- N'Ya existe un area con el nombre ';
			THROW  50001, 'Ya existe el nombre de area', 1;
        END;

		insert into dbo.Area (nombreArea, activo) values (@nomArea, 1);
		COMMIT TRANSACTION;
END TRY
BEGIN CATCH
     ROLLBACK TRANSACTION;
	 if @nombre = 'Error'
	 BEGIN
		SET @men = 2;
	 END; 
END CATCH;
GO

--Procedimiento para activar un responsable de la tabla de responsables
CREATE PROCEDURE PAactivarResponsable
    @codiEmp varchar(30),
	@men int output
AS 
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
    DECLARE
    @coE varchar(30)
    SET @coE = ISNULL((select UPPER(REPLACE(codigoEmpleado,' ','')) from dbo.Responsable where UPPER(REPLACE(@codiEmp,' ','')) = UPPER(REPLACE(codigoEmpleado,' ',''))), 'Error');
        IF @coE = 'Error'
        BEGIN
            SET @men = 1; -- N'No existe un usuario con el código ' + @codiEmp;
            THROW  50001, 'No existe un usuario con el código', 1;
        END;

        update dbo.Responsable set loginActivo = 1 where codigoEmpleado = @codiEmp;
        COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @coE != 'Error'
    BEGIN
		SET @men = 2;
	END;

END CATCH;
GO

--Inactivar un area de la tabla Area
CREATE PROCEDURE PAinactivarArea
	@codiArea int,
	@men int output	
AS 
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		DECLARE  
		@codigo int
		SET @codigo = ISNULL((select codigoArea from dbo.Area where codigoArea = @codiArea), -1);
        IF @codigo = -1
        BEGIN
            SET @men = 1; --No existe el codigo de rol
            THROW  50001, 'No existe el código de area ingresado', 1;
        END;

         update dbo.Area set activo = 0 where codigoArea = @codiArea;
        COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @codigo != -1
    BEGIN
        SET @men = 3; -- N'El area tiene asociados';
	END;
END CATCH;
GO

--Activar un area de la tabla Area
CREATE PROCEDURE PAactivarArea
	@codiArea int,
	@men int output	
AS 
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		DECLARE  
		@codigo int
		SET @codigo = ISNULL((select codigoArea from dbo.Area where codigoArea = @codiArea), -1);
        IF @codigo = -1
        BEGIN
            SET @men = 1; --No existe el codigo de área
            THROW  50001, 'No existe el código de area ingresado', 1;
        END;

         update dbo.Area set activo = 1 where codigoArea = @codiArea;
        COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @codigo != -1
    BEGIN
        SET @men = 3; -- N'El area tiene asociados';
	END;
END CATCH;
GO

--Eliminar un area de la tabla Area, determina si tiene clasificaciones asociadas y devuelve
--un mensaje de error
CREATE PROCEDURE PAeliminarArea
	@codiArea int,
	@men int output	
AS 
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		DECLARE  
		@codigo int
		SET @codigo = ISNULL((select codigoArea from dbo.Area where codigoArea = @codiArea), -1);
        IF @codigo = -1
        BEGIN
            SET @men = 1; --No existe el codigo de area
            THROW  50001, 'No existe el código de area ingresado', 1;
        END;

         delete dbo.Area where codigoArea = @codiArea;
        COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @codigo != -1
    BEGIN
        SET @men = 3; -- N'El area tiene asociados';
	END;
END CATCH;
GO

CREATE PROCEDURE PAobtenerAreaAsociadaClasificacion     
    @cT int 
AS  
    SET NOCOUNT ON; 
	select are.codigoArea, are.nombreArea, are.activo from           
    (select codigoArea from dbo.AreaClasificacion 
	where codigoClasificacion = @cT) aretema,
	(select codigoArea, nombreArea, activo from dbo.Area) are
	where aretema.codigoArea = are.codigoArea;  
GO

--Actualizar el area asociada a una Clasificacion primer nivel
CREATE PROCEDURE PAactualizarAreaAsociadaClasificacion
	@codiArea int,
	@codiTema int,
	@men int output	
AS 
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		DECLARE  
		@codigo int
		SET @codigo = ISNULL((select codigoClasificacion from dbo.AreaClasificacion where codigoClasificacion = @codiTema), -1);
        IF @codigo = -1
        BEGIN
            SET @men = 1; --El codigo es de segundo nivel
            THROW  50001, 'El codigo es de segundo nivel', 1;
        END;

         update dbo.AreaClasificacion set codigoArea = @codiArea where codigoClasificacion = @codiTema;
        COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @codigo != -1
    BEGIN
        SET @men = 2; -- N'El codigo de area no es valido';
	END;
END CATCH;
GO

--DECLARE @mens int
--exec PAagregarTiquete 'nubeblanca1997@outlook.com', 3, '08/12/2017', 'Quiero que vuelva mi estupido gato', 'Cristina Cascante', 'Tecnología de la información', 'Cristina Cascante', @men = @mens output;
--PRINT @mens;
--drop procedure PAagregarTiquete;
--select * from Tiquete;

--Insertar tiquete, el estado por defecto es el nuevo
CREATE PROCEDURE PAagregarTiquete
	@usuarioIngresaTiquete varchar(50),
	@codiTema int,
	@fechaSoli datetime,
	@descripcion ntext,
	@nombreSoli varchar(100),
	@departamentoSoli varchar(60),
	@jefaturaSoli varchar(100),
	@men int output	
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		Declare
		@codiPadre int,
		@codiArea int,
		@fechaActual datetime

		SET @codiPadre = (select codigoPadre from dbo.Clasificacion where codigoClasificacion = @codiTema);
		SET @codiArea = (select codigoArea from dbo.AreaClasificacion where codigoClasificacion = @codiPadre);
		SET @fechaActual = (select GETDATE());

		insert into dbo.Tiquete(usuarioIngresaTiquete, codigoEstado, codigoArea, codigoClasificacion, 
		fechaCreacion, fechaSolicitado, descripcion, horasTrabajadas, nombreUsuarioSolicitante, 
		departamentoUsuarioSolicitante, jefaturaUsuarioSolicitante, codigoPrioridad) 
		values (@usuarioIngresaTiquete, 1, @codiArea, @codiTema, @fechaActual, @fechaSoli, @descripcion, 0.0, 
		@nombreSoli, @departamentoSoli, @jefaturaSoli, 3);
		
		COMMIT TRANSACTION;

		select codigoTiquete from dbo.Tiquete where fechaCreacion = @fechaActual;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
		SET @men = -2;
    END;
END CATCH;
GO

--select * from tiquete;
--exec PAobtenerTiquetesPorUsuario 'nubeblanca1997@outlook.com';
--drop procedure PAobtenerTiquetesPorUsuario;

CREATE PROCEDURE PAobtenerTiquetesPorUsuario   
	@correo varchar(200)
AS  
    SET NOCOUNT ON; 
	select tique.codigoTiquete, tique.usuarioIngresaTiquete, esta.codigoEstado, esta.nombreEstado,
	esta.enviaCorreos, tique.codigoResponsable, are.codigoArea, are.nombreArea, are.activo, tema.codigoClasificacion,
	tema.descripcionClasificacion, tema.activo, tema.codigoPadre, tique.fechaCreacion, tique.fechaFinalizado,
	tique.fechaCalificado, tique.fechaSolicitado, tique.fechaEnProceso, tique.descripcion, 
	tique.calificacion, tique.horasTrabajadas, tique.nombreUsuarioSolicitante, tique.departamentoUsuarioSolicitante,
	tique.jefaturaUsuarioSolicitante, tique.codigoPrioridad, pri.nombrePrioridad, tique.fechaEntrega from
	(select codigoEstado, nombreEstado, enviaCorreos from dbo.Estado where codigoEstado = 1 OR codigoEstado = 2 OR 
	codigoEstado = 4) esta, 
	(select codigoArea, nombreArea, activo from dbo.Area) are,
	(select codigoClasificacion, descripcionClasificacion, activo, codigoPadre from dbo.Clasificacion) tema,
	(select codigoTiquete, usuarioIngresaTiquete, codigoEstado, codigoResponsable, codigoArea,
	codigoClasificacion, fechaCreacion, fechaFinalizado, fechaCalificado, fechaSolicitado, fechaEnProceso, 
	descripcion, calificacion, horasTrabajadas, nombreUsuarioSolicitante, departamentoUsuarioSolicitante,
	jefaturaUsuarioSolicitante, codigoPrioridad, fechaEntrega from dbo.Tiquete where usuarioIngresaTiquete =  @correo AND
	(codigoEstado = 1 OR codigoEstado = 2 OR codigoEstado = 4)) tique,
	(select codigoPrioridad, nombrePrioridad from PrioridadTiquete) pri
	where esta.codigoEstado = tique.codigoEstado AND are.codigoArea = tique.codigoArea 
	AND tema.codigoClasificacion = tique.codigoClasificacion AND tique.codigoPrioridad = pri.codigoPrioridad;
GO


CREATE PROCEDURE PAobtenerTiquetesPorUsuarioFiltrados
	@correo varchar(50),
	@codigoEstado varchar(200),
	@fechaInicio date,
	@fechaFinal date
	 
AS  
	SET @codigoEstado = '%' + @codigoEstado + '%';
	SET @fechaFinal = (SELECT DATEADD(day, 1, @fechaFinal));

	SET NOCOUNT ON; 
	select tique.codigoTiquete, tique.usuarioIngresaTiquete, esta.codigoEstado, esta.nombreEstado,
	esta.enviaCorreos, tique.codigoResponsable, are.codigoArea, are.nombreArea, are.activo, tema.codigoClasificacion,
	tema.descripcionClasificacion, tema.activo, tema.codigoPadre, tique.fechaCreacion, tique.fechaFinalizado,
	tique.fechaCalificado, tique.fechaSolicitado, tique.fechaEnProceso, tique.descripcion, 
	tique.calificacion, tique.horasTrabajadas, tique.nombreUsuarioSolicitante, tique.departamentoUsuarioSolicitante,
	tique.jefaturaUsuarioSolicitante, tique.codigoPrioridad, pri.nombrePrioridad, tique.fechaEntrega from
	(select codigoEstado, nombreEstado, enviaCorreos from dbo.Estado where codigoEstado like @codigoEstado) esta, 
	(select codigoArea, nombreArea, activo from dbo.Area) are,
	(select codigoClasificacion, descripcionClasificacion, activo, codigoPadre from dbo.Clasificacion) tema,
	(select codigoTiquete, usuarioIngresaTiquete, codigoEstado, codigoResponsable, codigoArea,
	codigoClasificacion, fechaCreacion, fechaFinalizado, fechaCalificado, fechaSolicitado, fechaEnProceso, 
	descripcion, calificacion, horasTrabajadas, nombreUsuarioSolicitante, departamentoUsuarioSolicitante,
	jefaturaUsuarioSolicitante, codigoPrioridad, fechaEntrega from dbo.Tiquete where usuarioIngresaTiquete =  @correo AND
	codigoEstado like @codigoEstado AND fechaCreacion BETWEEN @fechaInicio AND @fechaFinal) tique,
	(select codigoPrioridad, nombrePrioridad from PrioridadTiquete) pri
	where esta.codigoEstado = tique.codigoEstado AND are.codigoArea = tique.codigoArea 
	AND tema.codigoClasificacion = tique.codigoClasificacion AND tique.codigoPrioridad = pri.codigoPrioridad;
GO

--select * from tiquete;
--exec PAobtenerTiquetesPorUsuarioFiltrados 'nubeblanca1997@outlook.com', 2, '1997-02-15', '2018-02-23';
--drop procedure PAobtenerTiquetesPorUsuarioFiltrados;

CREATE PROCEDURE PAobtenerResponsableCodigoResponsable  
	@codRes int  
AS  
    SET NOCOUNT ON;
	select resp.codigoRol, resp.codigoEmpleado, resp.nombreResponsable, resp.loginActivo, resp.codigoArea, area.nombreArea, area.activo, rol.nombreRol, resp.correo from
	(select codigoArea, nombreArea, activo from dbo.Area) area,
	(select codigoRol, nombreRol from dbo.Rol) rol,
    (select codigoResponsable, codigoRol, loginActivo, codigoEmpleado, nombreResponsable, codigoArea, correo from dbo.Responsable where codigoResponsable = @codRes) resp 
	where area.codigoArea = resp.codigoArea AND rol.codigoRol = resp.codigoRol;
GO

CREATE PROCEDURE PAobtenerEstados
AS  
    SET NOCOUNT ON;
	select codigoEstado, nombreEstado, enviaCorreos from dbo.Estado;
GO


--Obtiene las Clasificaciones padre activas
CREATE PROCEDURE PAobtenerClasificacionesPadreActivas
AS  
    SET NOCOUNT ON;
	select codigoClasificacion, descripcionClasificacion, activo, codigoPadre from dbo.Clasificacion where codigoPadre = 0 AND activo = 1;
GO


--Obtiene todas las Clasificaciones padre 
CREATE PROCEDURE PAobtenerClasificacionesPadreCompletas
AS  
    SET NOCOUNT ON;
	select codigoClasificacion, descripcionClasificacion, activo, codigoPadre from dbo.Clasificacion where codigoPadre = 0;
GO


--Obtiene las Clasificaciones hijas activas
CREATE PROCEDURE PAobtenerClasificacionesHijasActivas
	@codPadre int
AS  
    SET NOCOUNT ON;
	select codigoClasificacion, descripcionClasificacion, activo, codigoPadre from dbo.Clasificacion where codigoPadre = @codPadre AND activo = 1;
GO


--Obtiene todas las Clasificaciones hijas 
CREATE PROCEDURE PAobtenerClasificacionesHijasCompletas
	@codPadre int
AS  
    SET NOCOUNT ON;
	select codigoClasificacion, descripcionClasificacion, activo, codigoPadre from dbo.Clasificacion where codigoPadre = @codPadre;
GO


--Activar un temática de la tabla Clasificacion
CREATE PROCEDURE PAactivarClasificacion
	@codiTemaP int,
	@men int output	
AS 
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		DECLARE  
		@codigo int
		SET @codigo = ISNULL((select codigoClasificacion from dbo.Clasificacion where codigoClasificacion = @codiTemaP), -1);
        IF @codigo = -1
        BEGIN
            SET @men = 1; --No existe el codigo de temática o no es padre
            THROW  50001, 'No existe el código de temática ingresado', 1;
        END;

         update dbo.Clasificacion set activo = 1 where codigoClasificacion = @codiTemaP;
        COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @codigo != -1
    BEGIN
        SET @men = 3; -- Ocurrio un error
	END;
END CATCH;
GO

--Inactivar un temática de la tabla Clasificacion
CREATE PROCEDURE PAinactivarClasificacion
	@codiTemaP int,
	@men int output	
AS 
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		DECLARE  
		@codigo int
		SET @codigo = ISNULL((select codigoClasificacion from dbo.Clasificacion where codigoClasificacion = @codiTemaP), -1);
        IF @codigo = -1
        BEGIN
            SET @men = 1; --No existe el codigo de temática 
            THROW  50001, 'No existe el código de temática ingresado', 1;
        END;

         update dbo.Clasificacion set activo = 0 where codigoClasificacion = @codiTemaP;
        COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @codigo != -1
    BEGIN
        SET @men = 3; -- Ocurrio un error
	END;
END CATCH;
GO

--Agregar Clasificacion padre a la tabla Clasificacion y asocia con un area
CREATE PROCEDURE PAagregarClasificacionPadre
	@descTema varchar(50),
	@codiArea int,
	@men int output
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
    DECLARE
    @nombre varchar(50),
	@codigo int,
	@codigoClasificacion int
    SET @nombre = ISNULL((select UPPER(REPLACE(descripcionClasificacion,' ','')) from dbo.Clasificacion where UPPER(REPLACE(@descTema,' ','')) = UPPER(REPLACE(descripcionClasificacion,' ',''))), 'Error');
        IF @nombre != 'Error'
        BEGIN
			SET @men = 1;-- N'Ya existe una Clasificacion con el nombre ';
			THROW  50001, 'Ya existe el nombre de Clasificacion', 1;
        END;

		insert into dbo.Clasificacion (descripcionClasificacion, activo, codigoPadre) values (@descTema, 1, 0);

		
		SET @codigo = ISNULL((select codigoArea from dbo.Area where codigoArea = @codiArea), -1);
        IF @codigo = -1
        BEGIN
            SET @men = 2; --No existe el codigo de area a asociar
            THROW  50001, 'No existe el código de area ingresado', 1;
        END;

		SET @codigoClasificacion = (select codigoClasificacion from dbo.Clasificacion where UPPER(REPLACE(@descTema,' ','')) = UPPER(REPLACE(descripcionClasificacion,' ','')));
		insert into dbo.AreaClasificacion (codigoArea, codigoClasificacion) values (@codiArea, @codigoClasificacion);
		COMMIT TRANSACTION;
END TRY
BEGIN CATCH
     ROLLBACK TRANSACTION;
	 if @nombre = 'Error' AND @codigo != -1
	 BEGIN
		SET @men = 3;
	 END; 
END CATCH;
GO

--Agregar Clasificacion hija a la tabla Clasificacion
CREATE PROCEDURE PAagregarClasificacionHija
	@descTema varchar(50),
	@codPadre int,
	@men int output
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
    DECLARE
    @nombre varchar(50),
	@errorPadre int
    SET @nombre = ISNULL((select UPPER(REPLACE(descripcionClasificacion,' ','')) from dbo.Clasificacion where UPPER(REPLACE(@descTema,' ','')) = UPPER(REPLACE(descripcionClasificacion,' ',''))), 'Error');
        IF @nombre != 'Error'
        BEGIN
			SET @men = 1;-- N'Ya existe una Clasificacion con el nombre ';
			THROW  50001, 'Ya existe el nombre de Clasificacion', 1;
        END;

    SET @errorPadre = ISNULL((select codigoClasificacion from dbo.Clasificacion where codigoClasificacion = @codPadre AND codigoPadre = 0), -1);
        IF @errorPadre = -1
        BEGIN
			SET @men = 3;-- N'El codigo de padre ingresado no es un codigo valido';
			THROW  50001, 'Ya existe el nombre de Clasificacion', 1;
        END;

		insert into dbo.Clasificacion(descripcionClasificacion, activo, codigoPadre) values (@descTema, 1, @codPadre);
		COMMIT TRANSACTION;
END TRY
BEGIN CATCH
     ROLLBACK TRANSACTION;
	 if @nombre = 'Error' AND @errorPadre != -1
	 BEGIN
		SET @men = 2;
	 END; 
END CATCH;
GO


--Actualizar la descripcion de una Clasificacion de la tabla Clasificacion, las actualiza solo si esta activa 
CREATE PROCEDURE PAactualizarDescripcionClasificacion
	@codiClasificacion int,
	@descClasificacion varchar(50),
	@men int output	
AS 
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		DECLARE  
		@codigo int,
		@descIgual varchar (50)
		SET @codigo = ISNULL((select codigoClasificacion from dbo.Clasificacion where codigoClasificacion = @codiClasificacion and activo = 1), -1);
        IF @codigo = -1
        BEGIN
            SET @men = 1; --No existe el codigo de Clasificacion
            THROW  50001, 'No existe el código de Clasificacion ingresado', 1;
        END;
		
		SET @descIgual = ISNULL((select UPPER(REPLACE(descripcionClasificacion,' ','')) from dbo.Clasificacion where UPPER(REPLACE(@descClasificacion,' ','')) = UPPER(REPLACE(descripcionClasificacion,' ',''))), '-1');
        IF @descIgual != '-1'
        BEGIN
            SET @men = 2; --Ya existe una Clasificacion con esa descripcion
            THROW  50001, 'Ya existe una Clasificacion con esa descripcion', 1;
        END;
         update dbo.Clasificacion set descripcionClasificacion = @descClasificacion where codigoClasificacion = @codiClasificacion;
        COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @codigo != -1 AND @descIgual = '-1'
    BEGIN
        SET @men = 3; -- Ha ocurrido un error;
	END;
END CATCH;
GO

--Actualizar el padre de una Clasificacion hija de la tabla Clasificacion, las actualiza solo si esta activa 
CREATE PROCEDURE PAactualizarPadreClasificacion
	@codiClasificacion int,
	@codPadre int,
	@men int output	
AS 
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		DECLARE  
		@codigo int,
		@padre int
		SET @codigo = ISNULL((select codigoClasificacion from dbo.Clasificacion where codigoClasificacion = @codiClasificacion and activo = 1 and codigoPadre != 0), -1);
        IF @codigo = -1
        BEGIN
            SET @men = 1; --No existe el codigo de Clasificacion, no esta activo o la Clasificacion es padre
            THROW  50001, 'No existe el código de Clasificacion ingresado', 1;
        END;
		
		SET @padre = ISNULL((select codigoPadre from dbo.Clasificacion where codigoClasificacion = @codPadre AND codigoPadre = 0), -1);
        IF @padre = -1
        BEGIN
            SET @men = 2; --No existe un padre con el codigo que se ingreso
            THROW  50001, 'No existe un padre con el codigo que se ingreso', 1;
        END;
         update dbo.Clasificacion set codigoPadre = @codPadre where codigoClasificacion = @codiClasificacion;
        COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @codigo != -1 AND @padre != -1
    BEGIN
        SET @men = 3; -- Ha ocurrido un error;
	END;
END CATCH;
GO

--Eliminar Clasificacion, elimina solo si la Clasificacion no tiene relaciones con ningún registro de 
--otra tabla
CREATE PROCEDURE PAeliminarClasificacion
	@codiClasificacion int,
	@men int output	
AS 
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		DECLARE  
		@codigo int
		SET @codigo = ISNULL((select codigoClasificacion from dbo.Clasificacion where codigoClasificacion = @codiClasificacion), -1);
        IF @codigo = -1
        BEGIN
            SET @men = 1; --No existe el codigo de Clasificacion
            THROW  50001, 'No existe el código de Clasificacion ingresado', 1;
        END;

        delete dbo.Clasificacion where codigoClasificacion = @codiClasificacion;
        COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @codigo != -1 
    BEGIN
        SET @men = 2; -- Ha ocurrido un error;
	END;
END CATCH;
GO

--DECLARE @mens int
--exec PAeliminarClasificacion 6, @men = @mens output;
--PRINT @mens;

--select * from dbo.Clasificacion;

--Actualizar el nombre de un área de la tabla Area
CREATE PROCEDURE PAactualizarArea
	@codArea int,
	@nuevoNombre varchar(30),
	@men int output	
AS 
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		DECLARE  
		@codigo int,
		@nombre varchar(30)
		SET @codigo = ISNULL((select codigoArea from dbo.Area where codigoArea = @codArea), -1);
        IF @codigo = -1
        BEGIN
            SET @men = 1; --No existe el codigo de area
            THROW  50001, 'No existe el código de aera ingresado', 1;
        END;

		SET @nombre = ISNULL((select UPPER(REPLACE(nombreArea,' ','')) from dbo.Area where UPPER(REPLACE(@nuevoNombre,' ','')) = UPPER(REPLACE(nombreArea,' ',''))), 'Error');
        IF @nombre != 'Error'
        BEGIN
			SET @men = 2;-- N'Ya existe un area con el nombre ';
			THROW  50001, 'Ya existe el nombre de area', 1;
        END;

        update dbo.Area set nombreArea = @nuevoNombre where codigoArea = @codArea;
        COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @codigo != -1 AND @nombre = 'Error'
    BEGIN
        SET @men = 3; -- Ha ocurrido un error;
	END;
END CATCH;
GO

--DECLARE @mens int
--exec PAactualizarArea 3, 'Infraestructura', @men = @mens output;
--PRINT @mens;

--select * from dbo.Area;

--Obtener la direccion de los adjunto por el codigo de tiquete
CREATE PROCEDURE PAobtenerAdjuntosTiquete
	@codTiquete int
AS 
SET NOCOUNT ON;

    select direccionAdjunto from dbo.HistorialTiquete where codigoTiquete = @codTiquete AND codigoIndicador = 2;

GO
--exec PAobtenerAdjuntosTiquete 2;
--drop procedure PAobtenerAdjuntosTiquete;
--select * from HistorialTiquete;

--Obtiene los datos de un empleado de la tabla de recursos humanos
CREATE PROCEDURE PAobtenerDatosUsuario  
	@correo varchar(50)  
AS  
    SET NOCOUNT ON;
	select nombreUsuario, departamento, jefatura, correo, codigoEmpleado from RecursosHumanos where @correo = correo;
GO

--Procedimiento para obtener todas activas las areas de la tabla Area
CREATE PROCEDURE PAobtenerAreasActivas  
	@men int output
AS  
    SET NOCOUNT ON;
	BEGIN TRY

    select codigoArea, nombreArea, activo from dbo.Area where activo = 1; 
	 
	END TRY
BEGIN CATCH
	SET @men = 1; --'Ha ocurrido un error';
END CATCH
GO

CREATE PROCEDURE PAagregarAdjunto
	@codTiquete int,
	@comentarioUsuario ntext,
	@correoUsuarioCausante varchar(100),
	@nombreUsuarioCausante varchar(100),
	@direccionAdjunto varchar(300),
	@men int output	
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		Declare
		@error int,
		@fechaActual datetime,
		@responsable varchar(100),
		@aclaracion varchar(700)
		SET @error = ISNULL((select codigoTiquete from dbo.Tiquete where codigoTiquete = @codTiquete), -1);
        IF @error = -1
        BEGIN
            SET @men = 1; --No existe el codigo de tiquete
            THROW  50001, 'No existe el código de tiquete ingresado', 1;
        END;
		SET @fechaActual = (select GETDATE());

		SET @responsable = 
		(select resp.codigoEmpleado from 
		(select codigoResponsable, codigoEmpleado from Responsable) resp,
		(select codigoResponsable from dbo.Tiquete where codigoTiquete = @codTiquete) tiq
		where resp.codigoResponsable = tiq.codigoResponsable);

		SET @aclaracion = 'Se agregó un comentario';

		IF @direccionAdjunto != '' begin
			SET @aclaracion = @aclaracion + ' y un documento adjunto';
		END;

		IF CAST(@comentarioUsuario as varchar) = '' begin
			SET @aclaracion = 'Se agregó un documento adjunto';
		END;
		insert into dbo.HistorialTiquete(codigoTiquete, codigoIndicador, comentarioUsuario, codigoResponsable, fechaHora, 
		correoUsuarioCausante, nombreUsuarioCausante,aclaracionSistema, direccionAdjunto)
		values (@codTiquete, 2, @comentarioUsuario, @responsable, @fechaActual, @correoUsuarioCausante, 
		@nombreUsuarioCausante, @aclaracion, @direccionAdjunto);
		COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @error != 1
	BEGIN
		SET @men = 2;
	END;
END CATCH;
GO
--DECLARE @mens int
--exec PAagregarAdjunto 4, 'Sexto comentario', 'nubeblanca1997@outlook.com', 'Cristina Cascante', '', @men = @mens output;
--PRINT @mens;

--select * from HistorialTiquete;
--select * from Tiquete;
--DROP PROCEDURE PAagregarAdjunto;


CREATE PROCEDURE PAobtenerHistorialComentariosCompleto
	@codTiquete int
AS 
SET NOCOUNT ON;

    select comentarioUsuario, fechaHora, nombreUsuarioCausante, direccionAdjunto, correoUsuarioCausante 
	from dbo.HistorialTiquete where codigoTiquete = @codTiquete AND codigoIndicador = 2;

GO

--exec PAobtenerHistorialComentariosCompleto 2;
--select * from HistorialTiquete;

CREATE PROCEDURE PAobtenerComentariosFiltradosFecha
	@codTiquete int,
	@fechaInicio date,
	@fechaFinal date
AS 
SET NOCOUNT ON;

    select comentarioUsuario, fechaHora, nombreUsuarioCausante, direccionAdjunto, correoUsuarioCausante 
	from dbo.HistorialTiquete where codigoTiquete = @codTiquete AND codigoIndicador = 2
	AND fechaHora BETWEEN @fechaInicio AND @fechaFinal;

GO
--exec PAobtenerComentariosFiltradosFecha 2, '2017-01-18', '2017-12-19';
--drop procedure PAobtenerComentariosFiltradosFecha;


CREATE PROCEDURE PAasignarTiquete
	@codTiquete int,
	@codigoEmpleado varchar(50),
	@correoUsuarioCausante varchar(100),
	@nombreUsuarioCausante varchar(100),
	@men int output	
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		Declare
		@error int,
		@error2 int,
		@fechaActual datetime,
		@responsableActual varchar(60),
		@nombreResponsableNuevo varchar(60),
		@aclaracion varchar(500),
		@nombreEstadoAnterior varchar(60)

		SET @error = ISNULL((select codigoTiquete from dbo.Tiquete where codigoTiquete = @codTiquete), -1);
        IF @error = -1
        BEGIN
            SET @men = 1; --No existe el codigo de tiquete
            THROW  50001, 'No existe el código de tiquete ingresado', 1;
        END;

		SET @error2 = ISNULL((select codigoResponsable from Responsable where codigoEmpleado = @codigoEmpleado), -1);
        IF @error2 = -1
        BEGIN
            SET @men = 2; --No existe el código de empleado
            THROW  50001, 'No existe el código de empleado ingresado', 1;
        END;

		SET @fechaActual = (select GETDATE());

		SET @responsableActual = 
		(select resp.codigoEmpleado from 
		(select codigoResponsable, codigoEmpleado from Responsable) resp,
		(select codigoResponsable from dbo.Tiquete where codigoTiquete = @codTiquete) tiq
		where resp.codigoResponsable = tiq.codigoResponsable);

		SET @nombreResponsableNuevo = (select nombreResponsable from Responsable where codigoEmpleado = @codigoEmpleado);

		SET @nombreEstadoAnterior = (select nombreEstado from
		(select codigoEstado, nombreEstado from Estado) est,
		(select codigoEstado from Tiquete where codigoTiquete = @codTiquete) tiq
		where est.codigoEstado = tiq.codigoEstado);

		SET @aclaracion = 'El tiquete ' + CAST(@codTiquete as varchar) + ' fue asignado a ' + @nombreResponsableNuevo + ' código '
		+ @codigoEmpleado + ' por ' + @nombreUsuarioCausante + ' el ' + CONVERT(VARCHAR, @fechaActual, 120) +
		'. El estado del tiquete fue cambiado de ' + @nombreEstadoAnterior + ' a Asignado';

		update Tiquete SET codigoResponsable = (select codigoResponsable from Responsable where codigoEmpleado = @codigoEmpleado),
        codigoEstado = 2 where codigoTiquete = @codTiquete;

		insert into dbo.HistorialTiquete(codigoTiquete, codigoIndicador, codigoResponsable, fechaHora, 
		correoUsuarioCausante, nombreUsuarioCausante,aclaracionSistema)
		values (@codTiquete, 4, @responsableActual, @fechaActual, @correoUsuarioCausante, 
		@nombreUsuarioCausante, @aclaracion);
		COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @error != -1 AND @error2 != -1
	BEGIN
		SET @men = 3;
	END;
END CATCH;
GO

--DECLARE @mens int
--exec PAasignarTiquete 1, '1b65', 'nubeblanca1997@outlook.com', 'Cristina Cascante', @men = @mens output;
--PRINT @mens;

--select * from HistorialTiquete;
--select * from Responsable;
--select * from Tiquete;
--DROP PROCEDURE PAasignarTiquete;




CREATE PROCEDURE PAactualizarEnviaCorreoEstado
	@codigoEstado int,
	@enviaCorreos bit,
	@men int output	
AS 
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		DECLARE  
		@codigo int
		SET @codigo = ISNULL((select codigoEstado from dbo.Estado where codigoEstado = @codigoEstado), -1);
        IF @codigo = -1
        BEGIN
            SET @men = 1; 
            THROW  50001, 'No existe el estado ha actualizar', 1;
        END;
		
        update Estado SET enviaCorreos = @enviaCorreos where codigoEstado = @codigoEstado;
        COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @codigo != -1 
    BEGIN
        SET @men = 2; -- Ha ocurrido un error;
	END;
END CATCH;
GO

--DECLARE @mens int
--exec PAactualizarEnviaCorreoEstado 1, 0, @men = @mens output;
--PRINT @mens;

--select * from Estado;

CREATE PROCEDURE PAactualizarFechaSolicitada
	@codTiquete int,
	@nuevaFechaSolicitada date,
	@correoUsuarioCausante varchar(100),
	@nombreUsuarioCausante varchar(100),
	@men int output	
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		Declare
		@error int,
		@fechaActual datetime,
		@responsableActual varchar(60),
		@aclaracion varchar(500),
		@fechaAnterior datetime

		SET @error = ISNULL((select codigoTiquete from dbo.Tiquete where codigoTiquete = @codTiquete), -1);
        IF @error = -1
        BEGIN
            SET @men = 1; --No existe el codigo de tiquete
            THROW  50001, 'No existe el código de tiquete ingresado', 1;
        END;

		SET @fechaActual = (select GETDATE());
		SET @fechaAnterior = (select fechaSolicitado from Tiquete where codigoTiquete = @codTiquete);

		SET @responsableActual = 
		(select resp.codigoEmpleado from 
		(select codigoResponsable, codigoEmpleado from Responsable) resp,
		(select codigoResponsable from dbo.Tiquete where codigoTiquete = @codTiquete) tiq
		where resp.codigoResponsable = tiq.codigoResponsable);

		SET @aclaracion = 'La fecha solicitada del tiquete ' + CAST(@codTiquete as varchar) + ' fue actualizada de ' +
		CONVERT(VARCHAR, @fechaAnterior, 120) + ' a ' + CONVERT(VARCHAR, @nuevaFechaSolicitada, 120) + 
		' por ' + @nombreUsuarioCausante + ' el ' + CONVERT(VARCHAR, @fechaActual, 120);

		update Tiquete SET  fechaSolicitado = @nuevaFechaSolicitada where codigoTiquete = @codTiquete;

		insert into dbo.HistorialTiquete(codigoTiquete, codigoIndicador, codigoResponsable, fechaHora, 
		correoUsuarioCausante, nombreUsuarioCausante,aclaracionSistema)
		values (@codTiquete, 5, @responsableActual, @fechaActual, @correoUsuarioCausante, 
		@nombreUsuarioCausante, @aclaracion);
		COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @error != -1 
	BEGIN
		SET @men = 2;
	END;
END CATCH;
GO

--DECLARE @mens int
--exec PAactualizarFechaSolicitada 2, '2018-06-14', 'nubeblanca1997@outlook.com', 'Cristina Cascante', @men = @mens output;
--PRINT @mens;


--select * from HistorialTiquete;
--select * from Responsable;
--select * from Tiquete;
--DROP PROCEDURE PAactualizarFechaSolicitada;

--Obtiene los responsables filtrados por el area que se pueden asignar a un tiquete
CREATE PROCEDURE PAobtenerResponsablesAsignar
	@codigoArea int  
AS  
    SET NOCOUNT ON;
	select resp.codigoRol, resp.codigoEmpleado, resp.nombreResponsable, resp.loginActivo, resp.codigoArea, area.nombreArea, area.activo, rol.nombreRol, resp.correo from
	(select codigoArea, nombreArea, activo from dbo.Area where codigoArea = @codigoArea) area,
	(select codigoRol, nombreRol from dbo.Rol) rol,
    (select codigoRol, loginActivo, codigoEmpleado, nombreResponsable, codigoArea, correo from dbo.Responsable where loginActivo = 1 AND codigoArea = @codigoArea) resp 
	where area.codigoArea = resp.codigoArea AND rol.codigoRol =resp.codigoRol;
GO

--exec PAobtenerResponsablesAsignar 2;

--Obtiene los tiquetes que estan en estado de Nuevo o Devuelto. Para ser asignados.
--Es llamado por otro procedimiento que lo filtra de acuerdo al area a la que 
--pertenece el tiquete
CREATE PROCEDURE PAobtenerTiquetesPorAsignarArea  
	@codigoArea int
AS  
    SET NOCOUNT ON; 
	select tique.codigoTiquete, tique.usuarioIngresaTiquete, esta.codigoEstado, esta.nombreEstado,
	esta.enviaCorreos, tique.codigoResponsable, are.codigoArea, are.nombreArea, are.activo, tema.codigoClasificacion,
	tema.descripcionClasificacion, tema.activo, tema.codigoPadre, tique.fechaCreacion, tique.fechaFinalizado,
	tique.fechaCalificado, tique.fechaSolicitado, tique.fechaEnProceso, tique.descripcion, 
	tique.calificacion, tique.horasTrabajadas, tique.nombreUsuarioSolicitante, tique.departamentoUsuarioSolicitante,
	tique.jefaturaUsuarioSolicitante, tique.codigoPrioridad, pri.nombrePrioridad, tique.fechaEntrega from
	(select codigoEstado, nombreEstado, enviaCorreos from dbo.Estado where codigoEstado = 1 OR codigoEstado = 3) esta, 
	(select codigoArea, nombreArea, activo from dbo.Area where codigoArea = @codigoArea) are,
	(select codigoClasificacion, descripcionClasificacion, activo, codigoPadre from dbo.Clasificacion) tema,
	(select codigoTiquete, usuarioIngresaTiquete, codigoEstado, codigoResponsable, codigoArea,
	codigoClasificacion, fechaCreacion, fechaFinalizado, fechaCalificado, fechaSolicitado, fechaEnProceso, 
	descripcion, calificacion, horasTrabajadas, nombreUsuarioSolicitante, departamentoUsuarioSolicitante,
	jefaturaUsuarioSolicitante, codigoPrioridad, fechaEntrega from dbo.Tiquete where (codigoEstado = 1 OR codigoEstado = 3) AND codigoArea = @codigoArea) tique,
	(select codigoPrioridad, nombrePrioridad from PrioridadTiquete) pri
	where esta.codigoEstado = tique.codigoEstado AND are.codigoArea = tique.codigoArea 
	AND tema.codigoClasificacion = tique.codigoClasificacion AND tique.codigoPrioridad = pri.codigoPrioridad order by tique.codigoPrioridad;
GO
--select * from tiquete;
--exec PAobtenerTiquetesPorAsignarArea 1;
--drop procedure PAobtenerTiquetesPorAsignarArea;


CREATE PROCEDURE PAobtenerTiquetesPorAsignarTodos  
AS  
    SET NOCOUNT ON; 
	select tique.codigoTiquete, tique.usuarioIngresaTiquete, esta.codigoEstado, esta.nombreEstado,
	esta.enviaCorreos, tique.codigoResponsable, are.codigoArea, are.nombreArea, are.activo, tema.codigoClasificacion,
	tema.descripcionClasificacion, tema.activo, tema.codigoPadre, tique.fechaCreacion, tique.fechaFinalizado,
	tique.fechaCalificado, tique.fechaSolicitado, tique.fechaEnProceso, tique.descripcion, 
	tique.calificacion, tique.horasTrabajadas, tique.nombreUsuarioSolicitante, tique.departamentoUsuarioSolicitante,
	tique.jefaturaUsuarioSolicitante, tique.codigoPrioridad, pri.nombrePrioridad, tique.fechaEntrega from
	(select codigoEstado, nombreEstado, enviaCorreos from dbo.Estado where codigoEstado = 1 OR codigoEstado = 3) esta, 
	(select codigoArea, nombreArea, activo from dbo.Area) are,
	(select codigoClasificacion, descripcionClasificacion, activo, codigoPadre from dbo.Clasificacion) tema,
	(select codigoTiquete, usuarioIngresaTiquete, codigoEstado, codigoResponsable, codigoArea,
	codigoClasificacion, fechaCreacion, fechaFinalizado, fechaCalificado, fechaSolicitado, fechaEnProceso, 
	descripcion, calificacion, horasTrabajadas, nombreUsuarioSolicitante, departamentoUsuarioSolicitante,
	jefaturaUsuarioSolicitante, codigoPrioridad, fechaEntrega from dbo.Tiquete where codigoEstado = 1 OR codigoEstado = 3) tique,
	(select codigoPrioridad, nombrePrioridad from PrioridadTiquete) pri
	where esta.codigoEstado = tique.codigoEstado AND are.codigoArea = tique.codigoArea 
	AND tema.codigoClasificacion = tique.codigoClasificacion AND tique.codigoPrioridad = pri.codigoPrioridad order by tique.codigoPrioridad;
GO

--exec PAobtenerTiquetesPorAsignarTodos;
--DROP PROCEDURE PAobtenerTiquetesPorAsignarTodos;

CREATE PROCEDURE PAactualizarHorasTrabajadas
	@codTiquete int,
	@nuevasHorasTrabajadas float,
	@correoUsuarioCausante varchar(100),
	@nombreUsuarioCausante varchar(100),
	@men int output	
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		Declare
		@error int,
		@error2 int,
		@fechaActual datetime,
		@responsableActual varchar(60),
		@aclaracion varchar(500),
		@horasAnteriores float

		SET @error = ISNULL((select codigoTiquete from dbo.Tiquete where codigoTiquete = @codTiquete), -1);
        IF @error = -1
        BEGIN
            SET @men = 1; --No existe el codigo de tiquete
            THROW  50001, 'No existe el código de tiquete ingresado', 1;
        END;

		SET @error2 = 0;
		IF (select codigoEstado from Tiquete where codigoTiquete = @codTiquete) != 4 --Codigo de estado de En proceso
		BEGIN
			SET @men = 3; --El tiquete no se encuentra en proceso
			SET @error2 = -1;
			THROW  50001, '', 1;
		END;

		SET @fechaActual = (select GETDATE());
		SET @horasAnteriores = (select horasTrabajadas from Tiquete where codigoTiquete = @codTiquete);

		SET @responsableActual = 
		(select resp.codigoEmpleado from 
		(select codigoResponsable, codigoEmpleado from Responsable) resp,
		(select codigoResponsable from dbo.Tiquete where codigoTiquete = @codTiquete) tiq
		where resp.codigoResponsable = tiq.codigoResponsable);

		SET @aclaracion = 'La cantidad de horas trabajadas del tiquete ' + CAST(@codTiquete as varchar) + ' fueron actualizadas de ' +
		CAST(@horasAnteriores as varchar) + ' a ' + CAST(@nuevasHorasTrabajadas as varchar) + 
		' por ' + @nombreUsuarioCausante + ' el ' + CONVERT(VARCHAR, @fechaActual, 120);

		update Tiquete SET  horasTrabajadas = @nuevasHorasTrabajadas where codigoTiquete = @codTiquete;

		insert into dbo.HistorialTiquete(codigoTiquete, codigoIndicador, codigoResponsable, fechaHora, 
		correoUsuarioCausante, nombreUsuarioCausante,aclaracionSistema)
		values (@codTiquete, 6, @responsableActual, @fechaActual, @correoUsuarioCausante, 
		@nombreUsuarioCausante, @aclaracion);
		COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @error != -1 AND @error2 != -1
	BEGIN
		SET @men = 2;
	END;
END CATCH;
GO

--DECLARE @mens int
--exec PAactualizarHorasTrabajadas 2, 5, 'nubeblanca1997@outlook.com', 'Cristina Cascante', @men = @mens output;
--PRINT @mens;

--select * from HistorialTiquete;
--select * from Tiquete;
--DROP PROCEDURE PAactualizarHorasTrabajadas;


CREATE PROCEDURE PAactualizarClasificacionTiquete
	@codTiquete int,
	@codigoNuevaClasificacion int,
	@correoUsuarioCausante varchar(100),
	@nombreUsuarioCausante varchar(100),
	@men int output	
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		Declare
		@error int,
		@fechaActual datetime,
		@responsableActual varchar(60),
		@aclaracion varchar(500),
		@nombreClasificacionAnterior varchar(100),
		@codigoClasificacionAnterior int,
		@codigoPadre int,
		@codigoArea int

		SET @error = ISNULL((select codigoTiquete from dbo.Tiquete where codigoTiquete = @codTiquete), -1);
        IF @error = -1
        BEGIN
            SET @men = 1; --No existe el codigo de tiquete
            THROW  50001, 'No existe el código de tiquete ingresado', 1;
        END;

		SET @fechaActual = (select GETDATE());

		SET @codigoClasificacionAnterior = (select codigoClasificacion from Tiquete where codigoTiquete = @codTiquete);

		SET @nombreClasificacionAnterior = (select descripcionClasificacion from Clasificacion 
		where codigoClasificacion = @codigoClasificacionAnterior);

		SET @codigoPadre = (select codigoPadre from dbo.Clasificacion where codigoClasificacion = @codigoNuevaClasificacion);
		SET @codigoArea = (select codigoArea from dbo.AreaClasificacion where codigoClasificacion = @codigoPadre);

		SET @responsableActual = 
		(select resp.codigoEmpleado from 
		(select codigoResponsable, codigoEmpleado from Responsable) resp,
		(select codigoResponsable from dbo.Tiquete where codigoTiquete = @codTiquete) tiq
		where resp.codigoResponsable = tiq.codigoResponsable);

		SET @aclaracion = 'La clasificación del tiquete ' + CAST(@codTiquete as varchar) + ' fue actualizada de ' +
		@nombreClasificacionAnterior + ' a ' + (select descripcionClasificacion from Clasificacion
		 where codigoClasificacion = @codigoNuevaClasificacion) + 
		' por ' + @nombreUsuarioCausante + ' el ' + CONVERT(VARCHAR, @fechaActual, 120);

		update Tiquete SET codigoClasificacion = @codigoNuevaClasificacion, codigoArea = @codigoArea where codigoTiquete = @codTiquete;

		insert into dbo.HistorialTiquete(codigoTiquete, codigoIndicador, codigoResponsable, fechaHora, 
		correoUsuarioCausante, nombreUsuarioCausante,aclaracionSistema)
		values (@codTiquete, 7, @responsableActual, @fechaActual, @correoUsuarioCausante, 
		@nombreUsuarioCausante, @aclaracion);
		COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @error != -1 
	BEGIN
		SET @men = 2;
	END;
END CATCH;
GO

--DECLARE @mens int
--exec PAactualizarClasificacionTiquete 2, 14, 'nubeblanca1997@outlook.com', 'Cristina Cascante', @men = @mens output;
--PRINT @mens;

--select * from HistorialTiquete;
--select * from Tiquete;
--DROP PROCEDURE PAactualizarClasificacionTiquete;


--Obtener tiquetes asignados a un responsable prefiltrados por estado de asignado y en proceso
CREATE PROCEDURE PAobtenerTiquetesAsignados
	@codigoEmpleado varchar(100) 
AS  
    SET NOCOUNT ON; 
	select tique.codigoTiquete, tique.usuarioIngresaTiquete, esta.codigoEstado, esta.nombreEstado,
	esta.enviaCorreos, tique.codigoResponsable, are.codigoArea, are.nombreArea, are.activo, tema.codigoClasificacion,
	tema.descripcionClasificacion, tema.activo, tema.codigoPadre, tique.fechaCreacion, tique.fechaFinalizado,
	tique.fechaCalificado, tique.fechaSolicitado, tique.fechaEnProceso, tique.descripcion, 
	tique.calificacion, tique.horasTrabajadas, tique.nombreUsuarioSolicitante, tique.departamentoUsuarioSolicitante,
	tique.jefaturaUsuarioSolicitante, tique.codigoPrioridad, pri.nombrePrioridad, tique.fechaEntrega from
	(select codigoEstado, nombreEstado, enviaCorreos from dbo.Estado where codigoEstado = 2 OR codigoEstado = 4) esta, 
	(select codigoArea, nombreArea, activo from dbo.Area) are,
	(select codigoClasificacion, descripcionClasificacion, activo, codigoPadre from dbo.Clasificacion) tema,
	(select codigoTiquete, usuarioIngresaTiquete, codigoEstado, codigoResponsable, codigoArea,
	codigoClasificacion, fechaCreacion, fechaFinalizado, fechaCalificado, fechaSolicitado, fechaEnProceso, 
	descripcion, calificacion, horasTrabajadas, nombreUsuarioSolicitante, departamentoUsuarioSolicitante,
	jefaturaUsuarioSolicitante, codigoPrioridad, fechaEntrega from dbo.Tiquete where codigoEstado = 2 OR codigoEstado = 4) tique,
	(select codigoResponsable from Responsable where codigoEmpleado = @codigoEmpleado) resp,
	(select codigoPrioridad, nombrePrioridad from PrioridadTiquete) pri
	where esta.codigoEstado = tique.codigoEstado AND are.codigoArea = tique.codigoArea 
	AND tema.codigoClasificacion = tique.codigoClasificacion AND resp.codigoResponsable = tique.codigoResponsable
	AND tique.codigoPrioridad = pri.codigoPrioridad order by tique.codigoPrioridad;
GO

--DROP PROCEDURE PAobtenerTiquetesAsignados;
--select * from tiquete;
--select * from Responsable;
--exec PAobtenerTiquetesAsignados '12b3';

--Tiquetes asignados filtrados por estados
CREATE PROCEDURE PAobtenerTiquetesAsignadosFiltrados
	@codigoEmpleado varchar(100),
	@codigoEstado varchar(200),
	@fechaInicio date,
	@fechaFinal date
	 
AS  
	SET @codigoEstado = '%' + @codigoEstado + '%';
	SET @fechaFinal = (SELECT DATEADD(day, 1, @fechaFinal));

    SET NOCOUNT ON; 
	select tique.codigoTiquete, tique.usuarioIngresaTiquete, esta.codigoEstado, esta.nombreEstado,
	esta.enviaCorreos, tique.codigoResponsable, are.codigoArea, are.nombreArea, are.activo, tema.codigoClasificacion,
	tema.descripcionClasificacion, tema.activo, tema.codigoPadre, tique.fechaCreacion, tique.fechaFinalizado,
	tique.fechaCalificado, tique.fechaSolicitado, tique.fechaEnProceso, tique.descripcion, 
	tique.calificacion, tique.horasTrabajadas, tique.nombreUsuarioSolicitante, tique.departamentoUsuarioSolicitante,
	tique.jefaturaUsuarioSolicitante, tique.codigoPrioridad, pri.nombrePrioridad, tique.fechaEntrega from
	(select codigoEstado, nombreEstado, enviaCorreos from dbo.Estado where codigoEstado like @codigoEstado) esta, 
	(select codigoArea, nombreArea, activo from dbo.Area) are,
	(select codigoClasificacion, descripcionClasificacion, activo, codigoPadre from dbo.Clasificacion) tema,
	(select codigoTiquete, usuarioIngresaTiquete, codigoEstado, codigoResponsable, codigoArea,
	codigoClasificacion, fechaCreacion, fechaFinalizado, fechaCalificado, fechaSolicitado, fechaEnProceso, 
	descripcion, calificacion, horasTrabajadas, nombreUsuarioSolicitante, departamentoUsuarioSolicitante,
	jefaturaUsuarioSolicitante, codigoPrioridad, fechaEntrega from dbo.Tiquete where codigoEstado like @codigoEstado AND
	fechaCreacion BETWEEN @fechaInicio AND @fechaFinal) tique,
	(select codigoResponsable from Responsable where codigoEmpleado = @codigoEmpleado) resp,
	(select codigoPrioridad, nombrePrioridad from PrioridadTiquete) pri
	where esta.codigoEstado = tique.codigoEstado AND are.codigoArea = tique.codigoArea 
	AND tema.codigoClasificacion = tique.codigoClasificacion AND resp.codigoResponsable = tique.codigoResponsable
	AND tique.codigoPrioridad = pri.codigoPrioridad order by tique.codigoPrioridad;
GO
--exec PAobtenerTiquetesAsignadosFiltrados '12b3', 2, '2018-01-03', '2018-02-22';
--select * from Responsable;
--DROP PROCEDURE PAobtenerTiquetesAsignadosFiltrados;


--Permite actualizar el estado de un tiquete a Espera reasignación
CREATE PROCEDURE PAenviarAReasignarTiquete
	@codTiquete int,
	@justificacion ntext,
	@correoUsuarioCausante varchar(100),
	@nombreUsuarioCausante varchar(100),
	@men int output	
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		Declare
		@error int,
		@error2 int,
		@fechaActual datetime,
		@responsableActual varchar(60),
		@aclaracion varchar(1000),
		@nombreEstadoAnterior varchar(100),
		@nombreEstadoActual varchar(100),
		@codigoEstadoActual int

		SET @error = ISNULL((select codigoTiquete from dbo.Tiquete where codigoTiquete = @codTiquete), -1);
        IF @error = -1
        BEGIN
            SET @men = 1; --No existe el codigo de tiquete
            THROW  50001, 'No existe el código de tiquete ingresado', 1;
        END;

		SET @codigoEstadoActual = (select codigoEstado from Tiquete where codigoTiquete = @codTiquete);

		SET @error2 = ISNULL((select codigoEstadoSiguiente from EstadoPermitido where codigoEstadoActual = @codigoEstadoActual AND codigoEstadoSiguiente = 3), -1);
        IF @error2 = -1
        BEGIN
            SET @men = 2; --Estado siguiente no permitido
            THROW  50001, 'Estado siguiente no permitido', 1;
        END;

		SET @fechaActual = (select GETDATE());
		SET @nombreEstadoAnterior = (select est.nombreEstado from
		(select codigoEstado from Tiquete where codigoTiquete = @codTiquete) tiq,
		(select codigoEstado, nombreEstado from Estado) est
		where tiq.codigoEstado = est.codigoEstado);

		SET @nombreEstadoActual = (select nombreEstado from Estado where codigoEstado = 3);

		SET @responsableActual = 
		(select resp.codigoEmpleado from 
		(select codigoResponsable, codigoEmpleado from Responsable) resp,
		(select codigoResponsable from dbo.Tiquete where codigoTiquete = @codTiquete) tiq
		where resp.codigoResponsable = tiq.codigoResponsable);

		SET @aclaracion = 'El estado del tiquete ' + CAST(@codTiquete as varchar) + ' fue actualizado de ' +
		@nombreEstadoAnterior + ' a ' + @nombreEstadoActual + 
		' por ' + @nombreUsuarioCausante + ' el ' + CONVERT(VARCHAR, @fechaActual, 120);

		update Tiquete SET codigoEstado = 3 where codigoTiquete = @codTiquete;

		insert into dbo.HistorialTiquete(codigoTiquete, codigoIndicador, comentarioUsuario, codigoResponsable, fechaHora, 
		correoUsuarioCausante, nombreUsuarioCausante, aclaracionSistema)
		values (@codTiquete, 1, @justificacion, @responsableActual, @fechaActual, @correoUsuarioCausante, 
		@nombreUsuarioCausante, @aclaracion);
		COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @error != -1 AND @error2 != -1 
	BEGIN
		SET @men = 3;
	END;
END CATCH;
GO

--DECLARE @mens int
--exec PAenviarAReasignarTiquete 2, 'Y usted qué se cree asignándome ese tiquete a mí, yo no quiero tener nada que ver en ese asunto ni me interesa saber de los problemas de la gente, esto no es un service desk', 'nubeblanca1997@outlook.com', 'Cristina Cascante', @men = @mens output;
--PRINT @mens;

--select * from HistorialTiquete;
--select * from Tiquete;
--DROP PROCEDURE PAenviarAReasignarTiquete;

--Permite actualizar el estado de un tiquete a En proceso
CREATE PROCEDURE PAponerTiqueteEnProceso
	@codTiquete int,
	@fechaEntrega datetime,
	@correoUsuarioCausante varchar(100),
	@nombreUsuarioCausante varchar(100),
	@men int output	
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		Declare
		@error int,
		@error2 int,
		@fechaActual datetime,
		@responsableActual varchar(60),
		@aclaracion varchar(1000),
		@nombreEstadoAnterior varchar(100),
		@nombreEstadoActual varchar(100),
		@codigoEstadoActual int

		SET @error = ISNULL((select codigoTiquete from dbo.Tiquete where codigoTiquete = @codTiquete), -1);
        IF @error = -1
        BEGIN
            SET @men = 1; --No existe el codigo de tiquete
            THROW  50001, 'No existe el código de tiquete ingresado', 1;
        END;

		SET @codigoEstadoActual = (select codigoEstado from Tiquete where codigoTiquete = @codTiquete);

		SET @error2 = ISNULL((select codigoEstadoSiguiente from EstadoPermitido where codigoEstadoActual = @codigoEstadoActual 
		AND codigoEstadoSiguiente = 4), -1);
        IF @error2 = -1
        BEGIN
            SET @men = 2; --Estado siguiente no permitido
            THROW  50001, 'Estado siguiente no permitido', 1;
        END;

		SET @fechaActual = (select GETDATE());
		SET @nombreEstadoAnterior = (select est.nombreEstado from
		(select codigoEstado from Tiquete where codigoTiquete = @codTiquete) tiq,
		(select codigoEstado, nombreEstado from Estado) est
		where tiq.codigoEstado = est.codigoEstado);

		SET @nombreEstadoActual = (select nombreEstado from Estado where codigoEstado = 4);

		SET @responsableActual = 
		(select resp.codigoEmpleado from 
		(select codigoResponsable, codigoEmpleado from Responsable) resp,
		(select codigoResponsable from dbo.Tiquete where codigoTiquete = @codTiquete) tiq
		where resp.codigoResponsable = tiq.codigoResponsable);

		SET @aclaracion = 'El estado del tiquete ' + CAST(@codTiquete as varchar) + ' fue actualizado de ' +
		@nombreEstadoAnterior + ' a ' + @nombreEstadoActual + ' con fecha de entrega el ' + CONVERT(VARCHAR, @fechaEntrega, 105) + 
		', por ' + @nombreUsuarioCausante + ' el ' + CONVERT(VARCHAR, @fechaActual, 120);

		update Tiquete SET codigoEstado = 4, fechaEnProceso = @fechaActual, fechaEntrega = @fechaEntrega where codigoTiquete = @codTiquete;

		insert into dbo.HistorialTiquete(codigoTiquete, codigoIndicador, codigoResponsable, fechaHora, 
		correoUsuarioCausante, nombreUsuarioCausante, aclaracionSistema)
		values (@codTiquete, 9, @responsableActual, @fechaActual, @correoUsuarioCausante, 
		@nombreUsuarioCausante, @aclaracion);
		COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @error != -1 AND @error2 != -1 
	BEGIN
		SET @men = 3;
	END;
END CATCH;
GO

--DECLARE @mens int
--exec PAponerTiqueteEnProceso 2, '2018/02/23', 'nubeblanca1997@outlook.com', 'Cristina Cascante', @men = @mens output;
--PRINT @mens;

--select * from HistorialTiquete;
--select * from Tiquete;
--DROP PROCEDURE PAponerTiqueteEnProceso;
--update Tiquete set codigoEstado = 2 where codigoTiquete = 2;


--Permite actualizar el estado de un tiquete a Anulado
CREATE PROCEDURE PAanularTiquete
	@codTiquete int,
	@justificacion ntext,
	@correoUsuarioCausante varchar(100),
	@nombreUsuarioCausante varchar(100),
	@men int output	
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		Declare
		@error int,
		@error2 int,
		@fechaActual datetime,
		@responsableActual varchar(60),
		@aclaracion varchar(1000),
		@nombreEstadoAnterior varchar(100),
		@nombreEstadoActual varchar(100),
		@codigoEstadoActual int

		SET @error = ISNULL((select codigoTiquete from dbo.Tiquete where codigoTiquete = @codTiquete), -1);
        IF @error = -1
        BEGIN
            SET @men = 1; --No existe el codigo de tiquete
            THROW  50001, 'No existe el código de tiquete ingresado', 1;
        END;

		SET @codigoEstadoActual = (select codigoEstado from Tiquete where codigoTiquete = @codTiquete);

		SET @error2 = ISNULL((select codigoEstadoSiguiente from EstadoPermitido where codigoEstadoActual = @codigoEstadoActual 
		AND codigoEstadoSiguiente = 5), -1);
        IF @error2 = -1
        BEGIN
            SET @men = 2; --Estado siguiente no permitido
            THROW  50001, 'Estado siguiente no permitido', 1;
        END;

		SET @fechaActual = (select GETDATE());
		SET @nombreEstadoAnterior = (select est.nombreEstado from
		(select codigoEstado from Tiquete where codigoTiquete = @codTiquete) tiq,
		(select codigoEstado, nombreEstado from Estado) est
		where tiq.codigoEstado = est.codigoEstado);

		SET @nombreEstadoActual = (select nombreEstado from Estado where codigoEstado = 5);

		SET @responsableActual = 
		(select resp.codigoEmpleado from 
		(select codigoResponsable, codigoEmpleado from Responsable) resp,
		(select codigoResponsable from dbo.Tiquete where codigoTiquete = @codTiquete) tiq
		where resp.codigoResponsable = tiq.codigoResponsable);

		SET @aclaracion = 'El estado del tiquete ' + CAST(@codTiquete as varchar) + ' fue actualizado de ' +
		@nombreEstadoAnterior + ' a ' + @nombreEstadoActual + 
		' por ' + @nombreUsuarioCausante + ' el ' + CONVERT(VARCHAR, @fechaActual, 120);

		update Tiquete SET codigoEstado = 5 where codigoTiquete = @codTiquete;

		insert into dbo.HistorialTiquete(codigoTiquete, codigoIndicador, comentarioUsuario, codigoResponsable, fechaHora, 
		correoUsuarioCausante, nombreUsuarioCausante, aclaracionSistema)
		values (@codTiquete, 10, @justificacion, @responsableActual, @fechaActual, @correoUsuarioCausante, 
		@nombreUsuarioCausante, @aclaracion);
		COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @error != -1 AND @error2 != -1 
	BEGIN
		SET @men = 3;
	END;
END CATCH;
GO

--DECLARE @mens int
--exec PAanularTiquete 2, 'Este tiquete es super aburrido, no lo voy a atender', 'nubeblanca1997@outlook.com', 'Cristina Cascante', @men = @mens output;
--PRINT @mens;

--select * from HistorialTiquete;
--select * from Tiquete;
--DROP PROCEDURE PAanularTiquete;
--update Tiquete set codigoEstado = 2 where codigoTiquete = 2;


--Permite actualizar el estado de un tiquete a Finalizado
CREATE PROCEDURE PAfinalizarTiquete
	@codTiquete int,
	@explicacion ntext,
	@correoUsuarioCausante varchar(100),
	@nombreUsuarioCausante varchar(100),
	@men int output	
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		Declare
		@error int,
		@error2 int,
		@error3 int,
		@fechaActual datetime,
		@responsableActual varchar(60),
		@aclaracion varchar(1000),
		@nombreEstadoAnterior varchar(100),
		@nombreEstadoActual varchar(100),
		@codigoEstadoActual int

		SET @error = ISNULL((select codigoTiquete from dbo.Tiquete where codigoTiquete = @codTiquete), -1);
        IF @error = -1
        BEGIN
            SET @men = 1; --No existe el codigo de tiquete
            THROW  50001, 'No existe el código de tiquete ingresado', 1;
        END;

		SET @codigoEstadoActual = (select codigoEstado from Tiquete where codigoTiquete = @codTiquete);

		SET @error2 = ISNULL((select codigoEstadoSiguiente from EstadoPermitido where codigoEstadoActual = @codigoEstadoActual 
		AND codigoEstadoSiguiente = 6), -1);
        IF @error2 = -1
        BEGIN
            SET @men = 2; --Estado siguiente no permitido
            THROW  50001, 'Estado siguiente no permitido', 1;
        END;

        IF (select horasTrabajadas from Tiquete where codigoTiquete = @codTiquete) = 0
        BEGIN
			SET @error3 = -1;
            SET @men = 4; --Las horas trabajadas son 0
            THROW  50001, 'Las horas trabajadas son 0', 1;
        END;


		SET @fechaActual = (select GETDATE());
		SET @nombreEstadoAnterior = (select est.nombreEstado from
		(select codigoEstado from Tiquete where codigoTiquete = @codTiquete) tiq,
		(select codigoEstado, nombreEstado from Estado) est
		where tiq.codigoEstado = est.codigoEstado);

		SET @nombreEstadoActual = (select nombreEstado from Estado where codigoEstado = 6);

		SET @responsableActual = 
		(select resp.codigoEmpleado from 
		(select codigoResponsable, codigoEmpleado from Responsable) resp,
		(select codigoResponsable from dbo.Tiquete where codigoTiquete = @codTiquete) tiq
		where resp.codigoResponsable = tiq.codigoResponsable);

		SET @aclaracion = 'El estado del tiquete ' + CAST(@codTiquete as varchar) + ' fue actualizado de ' +
		@nombreEstadoAnterior + ' a ' + @nombreEstadoActual + 
		' por ' + @nombreUsuarioCausante + ' el ' + CONVERT(VARCHAR, @fechaActual, 120);

		update Tiquete SET codigoEstado = 6, fechaFinalizado = @fechaActual where codigoTiquete = @codTiquete;

		insert into dbo.HistorialTiquete(codigoTiquete, codigoIndicador, comentarioUsuario, codigoResponsable, fechaHora, 
		correoUsuarioCausante, nombreUsuarioCausante, aclaracionSistema)
		values (@codTiquete, 11, @explicacion, @responsableActual, @fechaActual, @correoUsuarioCausante, 
		@nombreUsuarioCausante, @aclaracion);
		COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @error != -1 AND @error2 != -1 AND @error3 != -1
	BEGIN
		SET @men = 3;
	END;
END CATCH;
GO

--DECLARE @mens int
--exec PAfinalizarTiquete 3, 'Acabo de terminar el problema del pantallazo azul que le daba a julano, espero que me paguen más por mi eficiencia', 'nubeblanca1997@outlook.com', 'Cristina Cascante', @men = @mens output;
--PRINT @mens;

--select * from HistorialTiquete;
--select * from Tiquete;
--DROP PROCEDURE PAfinalizarTiquete;
--update Tiquete set codigoEstado = 4 where codigoTiquete = 3;


--Permite actualizar el estado de un tiquete a Calificado
CREATE PROCEDURE PAcalificarTiquete
	@codTiquete int,
	@explicacion ntext,
	@correoUsuarioCausante varchar(100),
	@nombreUsuarioCausante varchar(100),
	@calificacion int,
	@men int output	
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		Declare
		@error int,
		@error2 int,
		@fechaActual datetime,
		@responsableActual varchar(60),
		@aclaracion varchar(1000),
		@nombreEstadoAnterior varchar(100),
		@nombreEstadoActual varchar(100),
		@codigoEstadoActual int

		SET @error = ISNULL((select codigoTiquete from dbo.Tiquete where codigoTiquete = @codTiquete), -1);
        IF @error = -1
        BEGIN
            SET @men = 1; --No existe el codigo de tiquete
            THROW  50001, 'No existe el código de tiquete ingresado', 1;
        END;

		SET @codigoEstadoActual = (select codigoEstado from Tiquete where codigoTiquete = @codTiquete);

		SET @error2 = ISNULL((select codigoEstadoSiguiente from EstadoPermitido where codigoEstadoActual = @codigoEstadoActual 
		AND codigoEstadoSiguiente = 7), -1);
        IF @error2 = -1
        BEGIN
            SET @men = 2; --Estado siguiente no permitido
            THROW  50001, 'Estado siguiente no permitido', 1;
        END;

		SET @fechaActual = (select GETDATE());
		SET @nombreEstadoAnterior = (select est.nombreEstado from
		(select codigoEstado from Tiquete where codigoTiquete = @codTiquete) tiq,
		(select codigoEstado, nombreEstado from Estado) est
		where tiq.codigoEstado = est.codigoEstado);

		SET @nombreEstadoActual = (select nombreEstado from Estado where codigoEstado = 7);

		SET @responsableActual = 
		(select resp.codigoEmpleado from 
		(select codigoResponsable, codigoEmpleado from Responsable) resp,
		(select codigoResponsable from dbo.Tiquete where codigoTiquete = @codTiquete) tiq
		where resp.codigoResponsable = tiq.codigoResponsable);

		SET @aclaracion = 'El estado del tiquete ' + CAST(@codTiquete as varchar) + ' fue actualizado de ' +
		@nombreEstadoAnterior + ' a ' + @nombreEstadoActual + 
		' por ' + @nombreUsuarioCausante + ' el ' + CONVERT(VARCHAR, @fechaActual, 120) + '. La calificación dada fue ' +
		CAST(@calificacion as varchar) + ' estrellas.';

		update Tiquete SET codigoEstado = 7, fechaCalificado = @fechaActual, calificacion = @calificacion where codigoTiquete = @codTiquete;

		insert into dbo.HistorialTiquete(codigoTiquete, codigoIndicador, comentarioUsuario, codigoResponsable, fechaHora, 
		correoUsuarioCausante, nombreUsuarioCausante, aclaracionSistema)
		values (@codTiquete, 12, @explicacion, @responsableActual, @fechaActual, @correoUsuarioCausante, 
		@nombreUsuarioCausante, @aclaracion);
		COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @error != -1 AND @error2 != -1 
	BEGIN
		SET @men = 3;
	END;
END CATCH;
GO

--DECLARE @mens int
--exec PAcalificarTiquete 3, 'Esta gente es por completo un montón de vagos que no hacen nada', 'nubeblanca1997@outlook.com', 'Cristina Cascante', 3, @men = @mens output;
--PRINT @mens;

--select * from HistorialTiquete;
--select * from Tiquete;
--DROP PROCEDURE PAcalificarTiquete;
--update Tiquete set codigoEstado = 6 where codigoTiquete = 2;

--Para llenar el combo de prioridades
CREATE PROCEDURE PAobtenerPrioridades
AS
SET NOCOUNT ON;
	select codigoPrioridad, nombrePrioridad from PrioridadTiquete order by codigoPrioridad;
GO

--exec PAobtenerPrioridades;
--DROP PROCEDURE PAobtenerPrioridades;

CREATE PROCEDURE PAactualizarPrioridad
	@codTiquete int,
	@nuevoCodigoPrioridad int,
	@correoUsuarioCausante varchar(100),
	@nombreUsuarioCausante varchar(100),
	@men int output	
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		Declare
		@error int,
		@fechaActual datetime,
		@responsableActual varchar(60),
		@aclaracion varchar(500),
		@codigoPrioridadAnterior int,
		@nombrePrioridadAnterior varchar(200),
		@nombrePrioridadActual varchar(200)

		SET @error = ISNULL((select codigoTiquete from dbo.Tiquete where codigoTiquete = @codTiquete), -1);
        IF @error = -1
        BEGIN
            SET @men = 1; --No existe el codigo de tiquete
            THROW  50001, 'No existe el código de tiquete ingresado', 1;
        END;

		SET @fechaActual = (select GETDATE());
		SET @codigoPrioridadAnterior = (select codigoPrioridad from Tiquete where codigoTiquete = @codTiquete);
		SET @nombrePrioridadAnterior = (select nombrePrioridad from PrioridadTiquete where codigoPrioridad = @codigoPrioridadAnterior);

		SET @nombrePrioridadActual = (select nombrePrioridad from PrioridadTiquete where codigoPrioridad = @nuevoCodigoPrioridad);

		SET @responsableActual = 
		(select resp.codigoEmpleado from 
		(select codigoResponsable, codigoEmpleado from Responsable) resp,
		(select codigoResponsable from dbo.Tiquete where codigoTiquete = @codTiquete) tiq
		where resp.codigoResponsable = tiq.codigoResponsable);

		SET @aclaracion = 'La prioridad del tiquete ' + CAST(@codTiquete as varchar) + ' fue actualizada de ' +
		@nombrePrioridadAnterior + ' a ' + @nombrePrioridadActual + 
		' por ' + @nombreUsuarioCausante + ' el ' + CONVERT(VARCHAR, @fechaActual, 120);

		update Tiquete SET codigoPrioridad = @nuevoCodigoPrioridad where codigoTiquete = @codTiquete;

		insert into dbo.HistorialTiquete(codigoTiquete, codigoIndicador, codigoResponsable, fechaHora, 
		correoUsuarioCausante, nombreUsuarioCausante,aclaracionSistema)
		values (@codTiquete, 8, @responsableActual, @fechaActual, @correoUsuarioCausante, 
		@nombreUsuarioCausante, @aclaracion);
		COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @error != -1 
	BEGIN
		SET @men = 2;
	END;
END CATCH;
GO

--DECLARE @mens int
--exec PAactualizarPrioridad 6, 2, 'nubeblanca1997@outlook.com', 'Cristina Cascante', @men = @mens output;
--PRINT @mens;

--select * from HistorialTiquete;
--select * from Tiquete;
--DROP PROCEDURE PAactualizarPrioridad;


--Retorna solo una parte de la info de los tiquetes para los filtros de la búsqueda de tiquetes para el historial
CREATE PROCEDURE PAobtenerTiquetesHistorial
	@codigoTiquete varchar(200),
	@correoSolicitante varchar(200),
	@nombreSolicitante varchar(200),
	@correoResponsable varchar(200),
	@nombreResponsable varchar(200),
	@fechaInicio date,
	@fechaFinal date
AS
SET NOCOUNT ON;
	SET @codigoTiquete = '%' + @codigoTiquete + '%';
	SET @correoSolicitante = '%' + @correoSolicitante + '%';
	SET @nombreSolicitante = '%' + @nombreSolicitante + '%';
	SET @correoResponsable = '%' + @correoResponsable + '%';
	SET @nombreResponsable = '%' + @nombreResponsable + '%';
	SET @fechaFinal = (SELECT DATEADD(day, 1, @fechaFinal));

	select tique.codigoTiquete, tique.nombreUsuarioSolicitante, tique.usuarioIngresaTiquete, res.nombreResponsable,
	res.correo, cla.descripcionClasificacion, tique.descripcion, tique.fechaCreacion from
	(select codigoResponsable, nombreResponsable, correo from Responsable where nombreResponsable like @nombreResponsable AND
	correo like @correoResponsable) res,
	(select codigoClasificacion, descripcionClasificacion from Clasificacion) cla,
	(select codigoTiquete, nombreUsuarioSolicitante, usuarioIngresaTiquete, codigoResponsable, descripcion, fechaCreacion, 
	codigoClasificacion from Tiquete where codigoTiquete like @codigoTiquete 
	AND nombreUsuarioSolicitante like @nombreSolicitante AND usuarioIngresaTiquete like @correoSolicitante 
	AND fechaCreacion BETWEEN @fechaInicio AND @fechaFinal) tique
	where res.codigoResponsable = tique.codigoResponsable AND cla.codigoClasificacion = tique.codigoClasificacion;
GO

--exec PAobtenerTiquetesHistorial '', '', '', '', 'lui', '2018-01-01', '2018-02-07';
--update Tiquete SET codigoResponsable = 2 where codigoTiquete = 8;
--DROP PROCEDURE PAobtenerTiquetesHistorial;

CREATE PROCEDURE PAobtenerHistorial
	@codigoTiquete int
AS
SET NOCOUNT ON;
	select his.codigoHistorial, his.codigoIndicador, his.comentarioUsuario, his.fechaHora, his.correoUsuarioCausante, 
	his.nombreUsuarioCausante, his.aclaracionSistema, res.nombreResponsable, res.correo from
	(select codigoEmpleado, nombreResponsable, correo from Responsable) res,
	(select codigoHistorial, codigoIndicador, comentarioUsuario, fechaHora, correoUsuarioCausante, nombreUsuarioCausante,
	aclaracionSistema, codigoResponsable from HistorialTiquete where codigoTiquete = @codigoTiquete) his
	where his.codigoResponsable = res.codigoEmpleado;
GO

--exec PAobtenerHistorial 2;


 CREATE PROCEDURE PAbusquedaAvanzadaTiquetes
	@codigoTiquete varchar(200),
	@correoSolicitante varchar(200),
	@nombreSolicitante varchar(200),
	@correoResponsable varchar(200),
	@nombreResponsable varchar(200),
	@fechaInicio date,
	@fechaFinal date,
	@codigoEstado varchar(200)
AS
SET NOCOUNT ON;
	SET @codigoTiquete = '%' + @codigoTiquete + '%';
	SET @correoSolicitante = '%' + @correoSolicitante + '%';
	SET @nombreSolicitante = '%' + @nombreSolicitante + '%';
	SET @correoResponsable = '%' + @correoResponsable + '%';
	SET @nombreResponsable = '%' + @nombreResponsable + '%';
	SET @fechaFinal = (SELECT DATEADD(day, 1, @fechaFinal));
	SET @codigoEstado = '%' + @codigoEstado + '%';

	IF @correoResponsable = '%%' AND @nombreResponsable = '%%'
		select tique.codigoTiquete, tique.usuarioIngresaTiquete, esta.codigoEstado, esta.nombreEstado,
		esta.enviaCorreos, tique.codigoResponsable, are.codigoArea, are.nombreArea, are.activo, tema.codigoClasificacion,
		tema.descripcionClasificacion, tema.activo, tema.codigoPadre, tique.fechaCreacion, tique.fechaFinalizado,
		tique.fechaCalificado, tique.fechaSolicitado, tique.fechaEnProceso, tique.descripcion, 
		tique.calificacion, tique.horasTrabajadas, tique.nombreUsuarioSolicitante, tique.departamentoUsuarioSolicitante,
		tique.jefaturaUsuarioSolicitante, tique.codigoPrioridad, pri.nombrePrioridad, tique.fechaEntrega from
		(select codigoEstado, nombreEstado, enviaCorreos from dbo.Estado where codigoEstado like @codigoEstado) esta, 
		(select codigoArea, nombreArea, activo from dbo.Area) are,
		(select codigoClasificacion, descripcionClasificacion, activo, codigoPadre from dbo.Clasificacion) tema,
		(select codigoTiquete, usuarioIngresaTiquete, codigoEstado, codigoResponsable, codigoArea,
		codigoClasificacion, fechaCreacion, fechaFinalizado, fechaCalificado, fechaSolicitado, fechaEnProceso, 
		descripcion, calificacion, horasTrabajadas, nombreUsuarioSolicitante, departamentoUsuarioSolicitante,
		jefaturaUsuarioSolicitante, codigoPrioridad, fechaEntrega from dbo.Tiquete where codigoTiquete like @codigoTiquete 
		AND nombreUsuarioSolicitante COLLATE Latin1_General_CI_AI like @nombreSolicitante AND usuarioIngresaTiquete like @correoSolicitante 
		AND codigoEstado like @codigoEstado AND fechaCreacion BETWEEN @fechaInicio AND @fechaFinal) tique,
		(select codigoPrioridad, nombrePrioridad from PrioridadTiquete) pri
		where esta.codigoEstado = tique.codigoEstado AND are.codigoArea = tique.codigoArea 
		AND tema.codigoClasificacion = tique.codigoClasificacion AND tique.codigoPrioridad = pri.codigoPrioridad
		order by tique.codigoPrioridad;
	ELSE
		select tique.codigoTiquete, tique.usuarioIngresaTiquete, esta.codigoEstado, esta.nombreEstado,
		esta.enviaCorreos, tique.codigoResponsable, are.codigoArea, are.nombreArea, are.activo, tema.codigoClasificacion,
		tema.descripcionClasificacion, tema.activo, tema.codigoPadre, tique.fechaCreacion, tique.fechaFinalizado,
		tique.fechaCalificado, tique.fechaSolicitado, tique.fechaEnProceso, tique.descripcion, 
		tique.calificacion, tique.horasTrabajadas, tique.nombreUsuarioSolicitante, tique.departamentoUsuarioSolicitante,
		tique.jefaturaUsuarioSolicitante, tique.codigoPrioridad, pri.nombrePrioridad, tique.fechaEntrega from
		(select codigoResponsable, nombreResponsable, correo from Responsable where nombreResponsable COLLATE Latin1_General_CI_AI like @nombreResponsable AND
		correo like @correoResponsable) res,
		(select codigoEstado, nombreEstado, enviaCorreos from dbo.Estado where codigoEstado like @codigoEstado) esta, 
		(select codigoArea, nombreArea, activo from dbo.Area) are,
		(select codigoClasificacion, descripcionClasificacion, activo, codigoPadre from dbo.Clasificacion) tema,
		(select codigoTiquete, usuarioIngresaTiquete, codigoEstado, codigoResponsable, codigoArea,
		codigoClasificacion, fechaCreacion, fechaFinalizado, fechaCalificado, fechaSolicitado, fechaEnProceso, 
		descripcion, calificacion, horasTrabajadas, nombreUsuarioSolicitante, departamentoUsuarioSolicitante,
		jefaturaUsuarioSolicitante, codigoPrioridad, fechaEntrega from dbo.Tiquete where codigoTiquete like @codigoTiquete 
		AND nombreUsuarioSolicitante COLLATE Latin1_General_CI_AI like @nombreSolicitante AND usuarioIngresaTiquete like @correoSolicitante 
		AND codigoEstado like @codigoEstado AND fechaCreacion BETWEEN @fechaInicio AND @fechaFinal) tique,
		(select codigoPrioridad, nombrePrioridad from PrioridadTiquete) pri
		where esta.codigoEstado = tique.codigoEstado AND are.codigoArea = tique.codigoArea 
		AND tema.codigoClasificacion = tique.codigoClasificacion AND tique.codigoPrioridad = pri.codigoPrioridad
		AND res.codigoResponsable = tique.codigoResponsable order by tique.codigoPrioridad; 
GO

--exec PAbusquedaAvanzadaTiquetes '', '', '', '', 'gonzalez', '2012-01-01', '2018-04-07', '';
--DROP PROCEDURE PAbusquedaAvanzadaTiquetes;

CREATE PROCEDURE PAbusquedaAvanzadaTiquetesArea
	@codigoTiquete varchar(200),
	@correoSolicitante varchar(200),
	@nombreSolicitante varchar(200),
	@correoResponsable varchar(200),
	@nombreResponsable varchar(200),
	@fechaInicio date,
	@fechaFinal date,
	@codigoEstado varchar(200),
	@areaCoordinador int
AS
SET NOCOUNT ON;
	SET @codigoTiquete = '%' + @codigoTiquete + '%';
	SET @correoSolicitante = '%' + @correoSolicitante + '%';
	SET @nombreSolicitante = '%' + @nombreSolicitante + '%';
	SET @correoResponsable = '%' + @correoResponsable + '%';
	SET @nombreResponsable = '%' + @nombreResponsable + '%';
	SET @fechaFinal = (SELECT DATEADD(day, 1, @fechaFinal));
	SET @codigoEstado = '%' + @codigoEstado + '%';

	IF @correoResponsable = '%%' AND @nombreResponsable = '%%'
		select tique.codigoTiquete, tique.usuarioIngresaTiquete, esta.codigoEstado, esta.nombreEstado,
		esta.enviaCorreos, tique.codigoResponsable, are.codigoArea, are.nombreArea, are.activo, tema.codigoClasificacion,
		tema.descripcionClasificacion, tema.activo, tema.codigoPadre, tique.fechaCreacion, tique.fechaFinalizado,
		tique.fechaCalificado, tique.fechaSolicitado, tique.fechaEnProceso, tique.descripcion, 
		tique.calificacion, tique.horasTrabajadas, tique.nombreUsuarioSolicitante, tique.departamentoUsuarioSolicitante,
		tique.jefaturaUsuarioSolicitante, tique.codigoPrioridad, pri.nombrePrioridad, tique.fechaEntrega from
		(select codigoEstado, nombreEstado, enviaCorreos from dbo.Estado where codigoEstado like @codigoEstado) esta, 
		(select codigoArea, nombreArea, activo from dbo.Area where codigoArea = @areaCoordinador) are,
		(select codigoClasificacion, descripcionClasificacion, activo, codigoPadre from dbo.Clasificacion) tema,
		(select codigoTiquete, usuarioIngresaTiquete, codigoEstado, codigoResponsable, codigoArea,
		codigoClasificacion, fechaCreacion, fechaFinalizado, fechaCalificado, fechaSolicitado, fechaEnProceso, 
		descripcion, calificacion, horasTrabajadas, nombreUsuarioSolicitante, departamentoUsuarioSolicitante,
		jefaturaUsuarioSolicitante, codigoPrioridad, fechaEntrega from dbo.Tiquete where codigoTiquete like @codigoTiquete 
		AND nombreUsuarioSolicitante COLLATE Latin1_General_CI_AI like @nombreSolicitante AND usuarioIngresaTiquete like @correoSolicitante 
		AND codigoEstado like @codigoEstado AND fechaCreacion BETWEEN @fechaInicio AND @fechaFinal AND codigoArea = @areaCoordinador) tique,
		(select codigoPrioridad, nombrePrioridad from PrioridadTiquete) pri
		where esta.codigoEstado = tique.codigoEstado AND are.codigoArea = tique.codigoArea 
		AND tema.codigoClasificacion = tique.codigoClasificacion AND tique.codigoPrioridad = pri.codigoPrioridad
		order by tique.codigoPrioridad;
	ELSE
		select tique.codigoTiquete, tique.usuarioIngresaTiquete, esta.codigoEstado, esta.nombreEstado,
		esta.enviaCorreos, tique.codigoResponsable, are.codigoArea, are.nombreArea, are.activo, tema.codigoClasificacion,
		tema.descripcionClasificacion, tema.activo, tema.codigoPadre, tique.fechaCreacion, tique.fechaFinalizado,
		tique.fechaCalificado, tique.fechaSolicitado, tique.fechaEnProceso, tique.descripcion, 
		tique.calificacion, tique.horasTrabajadas, tique.nombreUsuarioSolicitante, tique.departamentoUsuarioSolicitante,
		tique.jefaturaUsuarioSolicitante, tique.codigoPrioridad, pri.nombrePrioridad, tique.fechaEntrega from
		(select codigoResponsable, nombreResponsable, correo from Responsable where nombreResponsable COLLATE Latin1_General_CI_AI like @nombreResponsable AND
		correo like @correoResponsable) res,
		(select codigoEstado, nombreEstado, enviaCorreos from dbo.Estado where codigoEstado like @codigoEstado) esta, 
		(select codigoArea, nombreArea, activo from dbo.Area where codigoArea = @areaCoordinador) are,
		(select codigoClasificacion, descripcionClasificacion, activo, codigoPadre from dbo.Clasificacion) tema,
		(select codigoTiquete, usuarioIngresaTiquete, codigoEstado, codigoResponsable, codigoArea,
		codigoClasificacion, fechaCreacion, fechaFinalizado, fechaCalificado, fechaSolicitado, fechaEnProceso, 
		descripcion, calificacion, horasTrabajadas, nombreUsuarioSolicitante, departamentoUsuarioSolicitante,
		jefaturaUsuarioSolicitante, codigoPrioridad, fechaEntrega from dbo.Tiquete where codigoTiquete like @codigoTiquete 
		AND nombreUsuarioSolicitante COLLATE Latin1_General_CI_AI like @nombreSolicitante AND usuarioIngresaTiquete like @correoSolicitante 
		AND codigoEstado like @codigoEstado AND fechaCreacion BETWEEN @fechaInicio AND @fechaFinal AND codigoArea = @areaCoordinador) tique,
		(select codigoPrioridad, nombrePrioridad from PrioridadTiquete) pri
		where esta.codigoEstado = tique.codigoEstado AND are.codigoArea = tique.codigoArea 
		AND tema.codigoClasificacion = tique.codigoClasificacion AND tique.codigoPrioridad = pri.codigoPrioridad
		AND res.codigoResponsable = tique.codigoResponsable order by tique.codigoPrioridad; 
GO

--exec PAbusquedaAvanzadaTiquetesArea '', '', '', '', 'gonza', '2017-01-01', '2018-04-24', '', 2;
--DROP PROCEDURE PAbusquedaAvanzadaTiquetesArea;
--select * from Tiquete;

CREATE PROCEDURE PAobtenerTiqueteFiltradoCodigo
	@codigoTiquete int
AS
	select tique.codigoTiquete, tique.usuarioIngresaTiquete, esta.codigoEstado, esta.nombreEstado,
	esta.enviaCorreos, tique.codigoResponsable, are.codigoArea, are.nombreArea, are.activo, tema.codigoClasificacion,
	tema.descripcionClasificacion, tema.activo, tema.codigoPadre, tique.fechaCreacion, tique.fechaFinalizado,
	tique.fechaCalificado, tique.fechaSolicitado, tique.fechaEnProceso, tique.descripcion, 
	tique.calificacion, tique.horasTrabajadas, tique.nombreUsuarioSolicitante, tique.departamentoUsuarioSolicitante,
	tique.jefaturaUsuarioSolicitante, tique.codigoPrioridad, pri.nombrePrioridad, tique.fechaEntrega from
	(select codigoEstado, nombreEstado, enviaCorreos from dbo.Estado) esta, 
	(select codigoArea, nombreArea, activo from dbo.Area) are,
	(select codigoClasificacion, descripcionClasificacion, activo, codigoPadre from dbo.Clasificacion) tema,
	(select codigoTiquete, usuarioIngresaTiquete, codigoEstado, codigoResponsable, codigoArea,
	codigoClasificacion, fechaCreacion, fechaFinalizado, fechaCalificado, fechaSolicitado, fechaEnProceso, 
	descripcion, calificacion, horasTrabajadas, nombreUsuarioSolicitante, departamentoUsuarioSolicitante,
	jefaturaUsuarioSolicitante, codigoPrioridad, fechaEntrega from dbo.Tiquete where codigoTiquete = @codigoTiquete) tique,
	(select codigoPrioridad, nombrePrioridad from PrioridadTiquete) pri
	where esta.codigoEstado = tique.codigoEstado AND are.codigoArea = tique.codigoArea 
	AND tema.codigoClasificacion = tique.codigoClasificacion AND tique.codigoPrioridad = pri.codigoPrioridad
	order by tique.codigoPrioridad;
GO

--exec PAobtenerTiqueteFiltradoCodigo 3;
--DROP PROCEDURE PAobtenerTiqueteFiltradoCodigo;

CREATE PROCEDURE PAobtenerTodosLosTiquetes  
AS  
    SET NOCOUNT ON; 
	select tique.codigoTiquete, tique.usuarioIngresaTiquete, esta.codigoEstado, esta.nombreEstado,
	esta.enviaCorreos, tique.codigoResponsable, are.codigoArea, are.nombreArea, are.activo, tema.codigoClasificacion,
	tema.descripcionClasificacion, tema.activo, tema.codigoPadre, tique.fechaCreacion, tique.fechaFinalizado,
	tique.fechaCalificado, tique.fechaSolicitado, tique.fechaEnProceso, tique.descripcion, 
	tique.calificacion, tique.horasTrabajadas, tique.nombreUsuarioSolicitante, tique.departamentoUsuarioSolicitante,
	tique.jefaturaUsuarioSolicitante, tique.codigoPrioridad, pri.nombrePrioridad, tique.fechaEntrega from
	(select codigoEstado, nombreEstado, enviaCorreos from dbo.Estado) esta, 
	(select codigoArea, nombreArea, activo from dbo.Area) are,
	(select codigoClasificacion, descripcionClasificacion, activo, codigoPadre from dbo.Clasificacion) tema,
	(select codigoTiquete, usuarioIngresaTiquete, codigoEstado, codigoResponsable, codigoArea,
	codigoClasificacion, fechaCreacion, fechaFinalizado, fechaCalificado, fechaSolicitado, fechaEnProceso, 
	descripcion, calificacion, horasTrabajadas, nombreUsuarioSolicitante, departamentoUsuarioSolicitante,
	jefaturaUsuarioSolicitante, codigoPrioridad, fechaEntrega from dbo.Tiquete) tique,
	(select codigoPrioridad, nombrePrioridad from PrioridadTiquete) pri
	where esta.codigoEstado = tique.codigoEstado AND are.codigoArea = tique.codigoArea 
	AND tema.codigoClasificacion = tique.codigoClasificacion AND tique.codigoPrioridad = pri.codigoPrioridad;
GO

--exec PAobtenerTodosLosTiquetes;
--DROP PROCEDURE PAobtenerTodosLosTiquetes;

CREATE PROCEDURE PAactualizarFechaEntrega
	@codTiquete int,
	@nuevaFechaEntrega date,
	@justificacion ntext,
	@correoUsuarioCausante varchar(100),
	@nombreUsuarioCausante varchar(100),
	@men int output	
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		Declare
		@error int,
		@error2 int,
		@fechaActual datetime,
		@responsableActual varchar(60),
		@aclaracion varchar(500),
		@fechaAnterior datetime

		SET @error = ISNULL((select codigoTiquete from dbo.Tiquete where codigoTiquete = @codTiquete), -1);
        IF @error = -1
        BEGIN
            SET @men = 1; --No existe el codigo de tiquete
            THROW  50001, 'No existe el código de tiquete ingresado', 1;
        END;

		SET @fechaActual = (select GETDATE());
		SET @fechaAnterior = (select fechaEntrega from Tiquete where codigoTiquete = @codTiquete);

		SET @responsableActual = 
		(select resp.codigoEmpleado from 
		(select codigoResponsable, codigoEmpleado from Responsable) resp,
		(select codigoResponsable from dbo.Tiquete where codigoTiquete = @codTiquete) tiq
		where resp.codigoResponsable = tiq.codigoResponsable);

		IF (select codigoEstado from Tiquete where codigoTiquete = @codTiquete) != 4
		BEGIN
			SET @error2 = -1;
			SET @men = 2; --El tiquete no se encuentra en proceso
            THROW  50001, 'El tiquete no se encuentra en proceso', 1;
		END;

		SET @aclaracion = 'La fecha de entrega del tiquete ' + CAST(@codTiquete as varchar) + ' fue actualizada de ' +
		CONVERT(VARCHAR, @fechaAnterior, 23) + ' a ' + CONVERT(VARCHAR, @nuevaFechaEntrega, 120) + 
		' por ' + @nombreUsuarioCausante + ' el ' + CONVERT(VARCHAR, @fechaActual, 120);

		update Tiquete SET  fechaEntrega = @nuevaFechaEntrega where codigoTiquete = @codTiquete;

		insert into dbo.HistorialTiquete(codigoTiquete, codigoIndicador, codigoResponsable, fechaHora, 
		correoUsuarioCausante, nombreUsuarioCausante,aclaracionSistema, comentarioUsuario)
		values (@codTiquete, 13, @responsableActual, @fechaActual, @correoUsuarioCausante, 
		@nombreUsuarioCausante, @aclaracion, @justificacion);
		COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @error != -1 AND @error2 != -1
	BEGIN
		SET @men = 3;
	END;
END CATCH;
GO

--DECLARE @mens int
--exec PAactualizarFechaEntrega 2, '2018-06-14', 'Ya sé que yo puse esa fecha, pero la verdad es imposible hacer eso en tan poco tiempo, así que me voy a tomar tres meses más','nubeblanca1997@outlook.com', 'Cristina Cascante', @men = @mens output;
--PRINT @mens;


--select * from HistorialTiquete;
--select * from Responsable;
--select * from Tiquete;
--DROP PROCEDURE PAactualizarFechaEntrega;


--El cliente puede enviar a reprocesar en lugar de calificar sino esta satisfecho 
CREATE PROCEDURE PAenviarAReprocesar
	@codTiquete int,
	@justificacion ntext,
	@correoUsuarioCausante varchar(100),
	@nombreUsuarioCausante varchar(100),
	@men int output	
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
		Declare
		@error int,
		@error2 int,
		@fechaActual datetime,
		@responsableActual varchar(60),
		@aclaracion varchar(500),
		@fechaAnterior datetime

		SET @error = ISNULL((select codigoTiquete from dbo.Tiquete where codigoTiquete = @codTiquete), -1);
        IF @error = -1
        BEGIN
            SET @men = 1; --No existe el codigo de tiquete
            THROW  50001, 'No existe el código de tiquete ingresado', 1;
        END;

		IF (select codigoEstado from Tiquete where codigoTiquete = @codTiquete) != 6 --Tiquete finalizado 
		BEGIN
			SET @error2 = -1;
			SET @men = 2; --El tiquete no se encuentra finalizado
            THROW  50001, 'El tiquete no se encuentra finalizado', 1;
		END;

		SET @fechaActual = (select GETDATE());
		SET @fechaAnterior = (select fechaEntrega from Tiquete where codigoTiquete = @codTiquete);

		SET @responsableActual = 
		(select resp.codigoEmpleado from 
		(select codigoResponsable, codigoEmpleado from Responsable) resp,
		(select codigoResponsable from dbo.Tiquete where codigoTiquete = @codTiquete) tiq
		where resp.codigoResponsable = tiq.codigoResponsable);

		SET @aclaracion = 'El tiquete ' + CAST(@codTiquete as varchar) + ' fue enviado a reprocesar por ' 
		+ @nombreUsuarioCausante + ' el ' + CONVERT(VARCHAR, @fechaActual, 120) + ', el estado fue cambiado de '
		+ 'Finalizado a Nuevo.';

		update Tiquete SET codigoEstado = 1 where codigoTiquete = @codTiquete;
		
		insert into dbo.HistorialTiquete(codigoTiquete, codigoIndicador, codigoResponsable, fechaHora, 
		correoUsuarioCausante, nombreUsuarioCausante,aclaracionSistema, comentarioUsuario)
		values (@codTiquete, 14, @responsableActual, @fechaActual, @correoUsuarioCausante, 
		@nombreUsuarioCausante, @aclaracion, @justificacion);
		COMMIT TRANSACTION;
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @error != -1 AND @error2 != -1
	BEGIN
		SET @men = 3;
	END;
END CATCH;
GO

--DECLARE @mens int
--exec PAenviarAReprocesar 11, 'Yo esperaba que esto resultara bien :(','nubeblanca1997@outlook.com', 'Cristina Cascante', @men = @mens output;
--PRINT @mens;


--select * from HistorialTiquete;
--select * from Responsable;
--select * from Tiquete;
--DROP PROCEDURE PAenviarAReprocesar;

--Datos que deben estar en todas las bases
insert into dbo.Permiso (codigoPermiso, descripcionPermiso) values (1, 'Consultar permisos');
insert into dbo.Permiso (codigoPermiso, descripcionPermiso) values (2, 'Asignar rol a usuario');
insert into dbo.Permiso (codigoPermiso, descripcionPermiso) values (3, 'Asignar area a clasificación');
insert into dbo.Permiso (codigoPermiso, descripcionPermiso) values (4, 'Administrar temas');
insert into dbo.Permiso (codigoPermiso, descripcionPermiso) values (5, 'Administrar Estados');
insert into dbo.Permiso (codigoPermiso, descripcionPermiso) values (6, 'Ver pestaña de tiquetes sin asignar');
insert into dbo.Permiso (codigoPermiso, descripcionPermiso) values (7, 'Ver pestaña de tiquetes asignados'); 
insert into dbo.Permiso (codigoPermiso, descripcionPermiso) values (8, 'Ver pestaña de búsqueda de avanzada');
insert into dbo.Permiso (codigoPermiso, descripcionPermiso) values (9, 'Ver botón de anular tiquete');


insert into dbo.Rol (nombreRol) values ('Administrador'); --Rol fijo
insert into dbo.Rol (nombreRol) values ('Coordinador');
insert into dbo.Rol (nombreRol) values ('Responsable');
insert into dbo.Rol (nombreRol) values ('Asistente');

insert into dbo.RolPermiso (codigoRol, codigoPermiso) values (1, 1);
insert into dbo.RolPermiso (codigoRol, codigoPermiso) values (1, 2);
insert into dbo.RolPermiso (codigoRol, codigoPermiso) values (1, 3);
insert into dbo.RolPermiso (codigoRol, codigoPermiso) values (1, 4);
insert into dbo.RolPermiso (codigoRol, codigoPermiso) values (1, 5);
insert into dbo.RolPermiso (codigoRol, codigoPermiso) values (1, 6);
insert into dbo.RolPermiso (codigoRol, codigoPermiso) values (1, 7);
insert into dbo.RolPermiso (codigoRol, codigoPermiso) values (1, 8);
insert into dbo.RolPermiso (codigoRol, codigoPermiso) values (1, 9); 
insert into dbo.RolPermiso (codigoRol, codigoPermiso) values (2, 6);
insert into dbo.RolPermiso (codigoRol, codigoPermiso) values (2, 7); 
insert into dbo.RolPermiso (codigoRol, codigoPermiso) values (2, 9); 

insert into dbo.Area(nombreArea, activo) values ('Sistemas', 1);
insert into dbo.Area(nombreArea, activo) values ('Soporte', 1);
insert into dbo.Area(nombreArea, activo) values ('Infraestructura', 1);

insert into dbo.Responsable(codigoRol, loginActivo, codigoEmpleado, nombreResponsable, codigoArea, correo) values (1, 1,'12b3', 'Cristina Cascante', 1, 'nubeblanca1997@outlook.com');
insert into dbo.Responsable(codigoRol, loginActivo, codigoEmpleado, nombreResponsable, codigoArea, correo) values (2, 1, '1b65', 'Luis González', 2, 'francini113@gmail.com');
insert into dbo.Responsable(codigoRol, loginActivo, codigoEmpleado, nombreResponsable, codigoArea, correo) values (1, 1,'4g54', 'Alejandro Morales', 2, 'dannyalfvr97@gmail.com');
insert into dbo.Responsable(codigoRol, loginActivo, codigoEmpleado, nombreResponsable, codigoArea, correo) values (4, 1,'787t', 'Gina Chacón', 3, 'gina@gmail.com');

insert into dbo.Clasificacion(descripcionClasificacion, activo, codigoPadre) values ('Dispositivos', 1, 0);
insert into dbo.Clasificacion(descripcionClasificacion, activo, codigoPadre) values ('Reparacion computadora', 1, 1);
insert into dbo.Clasificacion(descripcionClasificacion, activo, codigoPadre) values ('Nueva computadora', 1, 1);
insert into dbo.Clasificacion(descripcionClasificacion, activo, codigoPadre) values ('Reparacion celular', 1, 1);
insert into dbo.Clasificacion(descripcionClasificacion, activo, codigoPadre) values ('Mantenimiento fuente de poder', 1, 1);
insert into dbo.Clasificacion(descripcionClasificacion, activo, codigoPadre) values ('Desecho celular', 1, 1);
insert into dbo.Clasificacion(descripcionClasificacion, activo, codigoPadre) values ('Computadora portatil', 1, 1);
insert into dbo.Clasificacion(descripcionClasificacion, activo, codigoPadre) values ('Mouse', 1, 1);
insert into dbo.Clasificacion(descripcionClasificacion, activo, codigoPadre) values ('Monitor', 1, 1);
insert into dbo.Clasificacion(descripcionClasificacion, activo, codigoPadre) values ('Movil', 1, 1);
insert into dbo.Clasificacion(descripcionClasificacion, activo, codigoPadre) values ('Sistemas', 1, 0);
insert into dbo.Clasificacion(descripcionClasificacion, activo, codigoPadre) values ('Modificacion sistema RH', 1, 11);
insert into dbo.Clasificacion(descripcionClasificacion, activo, codigoPadre) values ('Modificacion Sistema tiquetes TI', 1, 11);
insert into dbo.Clasificacion(descripcionClasificacion, activo, codigoPadre) values ('Modificacion sistema contabilidad', 1, 11);
insert into dbo.Clasificacion(descripcionClasificacion, activo, codigoPadre) values ('Modificacion Sistema inventario', 1, 11);
insert into dbo.Clasificacion(descripcionClasificacion, activo, codigoPadre) values ('Licencias', 1, 0);
insert into dbo.Clasificacion(descripcionClasificacion, activo, codigoPadre) values ('Vencimiento Word', 1, 16);
insert into dbo.Clasificacion(descripcionClasificacion, activo, codigoPadre) values ('Vencimiento Excel', 1, 16);
insert into dbo.Clasificacion(descripcionClasificacion, activo, codigoPadre) values ('Vencimiento musica', 1, 16);
insert into dbo.Clasificacion(descripcionClasificacion, activo, codigoPadre) values ('Nuevo Word', 1, 16);
insert into dbo.Clasificacion(descripcionClasificacion, activo, codigoPadre) values ('Nuevo Excel', 1, 16);

insert into dbo.AreaClasificacion(codigoArea, codigoClasificacion) values (1, 11);
insert into dbo.AreaClasificacion(codigoArea, codigoClasificacion) values (1, 16);
insert into dbo.AreaClasificacion(codigoArea, codigoClasificacion) values (2, 1);

insert into dbo.Estado(codigoEstado, nombreEstado, enviaCorreos) values (1, 'Nuevo', 0);   
insert into dbo.Estado(codigoEstado, nombreEstado, enviaCorreos) values (2, 'Asignado', 1);  
insert into dbo.Estado(codigoEstado, nombreEstado, enviaCorreos) values (3, 'Espera reasignación', 0);   
insert into dbo.Estado(codigoEstado, nombreEstado, enviaCorreos) values (4, 'En proceso', 0);  
insert into dbo.Estado(codigoEstado, nombreEstado, enviaCorreos) values (5, 'Anulado', 0);   
insert into dbo.Estado(codigoEstado, nombreEstado, enviaCorreos) values (6, 'Finalizado', 1);   
insert into dbo.Estado(codigoEstado, nombreEstado, enviaCorreos) values (7, 'Calificado', 0);    

insert into dbo.EstadoPermitido(codigoEstadoActual, codigoEstadoSiguiente) values (1, 2);
insert into dbo.EstadoPermitido(codigoEstadoActual, codigoEstadoSiguiente) values (2, 3);
insert into dbo.EstadoPermitido(codigoEstadoActual, codigoEstadoSiguiente) values (2, 4);
insert into dbo.EstadoPermitido(codigoEstadoActual, codigoEstadoSiguiente) values (2, 5);
insert into dbo.EstadoPermitido(codigoEstadoActual, codigoEstadoSiguiente) values (3, 2);
insert into dbo.EstadoPermitido(codigoEstadoActual, codigoEstadoSiguiente) values (4, 2);
insert into dbo.EstadoPermitido(codigoEstadoActual, codigoEstadoSiguiente) values (4, 3);
insert into dbo.EstadoPermitido(codigoEstadoActual, codigoEstadoSiguiente) values (4, 5);
insert into dbo.EstadoPermitido(codigoEstadoActual, codigoEstadoSiguiente) values (4, 6);
insert into dbo.EstadoPermitido(codigoEstadoActual, codigoEstadoSiguiente) values (5, 2);
insert into dbo.EstadoPermitido(codigoEstadoActual, codigoEstadoSiguiente) values (6, 2);
insert into dbo.EstadoPermitido(codigoEstadoActual, codigoEstadoSiguiente) values (6, 7); 
insert into dbo.EstadoPermitido(codigoEstadoActual, codigoEstadoSiguiente) values (7, 2);

insert into dbo.Indicadores(codigoIndicador, descripcionIndicador) values (1, 'Enviado a reasignar');
insert into dbo.Indicadores(codigoIndicador, descripcionIndicador) values (2, 'Comentario y/o documento adjunto');
insert into dbo.Indicadores(codigoIndicador, descripcionIndicador) values (3, 'Genera contrato');
insert into dbo.Indicadores(codigoIndicador, descripcionIndicador) values (4, 'Asigna responsable');
insert into dbo.Indicadores(codigoIndicador, descripcionIndicador) values (5, 'Cambio de fecha solicitada');
insert into dbo.Indicadores(codigoIndicador, descripcionIndicador) values (6, 'Edita las horas trabajadas');
insert into dbo.Indicadores(codigoIndicador, descripcionIndicador) values (7, 'Cambio de clasificación');
insert into dbo.Indicadores(codigoIndicador, descripcionIndicador) values (8, 'Cambio de prioridad');
insert into dbo.Indicadores(codigoIndicador, descripcionIndicador) values (9, 'Puesto en proceso');
insert into dbo.Indicadores(codigoIndicador, descripcionIndicador) values (10, 'Tiquete anulado');
insert into dbo.Indicadores(codigoIndicador, descripcionIndicador) values (11, 'Tiquete finalizado');
insert into dbo.Indicadores(codigoIndicador, descripcionIndicador) values (12, 'Tiquete calificado');
insert into dbo.Indicadores(codigoIndicador, descripcionIndicador) values (13, 'Cambio de fecha de entrega');
insert into dbo.Indicadores(codigoIndicador, descripcionIndicador) values (14, 'Enviado a reprocesar');
insert into dbo.Indicadores(codigoIndicador, descripcionIndicador) values (15, 'Asocia activo');

insert into RecursosHumanos (nombreUsuario, departamento, jefatura, correo, codigoEmpleado) values ('Cristina Cascante', 'Tecnología de la Información', 'Cristina Cascante', 'nubeblanca1997@outlook.com', '12b3');
insert into RecursosHumanos (nombreUsuario, departamento, jefatura, correo, codigoEmpleado) values ('Luis González', 'Tecnología de la Información', 'Cristina Cascante', 'francini113@gmail.com', '1b65');
insert into RecursosHumanos (nombreUsuario, departamento, jefatura, correo, codigoEmpleado) values ('Alejandro Morales', 'Tecnología de la Información', 'Cristina Cascante', 'dannyalfvr97@gmail.com', '4g54');
insert into RecursosHumanos (nombreUsuario, departamento, jefatura, correo, codigoEmpleado) values ('Gina Chacón', 'Tecnología de la Información', 'Cristina Cascante', 'gina@gmail.com', '787t');
                                                                                     
insert into PrioridadTiquete (codigoPrioridad, nombrePrioridad) values (1, 'Alto');
insert into PrioridadTiquete (codigoPrioridad, nombrePrioridad) values (2, 'Medio');
insert into PrioridadTiquete (codigoPrioridad, nombrePrioridad) values (3, 'Bajo');

 ----------------------------------------------------Seccion de drop-----------------------------------------
 --Drop de las tablas para el sistema de tiquetes BrittShop
    drop table RolPermiso;
    drop table HistorialTiquete;
	drop table EstadoPermitido;
	drop table AreaClasificacion;	 
	drop table Tiquete;
	drop table PrioridadTiquete;
	drop table Clasificacion;
	drop table Indicadores;
	drop table Responsable;
    drop table Permiso;	 
	drop table Rol; 
	drop table Area;
	drop table Estado;
	drop table RecursosHumanos;

--Drop de los procedimient los almacenados
	DROP PROCEDURE PAconsultarPermisos;  
	DROP PROCEDURE PAverificarRolPermiso; 
	DROP PROCEDURE PAconsultarRoles;  
	DROP PROCEDURE PAobtenerResponsable;
	DROP PROCEDURE PAobtenerResponsables; 
	DROP PROCEDURE PAactualizarResponsable;
	DROP PROCEDURE PAagregarResponsable;
	DROP PROCEDURE PAactualizarRolResponsable;
	DROP PROCEDURE PAobtenerPermisosAsignadosRol;
	DROP PROCEDURE PAagregarRol;
	DROP PROCEDURE PAobtenerResponsablesAsignadosRol;
	DROP PROCEDURE PAeliminarPermisoRol; 
	DROP PROCEDURE PAeliminarRol;
	DROP PROCEDURE PAinactivarResponsable;
	DROP PROCEDURE PAinsertarPermisoRol;		
	DROP PROCEDURE PAobtenerAreas;
	DROP PROCEDURE PAactivarArea;
	DROP PROCEDURE PAactivarResponsable;
	DROP PROCEDURE PAagregarArea;
	DROP PROCEDURE PAinactivarArea;
	DROP PROCEDURE PAobtenerResponsablesCompletos;
	DROP PROCEDURE PAeliminarArea;
	DROP PROCEDURE PAobtenerAreaAsociadaClasificacion;
	DROP PROCEDURE PAactualizarAreaAsociadaClasificacion;
	DROP PROCEDURE PAagregarTiquete;
	DROP PROCEDURE PAobtenerTiquetesPorUsuario;
	DROP PROCEDURE PAobtenerTiquetesPorUsuarioFiltrados;
	DROP PROCEDURE PAobtenerResponsableCodigoResponsable;
	DROP PROCEDURE PAobtenerEstados;
	DROP PROCEDURE PAobtenerClasificacionesPadreActivas;
	DROP PROCEDURE PAobtenerClasificacionesPadreCompletas;
	DROP PROCEDURE PAobtenerClasificacionesHijasActivas;
	DROP PROCEDURE PAobtenerClasificacionesHijasCompletas;
	DROP PROCEDURE PAactivarClasificacion;
	DROP PROCEDURE PAinactivarClasificacion;
	DROP PROCEDURE PAagregarClasificacionPadre;
	DROP PROCEDURE PAagregarClasificacionHija;
	DROP PROCEDURE PAactualizarDescripcionClasificacion;
	DROP PROCEDURE PAactualizarPadreClasificacion;
	DROP PROCEDURE PAagregarAdjunto;
	DROP PROCEDURE PAeliminarClasificacion;
	DROP PROCEDURE PAactualizarArea;
	DROP PROCEDURE PAobtenerAdjuntosTiquete;
	DROP PROCEDURE PAobtenerDatosUsuario;
	DROP PROCEDURE PAobtenerAreasActivas;
	DROP PROCEDURE PAobtenerHistorialComentariosCompleto;
	DROP PROCEDURE PAobtenerComentariosFiltradosFecha;
	DROP PROCEDURE PAasignarTiquete;
	DROP PROCEDURE PAactualizarFechaSolicitada;
	DROP PROCEDURE PAobtenerResponsablesAsignar;
	DROP PROCEDURE PAobtenerTiquetesPorAsignarArea;
	DROP PROCEDURE PAobtenerTiquetesPorAsignarTodos;
	DROP PROCEDURE PAactualizarHorasTrabajadas;
	DROP PROCEDURE PAactualizarClasificacionTiquete;
	DROP PROCEDURE PAactualizarEstadoTiquete;
	DROP PROCEDURE PAactualizarEnviaCorreoEstado;
	DROP PROCEDURE PAobtenerTiquetesAsignados;
	DROP PROCEDURE PAobtenerTiquetesAsignadosFiltrados;
	DROP PROCEDURE PAenviarAReasignarTiquete;
	DROP PROCEDURE PAponerTiqueteEnProceso;
	DROP PROCEDURE PAanularTiquete;
	DROP PROCEDURE PAfinalizarTiquete;
	DROP PROCEDURE PAcalificarTiquete;
	DROP PROCEDURE PAobtenerPrioridades;
	DROP PROCEDURE PAactualizarPrioridad;
	DROP PROCEDURE PAobtenerTiquetesHistorial;
	DROP PROCEDURE PAobtenerHistorial;
	DROP PROCEDURE PAbusquedaAvanzadaTiquetes;
	DROP PROCEDURE PAbusquedaAvanzadaTiquetesArea;
    DROP PROCEDURE PAobtenerTiqueteFiltradoCodigo;
    DROP PROCEDURE PAobtenerTodosLosTiquetes;
	DROP PROCEDURE PAactualizarFechaEntrega;
	DROP PROCEDURE PAenviarAReprocesar;
-------------------------------------------------Fin de seccion de drop-----------------------------------------



--Solucionar Microsoft SQL Server Error 18456 Login Failed for User
https://www.youtube.com/watch?v=aU8RhjdkCoE

--Crear usuario dbatiquetes con password dbatiquetes
https://www.youtube.com/watch?v=JIb98K0wZ4s
--Solo que en asignaci�n de usuarios, le di privilegios de owner al dbatiquetes
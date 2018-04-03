CREATE TABLE EstadoEquipo(
 codigoEstado int NOT NULL,
 nombreEstado varchar(60) NOT NULL,
  CONSTRAINT PKEstadoEquipo PRIMARY KEY(codigoEstado),
  CONSTRAINT AK_EstadoEquipo UNIQUE (nombreEstado)
 )
 GO
 

CREATE TABLE EstadoEquipoPermitido(
 estadoEquipoActual int NOT NULL,
 estadoEquipoSiguiente int NOT NULL,
 CONSTRAINT PKEstadoEquipoPermitido PRIMARY KEY(estadoEquipoActual,estadoEquipoSiguiente),
 CONSTRAINT FKEstadoEquipoPermitidoEstadoActual FOREIGN KEY (estadoEquipoActual) REFERENCES EstadoEquipo(codigoEstado),
 CONSTRAINT FKEstadoEquipoPermitidoEstadoSiguiente FOREIGN KEY (estadoEquipoSiguiente) REFERENCES EstadoEquipo(codigoEstado),
 )
 GO
 

 CREATE TABLE Categoria(
 codigoCategoria int NOT NULL,
 nombreCategoria varchar(150) NOT NULL,
 esRepuesto bit NOT NULL,                      -- 1 -> repuesto 0-> algo mas
  CONSTRAINT PKCategoria PRIMARY KEY(codigoCategoria),
  CONSTRAINT AK_Categoria UNIQUE (nombreCategoria)
 )
 GO
 
 CREATE TABLE Bodega(
 nombreBodega varchar(150) NOT NULL,
  CONSTRAINT PKBodega PRIMARY KEY(nombreBodega)
 )
 GO

 CREATE TABLE Inventario(
 codigoArticulo varchar(150) NOT NULL,
 descripcion varchar(150) NOT NULL, 
 costo money NOT NULL,
 codigoCategoria int NOT NULL,
 estado varchar(150) NOT NULL,
 cantidad int NOT NULL,
 bodega varchar(150),
 CONSTRAINT PKInventario PRIMARY KEY(codigoArticulo, bodega),
 CONSTRAINT FKInventarioCategoria FOREIGN KEY (codigoCategoria) REFERENCES Categoria(codigoCategoria),
 CONSTRAINT FKInventarioBodega FOREIGN KEY (bodega) REFERENCES Bodega(nombreBodega)
 )
 GO
 

 CREATE TABLE Detalle(
 codigoDetalle int NOT NULL identity(1,1),
 codigoArticulo varchar(150) NOT NULL,
 copiaCantidadInventario int NOT NULL,
 cantidadEfecto int NOT NULL,
 costo money NOT NULL,
 fecha datetime NOT NULL,
 estado varchar(150) NOT NULL,
 efecto varchar(100) NOT NULL,    --Entrada o salida
 bodega varchar(150) NOT NULL, 
 comentarioUsuario ntext NOT NULL,
 correoUsuarioCausante varchar(150) NOT NULL,
 nombreUsuarioCausante varchar(150) NOT NULL,
 CONSTRAINT PKDetalle PRIMARY KEY(codigoDetalle),
 CONSTRAINT FKDetalleInventario FOREIGN KEY (codigoArticulo, bodega) REFERENCES Inventario(codigoArticulo, bodega)
 )
 GO
  

CREATE TABLE ActivoFijo(
 placa varchar(150) NOT NULL,
 codigoCategoria int NOT NULL, 
 codigoEstado int NOT NULL,
 serie varchar(150) NOT NULL,
 proveedor varchar(300) NOT NULL,
 modelo varchar(150) NOT NULL,
 marca varchar(150) NOT NULL,
 fechaSalidaInventario datetime NOT NULL,
 fechaDesechado datetime,
 fechaExpiraGarantia datetime,
 correoUsuarioAsociado varchar(300),
 nombreUsuarioAsociado varchar(100),
 departamentoUsuarioAsociado varchar(150),
 jefaturaUsuarioAsociado varchar(100), 
 CONSTRAINT PKActivoFijo PRIMARY KEY(placa),
 CONSTRAINT FKActivoFijoEstado FOREIGN KEY (codigoEstado) REFERENCES EstadoEquipo(codigoEstado),
 CONSTRAINT FKActivoFijoCategoria FOREIGN KEY (codigoCategoria) REFERENCES Categoria(codigoCategoria)
 )
 GO


 CREATE TABLE Licencia(
 fechaDeVencimiento datetime NOT NULL,
 claveDeProducto varchar(150) NOT NULL,
 proveedor varchar(150) NOT NULL,
 fechaAsociado datetime NOT NULL,
 descripcion varchar(500) NOT NULL,
 placa varchar(150) NOT NULL,
 CONSTRAINT PKLicencia PRIMARY KEY(claveDeProducto),
 CONSTRAINT FKLicenciaActivoFijo FOREIGN KEY (placa) REFERENCES ActivoFijo(placa)
 )
 GO
 

 CREATE TABLE Repuesto(
 descripcion varchar(150) NOT NULL,
 fechaAsociado datetime NOT NULL,
 placa varchar(150) NOT NULL,
 CONSTRAINT PKRepuesto PRIMARY KEY(descripcion, placa),
 CONSTRAINT FKRepuestoActivoFijo FOREIGN KEY (placa) REFERENCES ActivoFijo(placa)
 )
 GO
 

 CREATE TABLE IndicadoresActivos(
 codigoIndicador int NOT NULL,
 descripcionIndicador varchar(100) NOT NULL,
 CONSTRAINT PKIndicadoresActivos PRIMARY KEY(codigoIndicador),
 CONSTRAINT AK_IndicadoresActivos UNIQUE (descripcionIndicador)
 )
 GO


 CREATE TABLE HistorialActivos(
 codigoHistorial int NOT NULL identity(1, 1),
 placa varchar(150) NOT NULL,
 codigoIndicador int NOT NULL,
 fechaHora dateTime,
 correoUsuarioCausante varchar(150) NOT NULL,
 nombreUsuarioCausante varchar(150) NOT NULL,
 correoUsuarioAsociado varchar(150),
 nombreUsuarioAsociado varchar(150),
 comentarioUsuario ntext,
 aclaracionSistema ntext,
 CONSTRAINT PKHistorialEquipo PRIMARY KEY(codigoHistorial),
 CONSTRAINT FKHistorialEquipoActivoFijo FOREIGN KEY (placa) REFERENCES ActivoFijo(placa),
 CONSTRAINT FKHistorialEquipoIndicador  FOREIGN KEY (codigoIndicador) REFERENCES IndicadoresActivos(codigoIndicador)
 )
 GO




 CREATE PROCEDURE PAobtenerInventario
 AS
	SET NOCOUNT ON;
	select inve.codigoArticulo, inve.descripcion, inve.costo, cat.codigoCategoria, cat.nombreCategoria, cat.esRepuesto, inve.estado, inve.cantidad,
	inve.bodega from
	(select codigoCategoria, nombreCategoria, esRepuesto from Categoria) cat,
	(select codigoArticulo, descripcion, costo, codigoCategoria, estado, cantidad, bodega from Inventario) inve
	where inve.codigoCategoria = cat.codigoCategoria;
 GO
 --DROP PROCEDURE PAobtenerInventario
 --exec PAobtenerInventario;		

 CREATE PROCEDURE PAobtenerActivosFijos
 AS
	SET NOCOUNT ON;
	select activo.placa, cat.codigoCategoria, cat.nombreCategoria, cat.esRepuesto, estado.codigoEstado, estado.nombreEstado,
	activo.serie, activo.proveedor, activo.modelo, activo.marca, activo.fechaSalidaInventario, activo.fechaDesechado,
	activo.fechaExpiraGarantia, activo.correoUsuarioAsociado, activo.nombreUsuarioAsociado,
	activo.departamentoUsuarioAsociado, activo.jefaturaUsuarioAsociado from
	(select codigoCategoria, nombreCategoria, esRepuesto from Categoria) cat,
	(select codigoEstado, nombreEstado from EstadoEquipo) estado,
	(select placa, codigoCategoria, codigoEstado, serie, proveedor, modelo, marca, 
	fechaSalidaInventario, fechaDesechado, fechaExpiraGarantia, correoUsuarioAsociado, nombreUsuarioAsociado, 
	departamentoUsuarioAsociado, jefaturaUsuarioAsociado from ActivoFijo) activo
	where activo.codigoCategoria = cat.codigoCategoria AND activo.codigoEstado = estado.codigoEstado;
 GO

 --exec PAobtenerActivosFijos;
 --DROP PROCEDURE PAobtenerActivosFijos;

 CREATE PROCEDURE PAobtenerLicencias
	@placa varchar(150)
 AS

	SET NOCOUNT ON;
	select fechaDeVencimiento, claveDeProducto, proveedor, fechaAsociado, descripcion, placa from Licencia where placa = @placa;
 GO

 --exec PAobtenerLicencias '456';

 CREATE PROCEDURE PAobtenerRepuestos
	@placa varchar(150)
 AS

	SET NOCOUNT ON;
	select descripcion, fechaAsociado, placa from Repuesto where placa = @placa;
 GO
 --exec PAobtenerRepuestos '456';


 CREATE PROCEDURE PAobtenerCategorias
 AS
	SET NOCOUNT ON;
	select codigoCategoria, nombreCategoria, esRepuesto from Categoria;
 GO

 --exec PAobtenerCategorias;
 --DROP PROCEDURE PAobtenerCategorias;


CREATE PROCEDURE PAagregarArticuloInventario
	@codigoArticulo varchar(150),
	@descripcion varchar(150), 
	@costo money,
	@codigoCategoria int,
	@estado varchar(150),
	@cantidad int,
	@bodega varchar(150),
	@comentarioUsuario ntext,
	@correoUsuarioCausante varchar(150),
	@nombreUsuarioCausante varchar(150),
	@men int output	
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
	DECLARE 
	@fechaActual datetime

	SET @fechaActual = (select GETDATE());
	insert into Inventario (codigoArticulo, descripcion, costo, codigoCategoria, estado, cantidad, bodega) values
	(@codigoArticulo, @descripcion, @costo, @codigoCategoria, @estado, @cantidad, @bodega);

	insert into Detalle (codigoArticulo, copiaCantidadInventario, cantidadEfecto, costo, fecha, estado, efecto, bodega, 
	comentarioUsuario, correoUsuarioCausante, nombreUsuarioCausante) values 
	(@codigoArticulo, @cantidad, @cantidad, @costo, @fechaActual, @estado, 'Entrada', @bodega, @comentarioUsuario,
	@correoUsuarioCausante, @nombreUsuarioCausante);

	COMMIT TRANSACTION;

END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
		SET @men = 1;  --Error
    END;
END CATCH;
GO

--DECLARE @mens int
--exec PAagregarArticuloInventario '987','Celular Huawei Gplay mini', '30', 2, 'Activo', 2, 'Bodega de Perú', 'Acaban de llegar
--los dos teléfono nuevos', 'nubeblanca1997@outlook.com', 'Tatiana Corrales', @men = @mens output;
--PRINT @mens;

--select * from Inventario;
--select * from Detalle;
--DROP PROCEDURE PAagregarArticuloInventario;

 CREATE PROCEDURE PAaumentarCantidadInventario
	@codigoArticulo varchar(150),
	@cantidadEfecto int,
	@comentarioUsuario ntext,
	@correoUsuarioCausante varchar(150),
	@nombreUsuarioCausante varchar(150),
	@men int output	
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
	DECLARE 
	@copiaCantidad int,
	@mens int

	SET @copiaCantidad = (select cantidad from Inventario where codigoArticulo = @codigoArticulo);

	Update Inventario SET cantidad = (@copiaCantidad + @cantidadEfecto) where codigoArticulo = @codigoArticulo;

	exec PAescribeDetalle @codigoArticulo, @cantidadEfecto, @comentarioUsuario, @correoUsuarioCausante, 
	@nombreUsuarioCausante, 'Entrada', @mens;

	IF @mens = 1
    BEGIN
		SET @men = 1; 
        THROW  50001, 'Error al ingresar el detalle', 1;
    END;

	COMMIT TRANSACTION;

END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
		SET @men = 1;  --Error
    END;
END CATCH;
GO


--DECLARE @mens int
--exec PAaumentarCantidadInventario '987', 10, 'Son muchos teléfonos', 'nubeblanca1997@outlook.com', 'Tatiana Corrales', @men = @mens output;
--PRINT @mens;

--select * from Inventario;
--select * from Detalle;
--DROP PROCEDURE PAaumentarCantidadInventario;


CREATE PROCEDURE PAagregarLicencia
	@fechaDeVencimiento datetime,
	@claveDeProducto varchar(150),
	@proveedor varchar(150),
	@descripcion varchar(500),
	@placa varchar(150),
	@correoUsuarioCausante varchar(150),
	@nombreUsuarioCausante varchar(150),
	@men int output	
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
	DECLARE 
	@fechaActual datetime,
	@nombreAsociado varchar(100),
	@correoAsociado varchar(100),
	@aclaracion varchar(300)

	SET @fechaActual = (select GETDATE());
	SET @nombreAsociado = (select nombreUsuarioAsociado from ActivoFijo where placa = @placa);
	SET @correoAsociado = (select correoUsuarioAsociado from ActivoFijo where placa = @placa);

	SET @aclaracion = 'La licencia ' + @descripcion + ' fue asociada al activo con placa ' +  @placa +
	' por ' + @nombreUsuarioCausante + ' el ' + CONVERT(VARCHAR, @fechaActual, 120);

	insert into Licencia (fechaDeVencimiento, claveDeProducto, proveedor, fechaAsociado, descripcion, placa) values
	(@fechaDeVencimiento, @claveDeProducto, @proveedor, @fechaActual, @descripcion, @placa);

	insert into HistorialActivos (placa, codigoIndicador, fechaHora, correoUsuarioCausante, nombreUsuarioCausante,
	correoUsuarioAsociado, nombreUsuarioAsociado, aclaracionSistema) values 
	(@placa, 1, @fechaActual, @correoUsuarioCausante, @nombreUsuarioCausante, @correoAsociado, @nombreAsociado, @aclaracion);

	COMMIT TRANSACTION;

END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
		SET @men = 1;  --Error
    END;
END CATCH;
GO

--DECLARE @mens int
--exec PAagregarLicencia '2019/03/30', '7845-YG76-U746-HGFT', 'Microsoft', 'Publisher', '456', 'nubeblanca1997@outlook.com', 'Tatiana Corrales', @men = @mens output;
--PRINT @mens;

--select * from Licencia;
--select * from HistorialActivos;
--DROP PROCEDURE PAagregarLicencia;

CREATE PROCEDURE PAobtenerRepuestosParaAsociar
AS

	SET NOCOUNT ON;
	select inve.codigoArticulo, inve.descripcion, inve.costo, cat.codigoCategoria, cat.nombreCategoria, inve.estado, inve.cantidad,
	inve.bodega from
	(select codigoCategoria, nombreCategoria from Categoria where esRepuesto = 1) cat,
	(select codigoArticulo, descripcion, costo, codigoCategoria, estado, cantidad, bodega from Inventario where cantidad > 0) inve
	where inve.codigoCategoria = cat.codigoCategoria;
GO
--exec PAobtenerRepuestosParaAsociar;
--select * from Inventario;
--DROP PROCEDURE PAobtenerRepuestosParaAsociar;

CREATE PROCEDURE PAasociarRepuesto
	@codigoArticulo varchar(150),
	@placa varchar(150),
	@correoUsuarioCausante varchar(150),
	@nombreUsuarioCausante varchar(150),
	@men int output	
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
	DECLARE 
	@fechaActual datetime,
	@nombreAsociado varchar(100),
	@correoAsociado varchar(100),
	@aclaracion varchar(300),
	@mens int,
	@descripcion varchar(300),
	@comentario varchar(300),
	@error varchar(10)

	SET @descripcion = (select descripcion from Inventario where codigoArticulo = @codigoArticulo);

	SET @error = ISNULL((select placa from Repuesto where descripcion = @descripcion AND placa = @placa), 'OK');
	IF @error != 'OK'
    BEGIN
		SET @men = 2; 
        THROW  50001, 'El activo ya tiene asociado ese repuesto', 1;
    END;

	SET @fechaActual = (select GETDATE());
	SET @nombreAsociado = (select nombreUsuarioAsociado from ActivoFijo where placa = @placa);
	SET @correoAsociado = (select correoUsuarioAsociado from ActivoFijo where placa = @placa);


	Update Inventario SET cantidad = (cantidad-1) where codigoArticulo = @codigoArticulo;

	SET @aclaracion = 'El repuesto ' + @descripcion + '  fue asociado al activo con placa ' +  @placa +
	'  por ' + @nombreUsuarioCausante + ' el ' + CONVERT(VARCHAR, @fechaActual, 120);

	SET @comentario = 'Un dispositivo ' + @descripcion + ' fue asociado al activo con placa ' +  @placa;

	insert into Repuesto (descripcion, fechaAsociado, placa) values (@descripcion, @fechaActual,  @placa);

	exec PAescribeDetalle @codigoArticulo, 1, @comentario, @correoUsuarioCausante, 
	@nombreUsuarioCausante, 'Salida', @mens;

	IF @mens = 1
    BEGIN
		SET @men = 1; 
        THROW  50001, 'Error al ingresar el detalle', 1;
    END;

	insert into HistorialActivos (placa, codigoIndicador, fechaHora, correoUsuarioCausante, nombreUsuarioCausante,
	correoUsuarioAsociado, nombreUsuarioAsociado, aclaracionSistema) values 
	(@placa, 2, @fechaActual, @correoUsuarioCausante, @nombreUsuarioCausante, @correoAsociado, @nombreAsociado, @aclaracion);

	COMMIT TRANSACTION;

END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @error = 'OK' 
	BEGIN
		SET @men = 1;
	END; 
END CATCH;
GO


--DECLARE @mens int
--exec PAasociarRepuesto '10', '456', 'nubeblanca1997@outlook.com', 'Tatiana Corrales', @men = @mens output;
--PRINT @mens;

--select * from Inventario;
--select * from ActivoFijo;
--select * from Repuesto;
--select * from HistorialActivos;
--select * from Detalle;
--DROP PROCEDURE PAasociarRepuesto;


 CREATE PROCEDURE PAescribeDetalle
	@codigoArticulo varchar(150),
	@cantidadEfecto int,
	@comentarioUsuario ntext,
	@correoUsuarioCausante varchar(150),
	@nombreUsuarioCausante varchar(150),
	@efecto varchar(50),
	@men int output	
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
	DECLARE 
	@fechaActual datetime,
	@copiaCantidad int,
	@copiaCosto money,
	@copiaEstado varchar(150),
	@bodega varchar(150)

	SET @fechaActual = (select GETDATE());
	SET @copiaCantidad = (select cantidad from Inventario where codigoArticulo = @codigoArticulo);
	SET @copiaCosto = (select costo from Inventario where codigoArticulo = @codigoArticulo);
	set @copiaEstado = (select estado from Inventario where codigoArticulo = @codigoArticulo);
	SET @bodega = (select bodega from Inventario where codigoArticulo = @codigoArticulo);

	insert into Detalle (codigoArticulo, copiaCantidadInventario, cantidadEfecto, costo, fecha, estado, efecto, bodega, 
	comentarioUsuario, correoUsuarioCausante, nombreUsuarioCausante) values 
	(@codigoArticulo, @copiaCantidad, @cantidadEfecto, @copiaCosto, @fechaActual, @copiaEstado, @efecto, @bodega,
	 @comentarioUsuario, @correoUsuarioCausante, @nombreUsuarioCausante);

	COMMIT TRANSACTION;

END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
		SET @men = 1;  --Error
    END;
END CATCH;
GO
--DROP PROCEDURE PAescribeDetalle;

CREATE PROCEDURE PAagregarActivo
	@codigoArticulo varchar(150),
	@correoUsuarioCausante varchar(150),
	@nombreUsuarioCausante varchar(150),
	@placa varchar(150),
	@codigoCategoria int, 
	@serie varchar(150),
	@proveedor varchar(300),
	@modelo varchar(150),
	@marca varchar(150),
	@fechaExpiraGarantia datetime,
	@correoUsuarioAsociado varchar(300),
	@nombreUsuarioAsociado varchar(100),
	@departamentoUsuarioAsociado varchar(150),
	@jefaturaUsuarioAsociado varchar(100), 
	@men int output	
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
	DECLARE 
	@fechaActual datetime,
	@aclaracion varchar(300),
	@mens int,
	@descripcion varchar(300),
	@comentario varchar(300),
	@error varchar(10)

	SET @descripcion = (select descripcion from Inventario where codigoArticulo = @codigoArticulo);
	SET @fechaActual = (select GETDATE());

	Update Inventario SET cantidad = (cantidad-1) where codigoArticulo = @codigoArticulo;

	SET @aclaracion = 'El dispositivo ' + @descripcion + '  con placa ' +  @placa + ' fue asociado al usuario ' +  
	@nombreUsuarioAsociado + ' con correo ' + @correoUsuarioAsociado +
	'  por ' + @nombreUsuarioCausante + ' el ' + CONVERT(VARCHAR, @fechaActual, 120);

	SET @comentario = 'Un dispositivo ' + @descripcion + ' fue asociado al usuario ' +  @nombreUsuarioAsociado +
	' con correo ' + @correoUsuarioAsociado;

	insert into ActivoFijo (placa, codigoCategoria, codigoEstado, serie, proveedor, modelo, marca, 
	fechaSalidaInventario, fechaExpiraGarantia, correoUsuarioAsociado, nombreUsuarioAsociado, departamentoUsuarioAsociado, 
	jefaturaUsuarioAsociado) values (@placa, @codigoCategoria, 1, @serie, @proveedor, @modelo, @marca, @fechaActual,
	@fechaExpiraGarantia, @correoUsuarioAsociado, @nombreUsuarioAsociado, @departamentoUsuarioAsociado,
	@jefaturaUsuarioAsociado);

	exec PAescribeDetalle @codigoArticulo, 1, @comentario, @correoUsuarioCausante, 
	@nombreUsuarioCausante, 'Salida', @mens;

	IF @mens = 1
    BEGIN
		SET @men = 1; 
        THROW  50001, 'Error al ingresar el detalle', 1;
    END;

	insert into HistorialActivos (placa, codigoIndicador, fechaHora, correoUsuarioCausante, nombreUsuarioCausante,
	correoUsuarioAsociado, nombreUsuarioAsociado, aclaracionSistema) values 
	(@placa, 3, @fechaActual, @correoUsuarioCausante, @nombreUsuarioCausante, @correoUsuarioAsociado, 
	@nombreUsuarioAsociado, @aclaracion);

	COMMIT TRANSACTION;

END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	SET @men = 1; 
END CATCH;
GO


--DECLARE @mens int
--exec PAagregarActivo '11', 'nubeblanca1997@outlook.com', 'Tatiana Corrales', '777', 1, '763U', 'Proveedor Misaki', 'Modelo con muchas manchas', 'Marca gatito', 
-- '2018/04/30', 'nubeblanca1997@outlook.com', 'Cristina Cascante', 'Tecnología de la información', 'Cristina Cascante',
--  @men = @mens output;
--PRINT @mens;

--select * from Inventario;
--select * from ActivoFijo;
--select * from HistorialActivos;
--select * from Detalle;
--DROP PROCEDURE PAagregarActivo;



--Para llenar el combo de usuarios cuando se quiere asociar un activo 
CREATE PROCEDURE PAobtenerUsuariosParaAsociar   
AS  
    SET NOCOUNT ON;
	select nombreUsuario, departamento, jefatura, correo, codigoEmpleado from RecursosHumanos;
GO
--exec PAobtenerUsuariosParaAsociar;


CREATE PROCEDURE PAobtenerBodegas   
AS  
    SET NOCOUNT ON;
	select nombreBodega from Bodega;
GO
--exec PAobtenerBodegas;


CREATE PROCEDURE PAadjuntarContrato
	@placa varchar(150),
	@direccionAdjunto varchar(150),
	@correoUsuarioCausante varchar(150),
	@nombreUsuarioCausante varchar(150),
	@men int output	
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
	DECLARE 
	@fechaActual datetime,
	@nombreAsociado varchar(100),
	@correoAsociado varchar(100),
	@aclaracion varchar(300)

	SET @fechaActual = (select GETDATE());
	SET @nombreAsociado = (select nombreUsuarioAsociado from ActivoFijo where placa = @placa);
	SET @correoAsociado = (select correoUsuarioAsociado from ActivoFijo where placa = @placa);

	SET @aclaracion = 'Un documento fue asociado al activo con placa ' +  @placa +
	' por ' + @nombreUsuarioCausante + ' el ' + CONVERT(VARCHAR, @fechaActual, 120);

	insert into HistorialActivos (placa, codigoIndicador, fechaHora, correoUsuarioCausante, nombreUsuarioCausante,
	correoUsuarioAsociado, nombreUsuarioAsociado, comentarioUsuario, aclaracionSistema) values 
	(@placa, 4, @fechaActual, @correoUsuarioCausante, @nombreUsuarioCausante, @correoAsociado, @nombreAsociado, @direccionAdjunto, @aclaracion);

	COMMIT TRANSACTION;

END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
		SET @men = 1;  --Error
    END;
END CATCH;
GO

--DECLARE @mens int
--exec PAadjuntarContrato '456', 'C:algun/lugar/archivito.pdf', 'nubeblanca1997@outlook.com', 'Tatiana Corrales', @men = @mens output;
--PRINT @mens;

--select * from activoFijo;
--select * from HistorialActivos;
--DROP PROCEDURE PAadjuntarContrato;

 CREATE PROCEDURE PAobtenerDocumentosAsociados
	@placa varchar(150)
 AS

	SET NOCOUNT ON;
	select comentarioUsuario from HistorialActivos where placa = @placa AND codigoIndicador = 4;
 GO
 --exec PAobtenerDocumentosAsociados '456';


 CREATE PROCEDURE PAobtenerEstadosEquipo
	@codigoEstadoActual int
 AS
	SET NOCOUNT ON;
	select esta.codigoEstado, esta.nombreEstado from
	(select estadoEquipoSiguiente from EstadoEquipoPermitido where estadoEquipoActual = @codigoEstadoActual) per,
	(select codigoEstado, nombreEstado from EstadoEquipo) esta
	where esta.codigoEstado = per.estadoEquipoSiguiente;
 GO

 --INSERTS
 insert into estadoEquipo (codigoEstado, nombreEstado) values (1, 'En uso');
 insert into estadoEquipo (codigoEstado, nombreEstado) values (2, 'En reparación');
 insert into estadoEquipo (codigoEstado, nombreEstado) values (3, 'En mantenimiento');
 insert into estadoEquipo (codigoEstado, nombreEstado) values (4, 'Espera ser desechado');
 insert into estadoEquipo (codigoEstado, nombreEstado) values (5, 'Desechado');
 insert into estadoEquipo (codigoEstado, nombreEstado) values (6, 'Sin usuario asociado');

 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (1, 2);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (1, 3);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (1, 4);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (1, 6);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (2, 1);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (2, 4);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (2, 6);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (3, 1);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (3, 4);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (3, 6);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (4, 5);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (6, 1);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (6, 3);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (6, 4);

 insert into Categoria(codigoCategoria, nombreCategoria, esRepuesto) values (1, 'Portatil', 0);
 insert into Categoria(codigoCategoria, nombreCategoria, esRepuesto) values (2, 'Teléfono móvil', 0);
 insert into Categoria(codigoCategoria, nombreCategoria, esRepuesto) values (3, 'Impresora', 0);
 insert into Categoria(codigoCategoria, nombreCategoria, esRepuesto) values (4, 'Batería', 1);
 insert into Categoria(codigoCategoria, nombreCategoria, esRepuesto) values (5, 'Cargador', 1);
 insert into Categoria(codigoCategoria, nombreCategoria, esRepuesto) values (6, 'Pantalla', 0);
 insert into Categoria(codigoCategoria, nombreCategoria, esRepuesto) values (7, 'Teclado', 1);
 insert into Categoria(codigoCategoria, nombreCategoria, esRepuesto) values (8, 'Chip', 1);
 insert into Categoria(codigoCategoria, nombreCategoria, esRepuesto) values (9, 'Docking station', 1);
 insert into Categoria(codigoCategoria, nombreCategoria, esRepuesto) values (10, 'Mouse', 1);
 insert into Categoria(codigoCategoria, nombreCategoria, esRepuesto) values (11, 'Cargador para móvil', 1);
 insert into Categoria(codigoCategoria, nombreCategoria, esRepuesto) values (12, 'Memoria', 1);
 insert into Categoria(codigoCategoria, nombreCategoria, esRepuesto) values (13, 'Otros', 1);

 
 insert into Bodega (nombreBodega) values ('Bodega oficinas centrales');
 insert into Bodega (nombreBodega) values ('Bodega centro de distribución');
 insert into Bodega (nombreBodega) values ('Bodega de Perú');

 --Inventario
 insert into Inventario(codigoArticulo, descripcion, costo, codigoCategoria, estado, cantidad, bodega) values ('10', 'Bateria Dell 72X', '50', 4, 'Activo', 5, 'Bodega oficinas centrales');
 insert into Inventario(codigoArticulo, descripcion, costo, codigoCategoria, estado, cantidad, bodega) values ('11', 'Laptop Dell Inspiron', '60', 1, 'Activo', 2, 'Bodega centro de distribución');



 --Activos fijos 
  insert into ActivoFijo (placa, codigoCategoria, codigoEstado, serie, proveedor, modelo, marca, 
 fechaSalidaInventario, fechaExpiraGarantia, correoUsuarioAsociado, nombreUsuarioAsociado, departamentoUsuarioAsociado, jefaturaUsuarioAsociado) 
 values ('456', 1, 1, 'T67Y8', 'DELL', 'Inspiron', 'DELL', 
 '2018/03/25','2018/04/30', 'nubeblanca1997@outlook.com', 'Cristina Cascante', 'Tecnología de la información', 'Cristina Cascante');
  insert into ActivoFijo (placa, codigoCategoria, codigoEstado, serie, proveedor, modelo, marca, 
 fechaSalidaInventario, fechaExpiraGarantia, correoUsuarioAsociado, nombreUsuarioAsociado, departamentoUsuarioAsociado, jefaturaUsuarioAsociado) 
 values ('567', 1, 1, 'T6751', 'Soluciones Electrónicas', 'Ideapad', 'Lenovo', 
 '2018/03/29','2018/07/30', 'nubeblanca1997@outlook.com', 'Cristina Cascante', 'Tecnología de la información', 'Cristina Cascante');
  insert into ActivoFijo (placa, codigoCategoria, codigoEstado, serie, proveedor, modelo, marca, 
 fechaSalidaInventario, fechaExpiraGarantia, correoUsuarioAsociado, nombreUsuarioAsociado, departamentoUsuarioAsociado, jefaturaUsuarioAsociado) 
 values ('678', 1, 1, '8472F', 'HP', 'Spectre', 'HP',
 '2018/03/26','2018/08/30', 'nubeblanca1997@outlook.com', 'Cristina Cascante', 'Tecnología de la información', 'Cristina Cascante');

 
 
 insert into Licencia (fechaDeVencimiento, claveDeProducto, proveedor, fechaAsociado, descripcion, placa)
 values ('2018/08/30', '2356-7763-U746-HGFT', 'Microsoft', '2018/03/24', 'Excel', '456');
 insert into Licencia (fechaDeVencimiento, claveDeProducto, proveedor, fechaAsociado, descripcion, placa)
 values ('2018/08/30', '8304-7763-U74G-HGFT', 'Microsoft', '2018/03/24', 'Word document', '567');
 insert into Licencia (fechaDeVencimiento, claveDeProducto, proveedor, fechaAsociado, descripcion, placa)
 values ('2018/08/30', '2830-7253-UR46-HBFT', 'Microsoft', '2018/03/24', 'Power Point', '678');

 
 insert into Repuesto (descripcion, fechaAsociado, placa) values ('Mouse', '2018/03/24', '456');
 insert into Repuesto (descripcion, fechaAsociado, placa) values ('Teclado', '2018/03/24', '456');
 insert into Repuesto (descripcion, fechaAsociado, placa) values ('Parlante', '2018/03/24', '567');
 insert into Repuesto (descripcion, fechaAsociado, placa) values ('Adaptador HDMI', '2018/03/24', '678');
 

 insert into IndicadoresActivos (codigoIndicador, descripcionIndicador) values (1, 'Asocia licencia');
 insert into IndicadoresActivos (codigoIndicador, descripcionIndicador) values (2, 'Asocia repuesto');
 insert into IndicadoresActivos (codigoIndicador, descripcionIndicador) values (3, 'Activo creado');
 insert into IndicadoresActivos (codigoIndicador, descripcionIndicador) values (4, 'Adjunta documento');


 --DROPS
 DROP TABLE HistorialActivos;
 DROP TABLE IndicadoresActivos;
 DROP TABLE Licencia;
 DROP TABLE Repuesto;
 DROP TABLE ActivoFijo;
 DROP TABLE EstadoEquipoPermitido;
 DROP TABLE EstadoEquipo;
 DROP TABLE Detalle;
 DROP TABLE Inventario;
 DROP TABLE Categoria;
 DROP TABLE Bodega;
 

 DROP PROCEDURE PAobtenerInventario;
 DROP PROCEDURE PAobtenerActivosFijos;
 DROP PROCEDURE PAobtenerLicencias;
 DROP PROCEDURE PAobtenerRepuestos;
 DROP PROCEDURE PAobtenerCategorias;
 DROP PROCEDURE PAagregarArticuloInventario;
 DROP PROCEDURE PAaumentarCantidadInventario;
 DROP PROCEDURE PAagregarLicencia;
 DROP PROCEDURE PAobtenerRepuestosParaAsociar;
 DROP PROCEDURE PAescribeDetalle;
 DROP PROCEDURE PAasociarRepuesto;
 DROP PROCEDURE PAagregarActivo;
 DROP PROCEDURE PAobtenerUsuariosParaAsociar;        --Simula recursos humanos
 DROP PROCEDURE PAobtenerBodegas;
 DROP PROCEDURE PAadjuntarContrato;
 DROP PROCEDURE PAobtenerDocumentosAsociados;

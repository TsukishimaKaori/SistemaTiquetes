PACREATE TABLE EstadoEquipo(
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
 codigoBodega int NOT NULL,
 nombreBodega varchar(150) NOT NULL,
  CONSTRAINT PKBodega PRIMARY KEY(codigoBodega)
 )
 GO

 CREATE TABLE Inventario(
 codigoArticulo varchar(150) NOT NULL,
 descripcion varchar(150) NOT NULL, 
 costo money NOT NULL,
 codigoCategoria int NOT NULL,
 estado varchar(150) NOT NULL,
 cantidad int NOT NULL,
 codigoBodega int NOT NULL,
 CONSTRAINT PKInventario PRIMARY KEY(codigoArticulo, codigoBodega),
 CONSTRAINT FKInventarioCategoria FOREIGN KEY (codigoCategoria) REFERENCES Categoria(codigoCategoria),
 CONSTRAINT FKInventarioBodega FOREIGN KEY (codigoBodega) REFERENCES Bodega(codigoBodega)
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
 codigoBodega int NOT NULL, 
 comentarioUsuario ntext NOT NULL,
 correoUsuarioCausante varchar(150) NOT NULL,
 nombreUsuarioCausante varchar(150) NOT NULL,
 CONSTRAINT PKDetalle PRIMARY KEY(codigoDetalle),
 CONSTRAINT FKDetalleInventario FOREIGN KEY (codigoArticulo, codigoBodega) REFERENCES Inventario(codigoArticulo, codigoBodega)
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

 CREATE TABLE TiquetesActivos(
 codigoTiquete int NOT NULL,
 placa varchar(150) NOT NULL,
 fechaAsociado datetime NOT NULL,
 CONSTRAINT PKTiquetesActivos PRIMARY KEY(codigoTiquete, placa),
 CONSTRAINT FKTiquetesActivosActivo FOREIGN KEY (placa) REFERENCES ActivoFijo(placa),
 CONSTRAINT FKTiquetesActivosTiquete  FOREIGN KEY (codigoTiquete) REFERENCES Tiquete(codigoTiquete)
 )
 GO
-- DROP TABLE TiquetesActivos;

 --Obtiene los item del inventario, los prefiltra obteniendo solo los que no son repuestos
CREATE PROCEDURE PAobtenerInventario
AS
	SET NOCOUNT ON;
	select inve.codigoArticulo, inve.descripcion, inve.costo, cat.codigoCategoria, cat.nombreCategoria, cat.esRepuesto, inve.estado, inve.cantidad,
	inve.codigoBodega, bode.nombreBodega from
	(select codigoCategoria, nombreCategoria, esRepuesto from Categoria where esRepuesto = 0) cat,
	(select codigoBodega, nombreBodega from Bodega) bode,
	(select codigoArticulo, descripcion, costo, codigoCategoria, estado, cantidad, codigoBodega from Inventario) inve
	where inve.codigoCategoria = cat.codigoCategoria AND inve.codigoBodega = bode.codigoBodega;
GO
 --DROP PROCEDURE PAobtenerInventario
 --exec PAobtenerInventario;	
	

 --Prefiltra por activos cuyo estado no sea espera desechado o desechado
 CREATE PROCEDURE PAobtenerActivosFijos
 AS
	SET NOCOUNT ON;
	select activo.placa, cat.codigoCategoria, cat.nombreCategoria, cat.esRepuesto, estado.codigoEstado, estado.nombreEstado,
	activo.serie, activo.proveedor, activo.modelo, activo.marca, activo.fechaSalidaInventario, activo.fechaDesechado,
	activo.fechaExpiraGarantia, activo.correoUsuarioAsociado, activo.nombreUsuarioAsociado,
	activo.departamentoUsuarioAsociado, activo.jefaturaUsuarioAsociado from
	(select codigoCategoria, nombreCategoria, esRepuesto from Categoria where esRepuesto = 0) cat,
	(select codigoEstado, nombreEstado from EstadoEquipo where codigoEstado != 4 AND codigoEstado != 5) estado,
	(select placa, codigoCategoria, codigoEstado, serie, proveedor, modelo, marca, 
	fechaSalidaInventario, fechaDesechado, fechaExpiraGarantia, correoUsuarioAsociado, nombreUsuarioAsociado, 
	departamentoUsuarioAsociado, jefaturaUsuarioAsociado from ActivoFijo where codigoEstado != 4 AND codigoEstado != 5) activo
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
	@codigoBodega int,
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
	insert into Inventario (codigoArticulo, descripcion, costo, codigoCategoria, estado, cantidad, codigoBodega) values
	(@codigoArticulo, @descripcion, @costo, @codigoCategoria, @estado, @cantidad, @codigoBodega);

	insert into Detalle (codigoArticulo, copiaCantidadInventario, cantidadEfecto, costo, fecha, estado, efecto, codigoBodega, 
	comentarioUsuario, correoUsuarioCausante, nombreUsuarioCausante) values 
	(@codigoArticulo, @cantidad, @cantidad, @costo, @fechaActual, @estado, 'Entrada', @codigoBodega, @comentarioUsuario,
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
--exec PAagregarArticuloInventario '987','Celular Huawei Gplay mini', '30', 2, 'Activo', 2, 3, 'Acaban de llegar
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

	SET @men = 0;
	IF (select codigoEstado from ActivoFijo where placa = @placa) = 5
	BEGIN
		SET @men = 2;
		THROW  50001, 'El equipo fue desechado', 1;
	END;

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
    END;
	IF @men = 0
	BEGIN
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
	inve.codigoBodega, bode.nombreBodega from
	(select codigoCategoria, nombreCategoria from Categoria where esRepuesto = 1) cat,
	(select codigoBodega, nombreBodega from Bodega) bode,
	(select codigoArticulo, descripcion, costo, codigoCategoria, estado, cantidad, codigoBodega from Inventario where cantidad > 0) inve
	where inve.codigoCategoria = cat.codigoCategoria AND inve.codigoBodega = bode.codigoBodega;
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

	IF (select codigoEstado from ActivoFijo where placa = @placa) = 5
	BEGIN
		SET @men = 3;
		THROW  50001, 'El equipo fue desechado', 1;
	END;

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
	IF @error = 'OK' AND @men != 3
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
	@bodega int

	SET @fechaActual = (select GETDATE());
	SET @copiaCantidad = (select cantidad from Inventario where codigoArticulo = @codigoArticulo);
	SET @copiaCosto = (select costo from Inventario where codigoArticulo = @codigoArticulo);
	set @copiaEstado = (select estado from Inventario where codigoArticulo = @codigoArticulo);
	SET @bodega = (select codigoBodega from Inventario where codigoArticulo = @codigoArticulo);

	insert into Detalle (codigoArticulo, copiaCantidadInventario, cantidadEfecto, costo, fecha, estado, efecto, codigoBodega, 
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
	select codigoBodega, nombreBodega from Bodega;
GO
--exec PAobtenerBodegas;
--DROP PROCEDURE PAobtenerBodegas;


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

	IF (select codigoEstado from ActivoFijo where placa = @placa) = 5
	BEGIN
		SET @men = 2;
		THROW  50001, 'El equipo fue desechado', 1;
	END;

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
    END;
	IF @men != 2
	BEGIN
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
 --exec PAobtenerEstadosEquipo 4;


CREATE PROCEDURE PAactualizarEstadoEquipo
	@placa varchar(150),
	@codigoEstadoSiguiente int,
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
	@fechaActual datetime,
	@nombreAsociado varchar(100),
	@correoAsociado varchar(100),
	@aclaracion varchar(300),
	@nombreEstadoActual varchar(100),
	@nombreEstadoSiguiente varchar(100)

	IF (select codigoEstado from ActivoFijo where placa = @placa) = 5
	BEGIN
		SET @men = 2;
		THROW  50001, 'Error al ingresar el detalle', 1;
	END;

	SET @fechaActual = (select GETDATE());
	SET @nombreAsociado = (select nombreUsuarioAsociado from ActivoFijo where placa = @placa);
	SET @correoAsociado = (select correoUsuarioAsociado from ActivoFijo where placa = @placa);
	SET @nombreEstadoActual =
	(select est.nombreEstado from
	(select codigoEstado from ActivoFijo where placa = @placa) act,
	(select codigoEstado, nombreEstado from EstadoEquipo) est
	where act.codigoEstado = est.codigoEstado);
	SET @nombreEstadoSiguiente = (select nombreEstado from EstadoEquipo where codigoEstado = @codigoEstadoSiguiente);

	SET @aclaracion = 'El estado del activo con placa ' +  @placa + ' fue actualizado de '+ @nombreEstadoActual + ' a ' +
	@nombreEstadoSiguiente + ' por ' + @nombreUsuarioCausante + ' el ' + CONVERT(VARCHAR, @fechaActual, 120);

	IF @codigoEstadoSiguiente = 5 
	BEGIN
		update ActivoFijo SET codigoEstado = @codigoEstadoSiguiente, fechaDesechado = @fechaActual where placa = @placa;
	END;

	update ActivoFijo SET codigoEstado = @codigoEstadoSiguiente where placa = @placa;

	insert into HistorialActivos (placa, codigoIndicador, fechaHora, correoUsuarioCausante, nombreUsuarioCausante,
	correoUsuarioAsociado, nombreUsuarioAsociado, comentarioUsuario, aclaracionSistema) values 
	(@placa, 5, @fechaActual, @correoUsuarioCausante, @nombreUsuarioCausante, @correoAsociado, @nombreAsociado, @comentarioUsuario, @aclaracion);

	COMMIT TRANSACTION;
	
END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @men != 2
	BEGIN
		SET @men = 1;  --Error
	END;
	
END CATCH;
GO

--DECLARE @mens int
--exec PAactualizarEstadoEquipo '567', 1, 'El dispositivo necesita ser examinado', 'nubeblanca1997@outlook.com', 'Tatiana Corrales', @men = @mens output;
--PRINT @mens;

--select * from ActivoFijo;
--select * from HistorialActivos;
--DROP PROCEDURE PAactualizarEstadoEquipo;


 CREATE PROCEDURE PAobtenerDetalleArticuloInventario
	@codigoArticulo varchar(150),
	@codigoBodega int
 AS
	SET NOCOUNT ON;
	select inve.codigoDetalle, inve.codigoArticulo, inve.copiaCantidadInventario, inve.cantidadEfecto, inve.costo, inve.fecha,
	inve.estado, inve.efecto, inve.codigoBodega, bode.nombreBodega, inve.comentarioUsuario, inve.correoUsuarioCausante, 
	inve.nombreUsuarioCausante from
	(select codigoBodega, nombreBodega from Bodega where codigoBodega = @codigoBodega) bode,
 	(select codigoDetalle, codigoArticulo, copiaCantidadInventario, cantidadEfecto, costo, fecha,
	estado, efecto, codigoBodega, comentarioUsuario, correoUsuarioCausante, nombreUsuarioCausante from Detalle 
	where codigoArticulo = @codigoArticulo AND codigoBodega = @codigoBodega) inve
	where bode.codigoBodega = inve.codigoBodega;
 GO
 --exec PAobtenerDetalleArticuloInventario '10', 1;
-- DROP PROCEDURE PAobtenerDetalleArticuloInventario;


CREATE PROCEDURE PAobtenerHistorialActivosFijos
	@placa varchar(150)
 AS
	SET NOCOUNT ON;
	select his.codigoHistorial, his.placa, indi.descripcionIndicador, his.fechaHora, his.correoUsuarioCausante,
	his.nombreUsuarioCausante, his.correoUsuarioAsociado, his.nombreUsuarioAsociado, his.comentarioUsuario,
	his.aclaracionSistema from
	(select codigoIndicador, descripcionIndicador from IndicadoresActivos) indi,
	(select codigoHistorial, placa, codigoIndicador, fechaHora, correoUsuarioCausante, nombreUsuarioCausante,
	correoUsuarioAsociado, nombreUsuarioAsociado, comentarioUsuario, aclaracionSistema from HistorialActivos 
	where placa = @placa) his 
	where indi.codigoIndicador = his.codigoIndicador;
 GO
-- exec PAobtenerHistorialActivosFijos '456';
 --DROP PROCEDURE PAobtenerHistorialActivosFijos;


 CREATE PROCEDURE PAeliminarLicencia
	@claveDeProducto varchar(150),
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
	@descripcion varchar(150),
	@error varchar(150)

	IF (select codigoEstado from ActivoFijo where placa = @placa) = 5
	BEGIN
		SET @men = 2;
		THROW  50001, 'El equipo fue desechado', 1;
	END;
	SET @error = ISNULL((select claveDeProducto from Licencia where claveDeProducto = @claveDeProducto), 'Error');
    IF @error = 'Error'
	BEGIN
		SET @men = 3;
		THROW  50001, 'No existe la licencia a eliminar', 1;
	END;

	SET @fechaActual = (select GETDATE());
	SET @nombreAsociado = (select nombreUsuarioAsociado from ActivoFijo where placa = @placa);
	SET @correoAsociado = (select correoUsuarioAsociado from ActivoFijo where placa = @placa);
	SET @descripcion = (select descripcion from Licencia where claveDeProducto = @claveDeProducto);

	SET @aclaracion = 'La licencia ' + @descripcion + ' fue eliminada del activo con placa ' +  @placa +
	' por ' + @nombreUsuarioCausante + ' el ' + CONVERT(VARCHAR, @fechaActual, 120);

	delete Licencia where claveDeProducto = @claveDeProducto;

	insert into HistorialActivos (placa, codigoIndicador, fechaHora, correoUsuarioCausante, nombreUsuarioCausante,
	correoUsuarioAsociado, nombreUsuarioAsociado, aclaracionSistema) values 
	(@placa, 6, @fechaActual, @correoUsuarioCausante, @nombreUsuarioCausante, @correoAsociado, @nombreAsociado, @aclaracion);

	COMMIT TRANSACTION;

END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @men != 2 AND @men != 3
	BEGIN
		SET @men = 1;  --Error
	END;

END CATCH;
GO

--DECLARE @mens int
--exec PAeliminarLicencia '2830-7253-UR46-HBFT', '678', 'nubeblanca1997@outlook.com', 'Tatiana Corrales', @men = @mens output;
--PRINT @mens;

--select * from Licencia;
--select * from HistorialActivos;
--DROP PROCEDURE PAeliminarLicencia;


CREATE PROCEDURE PAeliminarRepuesto
	@descripcion varchar(150),
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
	@error varchar(10)

	IF (select codigoEstado from ActivoFijo where placa = @placa) = 5
	BEGIN
		SET @men = 3;
		THROW  50001, 'El equipo fue desechado', 1;
	END;

	SET @error = ISNULL((select placa from Repuesto where descripcion = @descripcion AND placa = @placa), 'Error');
	IF @error = 'Error'
    BEGIN
		SET @men = 2; 
        THROW  50001, 'El repuesto esta relacionado al activo', 1;
    END;

	SET @fechaActual = (select GETDATE());
	SET @nombreAsociado = (select nombreUsuarioAsociado from ActivoFijo where placa = @placa);
	SET @correoAsociado = (select correoUsuarioAsociado from ActivoFijo where placa = @placa);

	SET @aclaracion = 'El repuesto ' + @descripcion + '  fue eliminado del activo con placa ' +  @placa +
	'  por ' + @nombreUsuarioCausante + ' el ' + CONVERT(VARCHAR, @fechaActual, 120);

	delete Repuesto where descripcion = @descripcion AND placa = @placa;

	insert into HistorialActivos (placa, codigoIndicador, fechaHora, correoUsuarioCausante, nombreUsuarioCausante,
	correoUsuarioAsociado, nombreUsuarioAsociado, aclaracionSistema) values 
	(@placa, 7, @fechaActual, @correoUsuarioCausante, @nombreUsuarioCausante, @correoAsociado, @nombreAsociado, @aclaracion);

	COMMIT TRANSACTION;

END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @men != 2 AND @men != 3
	BEGIN
		SET @men = 1;
	END; 
END CATCH;
GO


--DECLARE @mens int
--exec PAeliminarRepuesto 'Parlante', '567', 'nubeblanca1997@outlook.com', 'Tatiana Corrales', @men = @mens output;
--PRINT @mens;

--select * from ActivoFijo;
--select * from Repuesto;
--select * from HistorialActivos;
--DROP PROCEDURE PAeliminarRepuesto;


CREATE PROCEDURE PAasociarUsuarioActivo
	@placa varchar(150),
	@correoUsuarioCausante varchar(150),
	@nombreUsuarioCausante varchar(150),
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
	@nombreCategoria varchar(300)

	IF (select codigoEstado from ActivoFijo where placa = @placa) = 5
	BEGIN
		SET @men = 2;
		THROW  50001, 'El equipo fue desechado', 1;
	END;

	SET @nombreCategoria = (select cat.nombreCategoria from 
	(select codigoCategoria, nombreCategoria from Categoria) cat,
	(select codigoCategoria from ActivoFijo where placa = @placa) act
	 where cat.codigoCategoria = act.codigoCategoria);
	SET @fechaActual = (select GETDATE());


	SET @aclaracion = 'El dispositivo ' + @nombreCategoria + '  con placa ' +  @placa + ' fue asociado al usuario ' +  
	@nombreUsuarioAsociado + ' con correo ' + @correoUsuarioAsociado +
	'  por ' + @nombreUsuarioCausante + ' el ' + CONVERT(VARCHAR, @fechaActual, 120);

	update ActivoFijo SET correoUsuarioAsociado = @correoUsuarioAsociado, nombreUsuarioAsociado = @nombreUsuarioAsociado,
	departamentoUsuarioAsociado = @departamentoUsuarioAsociado, jefaturaUsuarioAsociado = @jefaturaUsuarioAsociado
	where placa = @placa;

	insert into HistorialActivos (placa, codigoIndicador, fechaHora, correoUsuarioCausante, nombreUsuarioCausante,
	correoUsuarioAsociado, nombreUsuarioAsociado, aclaracionSistema) values 
	(@placa, 8, @fechaActual, @correoUsuarioCausante, @nombreUsuarioCausante, @correoUsuarioAsociado, 
	@nombreUsuarioAsociado, @aclaracion);

	COMMIT TRANSACTION;

END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @men != 2
	BEGIN
		SET @men = 1; 
	END;
END CATCH;
GO


--DECLARE @mens int
--exec PAasociarUsuarioActivo '678', 'nubeblanca1997@outlook.com', 'Tatiana Corrales', 'nubeblanca1997@outlook.com', 'Shimosutki Kanshikan', 'Relaciones Internacionales', 'Tsunemori Akane',
--  @men = @mens output;
--PRINT @mens;

--select * from ActivoFijo;
--select * from HistorialActivos;
--DROP PROCEDURE PAasociarUsuarioActivo;


CREATE PROCEDURE PAeliminarUsuarioActivo
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
	@aclaracion varchar(300),
	@mens int,
	@nombreCategoria varchar(300)


	SET @nombreCategoria = (select cat.nombreCategoria from 
	(select codigoCategoria, nombreCategoria from Categoria) cat,
	(select codigoCategoria from ActivoFijo where placa = @placa) act
	 where cat.codigoCategoria = act.codigoCategoria);
	SET @fechaActual = (select GETDATE());


	SET @aclaracion = 'Al dispositivo ' + @nombreCategoria + '  con placa ' +  @placa + ' le fue eliminado el propietario ' +  
	'  por ' + @nombreUsuarioCausante + ' el ' + CONVERT(VARCHAR, @fechaActual, 120);

	update ActivoFijo SET correoUsuarioAsociado = NULL, nombreUsuarioAsociado = NULL,
	departamentoUsuarioAsociado = NULL, jefaturaUsuarioAsociado = NULL
	where placa = @placa;

	insert into HistorialActivos (placa, codigoIndicador, fechaHora, correoUsuarioCausante, nombreUsuarioCausante,
	aclaracionSistema) values 
	(@placa, 9, @fechaActual, @correoUsuarioCausante, @nombreUsuarioCausante, 
	@aclaracion);

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
--exec PAeliminarUsuarioActivo '678', 'nubeblanca1997@outlook.com', 'Tatiana Corrales',@men = @mens output;
--PRINT @mens;

--select * from ActivoFijo;
--select * from HistorialActivos;
--DROP PROCEDURE PAeliminarUsuarioActivo;


 CREATE PROCEDURE PAbusquedaAvanzadaInventario
	@codigoArticulo varchar(150),
	@descripcion varchar(150),
	@nombreCategoria varchar(150),   
	@esRepuesto varchar(30),
	@nombreBodega varchar(150)   
 AS
	SET NOCOUNT ON;
	SET @codigoArticulo = '%' + @codigoArticulo + '%';
	SET @descripcion = '%' + @descripcion + '%';
	SET @nombreCategoria = '%' + @nombreCategoria + '%';
	SET @esRepuesto = '%' + @esRepuesto + '%';
	SET @nombreBodega = '%' + @nombreBodega + '%';

	select inve.codigoArticulo, inve.descripcion, inve.costo, cat.codigoCategoria, cat.nombreCategoria, cat.esRepuesto, inve.estado, inve.cantidad,
	inve.codigoBodega, bode.nombreBodega from
	(select codigoCategoria, nombreCategoria, esRepuesto from Categoria where nombreCategoria COLLATE Latin1_General_CI_AI like @nombreCategoria
	AND esRepuesto like @esRepuesto) cat,
	(select codigoBodega, nombreBodega from Bodega where nombreBodega COLLATE Latin1_General_CI_AI like @nombreBodega) bode,
	(select codigoArticulo, descripcion, costo, codigoCategoria, estado, cantidad, codigoBodega from Inventario
	where codigoArticulo like @codigoArticulo AND descripcion COLLATE Latin1_General_CI_AI like @descripcion) inve
	where inve.codigoCategoria = cat.codigoCategoria AND inve.codigoBodega = bode.codigoBodega;
 GO
 --exec PAbusquedaAvanzadaInventario '', '', '', '', 'peru'; 
 --DROP PROCEDURE PAbusquedaAvanzadaInventario;


 
 CREATE PROCEDURE PAbusquedaAvanzadaActivos
	@placa varchar(150),
	@codigoEstado varchar(150),
	@nombreCategoria varchar(150),   
	@marca varchar(150),
	@nombreUsuario varchar(150),
	@correoUsuario varchar(150)   
 AS
	SET NOCOUNT ON;
	SET @placa = '%' + @placa + '%';
	SET @codigoEstado = '%' + @codigoEstado + '%';
	SET @nombreCategoria = '%' + @nombreCategoria + '%';
	SET @marca = '%' + @marca + '%';
	SET @nombreUsuario = '%' + @nombreUsuario + '%';
	SET @correoUsuario = '%' + @correoUsuario + '%';

	select activo.placa, cat.codigoCategoria, cat.nombreCategoria, cat.esRepuesto, estado.codigoEstado, estado.nombreEstado,
	activo.serie, activo.proveedor, activo.modelo, activo.marca, activo.fechaSalidaInventario, activo.fechaDesechado,
	activo.fechaExpiraGarantia, activo.correoUsuarioAsociado, activo.nombreUsuarioAsociado,
	activo.departamentoUsuarioAsociado, activo.jefaturaUsuarioAsociado from
	(select codigoCategoria, nombreCategoria, esRepuesto from Categoria where nombreCategoria COLLATE Latin1_General_CI_AI 
	like @nombreCategoria AND esRepuesto = 0) cat,
	(select codigoEstado, nombreEstado from EstadoEquipo where codigoEstado like @codigoEstado) estado,
	(select placa, codigoCategoria, codigoEstado, serie, proveedor, modelo, marca, 
	fechaSalidaInventario, fechaDesechado, fechaExpiraGarantia, correoUsuarioAsociado, nombreUsuarioAsociado, 
	departamentoUsuarioAsociado, jefaturaUsuarioAsociado from ActivoFijo where codigoEstado like @codigoEstado
	AND placa like @placa AND marca COLLATE Latin1_General_CI_AI like @marca AND 
	nombreUsuarioAsociado COLLATE Latin1_General_CI_AI like @nombreUsuario AND correoUsuarioAsociado like @correoUsuario ) activo
	where activo.codigoCategoria = cat.codigoCategoria AND activo.codigoEstado = estado.codigoEstado;
 GO
 --DROP PROCEDURE PAbusquedaAvanzadaActivos;
 --exec PAbusquedaAvanzadaActivos '', '1', '', '', 'cas', '';
 --select * from ActivoFijo;

 --Obtiene todos los activos relacionados a un usuario que no se encuentren en estado Espera ser desechado o desechado 
 CREATE PROCEDURE PAobtenerActivosUsuario
	@correoUsuarioAsociado varchar(150)
 AS
	SET NOCOUNT ON;
	select activo.placa, cat.codigoCategoria, cat.nombreCategoria, cat.esRepuesto, estado.codigoEstado, estado.nombreEstado,
	activo.serie, activo.proveedor, activo.modelo, activo.marca, activo.fechaSalidaInventario, activo.fechaDesechado,
	activo.fechaExpiraGarantia, activo.correoUsuarioAsociado, activo.nombreUsuarioAsociado,
	activo.departamentoUsuarioAsociado, activo.jefaturaUsuarioAsociado from
	(select codigoCategoria, nombreCategoria, esRepuesto from Categoria where esRepuesto = 0) cat,
	(select codigoEstado, nombreEstado from EstadoEquipo where codigoEstado != 4 AND codigoEstado != 5) estado,
	(select placa, codigoCategoria, codigoEstado, serie, proveedor, modelo, marca, 
	fechaSalidaInventario, fechaDesechado, fechaExpiraGarantia, correoUsuarioAsociado, nombreUsuarioAsociado, 
	departamentoUsuarioAsociado, jefaturaUsuarioAsociado from ActivoFijo where codigoEstado != 4 AND codigoEstado != 5 AND
	correoUsuarioAsociado = @correoUsuarioAsociado) activo
	where activo.codigoCategoria = cat.codigoCategoria AND activo.codigoEstado = estado.codigoEstado;
 GO

 --select * from ActivoFijo;
 --exec PAobtenerActivosUsuario 'nubeblanca1997@outlook.com';
 --DROP PROCEDURE PAobtenerActivosUsuario;



 CREATE PROCEDURE PAasociarTiqueteActivo
	@placa varchar(150),
	@correoUsuarioCausante varchar(150),
	@nombreUsuarioCausante varchar(150),
	@codigoTiquete int, 
	@men int output	
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
	DECLARE 
	@fechaActual datetime,
	@aclaracion varchar(500),
	@nombreCategoria varchar(300),
	@descripcion varchar(400),
	@nombreUsuarioAsociado varchar(150),
	@correoUsuarioAsociado varchar(150),
	@error int,
	@responsableActual varchar(60)

	SET @men = 0;
	IF (select codigoEstado from ActivoFijo where placa = @placa) = 5  --Activo desechado
	BEGIN
		SET @men = 2;
		THROW  50001, 'El equipo fue desechado', 1;
	END;

	SET @error = ISNULL((select codigoTiquete from TiquetesActivos where codigoTiquete = @codigoTiquete AND placa = @placa), -1);
	IF @error != -1
    BEGIN
		SET @men = 3; 
        THROW  50001, 'El activo ya tiene asociado ese tiquete', 1;
    END;

	IF (select codigoEstado from Tiquete where codigoTiquete = @codigoTiquete) = 7  --Tiquete finalizado
	BEGIN
		SET @men = 4;
		THROW  50001, 'El tiquete fue finalizado', 1;
	END;

	SET @nombreCategoria = (select cat.nombreCategoria from 
	(select codigoCategoria, nombreCategoria from Categoria) cat,
	(select codigoCategoria from ActivoFijo where placa = @placa) act
	 where cat.codigoCategoria = act.codigoCategoria);

	SET @fechaActual = (select GETDATE());

	SET @descripcion = (select descripcion from Tiquete where codigoTiquete = @codigoTiquete);

	SET @nombreUsuarioAsociado = (select nombreUsuarioAsociado from ActivoFijo where placa = @placa);
	SET @correoUsuarioAsociado = (select correoUsuarioAsociado from ActivoFijo where placa = @placa);

	SET @responsableActual = 
	(select resp.codigoEmpleado from 
	(select codigoResponsable, codigoEmpleado from Responsable) resp,
	(select codigoResponsable from dbo.Tiquete where codigoTiquete = @codigoTiquete) tiq
	where resp.codigoResponsable = tiq.codigoResponsable);

	SET @aclaracion = 'El dispositivo ' + @nombreCategoria + '  con placa ' +  @placa + ' fue asociado al tiquete ' +  
	CAST(@codigoTiquete as varchar) + ' con descripcion: "' + @descripcion +
	'",  por ' + @nombreUsuarioCausante + ' el ' + CONVERT(VARCHAR, @fechaActual, 120);

	insert TiquetesActivos (codigoTiquete, placa, fechaAsociado) values (@codigoTiquete, @placa, @fechaActual); 

	insert into HistorialActivos (placa, codigoIndicador, fechaHora, correoUsuarioCausante, nombreUsuarioCausante,
	correoUsuarioAsociado, nombreUsuarioAsociado, aclaracionSistema) values 
	(@placa, 10, @fechaActual, @correoUsuarioCausante, @nombreUsuarioCausante, @correoUsuarioAsociado, 
	@nombreUsuarioAsociado, @aclaracion);

	insert into dbo.HistorialTiquete(codigoTiquete, codigoIndicador, codigoResponsable, fechaHora, 
	correoUsuarioCausante, nombreUsuarioCausante,aclaracionSistema)
	values (@codigoTiquete, 15, @responsableActual, @fechaActual, @correoUsuarioCausante, 
	@nombreUsuarioCausante, @aclaracion);

	COMMIT TRANSACTION;

END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @men != 2 AND @error = -1 AND @men != 4
	BEGIN
		SET @men = 1; 
	END;
END CATCH;
GO


--DECLARE @mens int
--exec PAasociarTiqueteActivo '567', 'nubeblanca1997@outlook.com', 'Tatiana Corrales', 10,  @men = @mens output;
--PRINT @mens;

--select * from ActivoFijo;
--select * from Tiquete;
--select * from TiquetesActivos;
--select * from HistorialTiquete;
--select * from HistorialActivos;
--DROP PROCEDURE PAasociarTiqueteActivo;


CREATE PROCEDURE PAdesasociarTiqueteActivo
	@placa varchar(150),
	@correoUsuarioCausante varchar(150),
	@nombreUsuarioCausante varchar(150),
	@codigoTiquete int, 
	@men int output	
AS
SET XACT_ABORT ON;
SET NOCOUNT ON;
BEGIN TRY
    BEGIN TRANSACTION;
	DECLARE 
	@fechaActual datetime,
	@aclaracion varchar(500),
	@nombreCategoria varchar(300),
	@descripcion varchar(400),
	@nombreUsuarioAsociado varchar(150),
	@correoUsuarioAsociado varchar(150),
	@error int,
	@responsableActual varchar(60)

	SET @men = 0;
	SET @error = ISNULL((select codigoTiquete from TiquetesActivos where codigoTiquete = @codigoTiquete AND placa = @placa), -1);
	IF @error = -1
    BEGIN
		SET @men = 3; 
        THROW  50001, 'El activo no esta asociado al tiquete', 1;
    END;

	IF (select codigoEstado from Tiquete where codigoTiquete = @codigoTiquete) = 7  --Tiquete finalizado
	BEGIN
		SET @men = 4;
		THROW  50001, 'El tiquete fue finalizado', 1;
	END;

	SET @nombreCategoria = (select cat.nombreCategoria from 
	(select codigoCategoria, nombreCategoria from Categoria) cat,
	(select codigoCategoria from ActivoFijo where placa = @placa) act
	 where cat.codigoCategoria = act.codigoCategoria);

	SET @fechaActual = (select GETDATE());

	SET @descripcion = (select descripcion from Tiquete where codigoTiquete = @codigoTiquete);

	SET @nombreUsuarioAsociado = (select nombreUsuarioAsociado from ActivoFijo where placa = @placa);
	SET @correoUsuarioAsociado = (select correoUsuarioAsociado from ActivoFijo where placa = @placa);

	SET @responsableActual = 
	(select resp.codigoEmpleado from 
	(select codigoResponsable, codigoEmpleado from Responsable) resp,
	(select codigoResponsable from dbo.Tiquete where codigoTiquete = @codigoTiquete) tiq
	where resp.codigoResponsable = tiq.codigoResponsable);

	SET @aclaracion = 'El dispositivo ' + @nombreCategoria + '  con placa ' +  @placa + ' fue desasociado al tiquete ' +  
	CAST(@codigoTiquete as varchar) + ' con descripcion: "' + @descripcion +
	'",  por ' + @nombreUsuarioCausante + ' el ' + CONVERT(VARCHAR, @fechaActual, 120);

	Delete TiquetesActivos where codigoTiquete = @codigoTiquete AND placa = @placa;

	insert into HistorialActivos (placa, codigoIndicador, fechaHora, correoUsuarioCausante, nombreUsuarioCausante,
	correoUsuarioAsociado, nombreUsuarioAsociado, aclaracionSistema) values 
	(@placa, 11, @fechaActual, @correoUsuarioCausante, @nombreUsuarioCausante, @correoUsuarioAsociado, 
	@nombreUsuarioAsociado, @aclaracion);

	insert into dbo.HistorialTiquete(codigoTiquete, codigoIndicador, codigoResponsable, fechaHora, 
	correoUsuarioCausante, nombreUsuarioCausante,aclaracionSistema)
	values (@codigoTiquete, 16, @responsableActual, @fechaActual, @correoUsuarioCausante, 
	@nombreUsuarioCausante, @aclaracion);

	COMMIT TRANSACTION;

END TRY
BEGIN CATCH

    IF (XACT_STATE()) = -1
    BEGIN
        ROLLBACK TRANSACTION;
    END;
	IF @error != -1 AND @men != 4
	BEGIN
		SET @men = 1; 
	END;
END CATCH;
GO


--DECLARE @mens int
--exec PAdesasociarTiqueteActivo '567', 'nubeblanca1997@outlook.com', 'Tatiana Corrales', 10,  @men = @mens output;
--PRINT @mens;

--select * from ActivoFijo;
--select * from Tiquete;
--select * from TiquetesActivos;
--select * from HistorialTiquete;
--select * from HistorialActivos;
--DROP PROCEDURE PAdesasociarTiqueteActivo;


--Obtiene todos los activos relacionados a un tiquete 
 CREATE PROCEDURE PAobtenerActivosAsociadosTiquete
	@codigoTiquete int
 AS
	SET NOCOUNT ON;
	select activo.placa, cat.codigoCategoria, cat.nombreCategoria, cat.esRepuesto, estado.codigoEstado, estado.nombreEstado,
	activo.serie, activo.proveedor, activo.modelo, activo.marca, activo.fechaSalidaInventario, activo.fechaDesechado,
	activo.fechaExpiraGarantia, activo.correoUsuarioAsociado, activo.nombreUsuarioAsociado,
	activo.departamentoUsuarioAsociado, activo.jefaturaUsuarioAsociado from
	(select codigoCategoria, nombreCategoria, esRepuesto from Categoria where esRepuesto = 0) cat,
	(select codigoEstado, nombreEstado from EstadoEquipo) estado,
	(select placa from TiquetesActivos where codigoTiquete = @codigoTiquete) aso,
	(select placa, codigoCategoria, codigoEstado, serie, proveedor, modelo, marca, 
	fechaSalidaInventario, fechaDesechado, fechaExpiraGarantia, correoUsuarioAsociado, nombreUsuarioAsociado, 
	departamentoUsuarioAsociado, jefaturaUsuarioAsociado from ActivoFijo) activo
	where activo.codigoCategoria = cat.codigoCategoria AND activo.codigoEstado = estado.codigoEstado AND activo.placa = aso.placa;
 GO

 --select * from ActivoFijo;
 --exec PAobtenerActivosAsociadosTiquete 10;
 --DROP PROCEDURE PAobtenerActivosAsociadosTiquete;


 --Obtiene un activo filtrado por placa
 CREATE PROCEDURE PAobtenerActivosFiltradosPlaca
	@placa varchar(150)
 AS
	SET NOCOUNT ON;
	select activo.placa, cat.codigoCategoria, cat.nombreCategoria, cat.esRepuesto, estado.codigoEstado, estado.nombreEstado,
	activo.serie, activo.proveedor, activo.modelo, activo.marca, activo.fechaSalidaInventario, activo.fechaDesechado,
	activo.fechaExpiraGarantia, activo.correoUsuarioAsociado, activo.nombreUsuarioAsociado,
	activo.departamentoUsuarioAsociado, activo.jefaturaUsuarioAsociado from
	(select codigoCategoria, nombreCategoria, esRepuesto from Categoria where esRepuesto = 0) cat,
	(select codigoEstado, nombreEstado from EstadoEquipo) estado,
	(select placa, codigoCategoria, codigoEstado, serie, proveedor, modelo, marca, 
	fechaSalidaInventario, fechaDesechado, fechaExpiraGarantia, correoUsuarioAsociado, nombreUsuarioAsociado, 
	departamentoUsuarioAsociado, jefaturaUsuarioAsociado from ActivoFijo where placa = @placa) activo
	where activo.codigoCategoria = cat.codigoCategoria AND activo.codigoEstado = estado.codigoEstado;
 GO

 --select * from ActivoFijo;
 --exec PAobtenerActivosFiltradosPlaca 567;
 --DROP PROCEDURE PAobtenerActivosFiltradosPlaca;

 --Obtiene un articulo del inventario filtrado por codigoArticulo y codigoBodega
 CREATE PROCEDURE PAobtenerArticuloFiltradoCodigoBodega
	@codigo varchar(150),
	@codigoBodega int
 AS
	SET NOCOUNT ON;
	select inve.codigoArticulo, inve.descripcion, inve.costo, cat.codigoCategoria, cat.nombreCategoria, cat.esRepuesto, inve.estado, inve.cantidad,
	inve.codigoBodega, bode.nombreBodega from
	(select codigoCategoria, nombreCategoria, esRepuesto from Categoria where esRepuesto = 0) cat,
	(select codigoBodega, nombreBodega from Bodega where codigoBodega = @codigoBodega) bode,
	(select codigoArticulo, descripcion, costo, codigoCategoria, estado, cantidad, codigoBodega from Inventario 
	where codigoArticulo = @codigo AND codigoBodega = @codigoBodega) inve
	where inve.codigoCategoria = cat.codigoCategoria AND inve.codigoBodega = bode.codigoBodega;
 GO

 --select * from Inventario;
 --exec PAobtenerArticuloFiltradoCodigoBodega '11', 2;
 --DROP PROCEDURE PAobtenerArticuloFiltradoCodigoBodega;

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

 
 insert into Bodega (codigoBodega, nombreBodega) values (1, 'Bodega oficinas centrales');
 insert into Bodega (codigoBodega, nombreBodega) values (2, 'Bodega centro de distribución');
 insert into Bodega (codigoBodega, nombreBodega) values (3, 'Bodega de Perú');

 --Inventario
 insert into Inventario(codigoArticulo, descripcion, costo, codigoCategoria, estado, cantidad, codigoBodega) values ('10', 'Bateria Dell 72X', '50', 4, 'Activo', 5, 1);
 insert into Inventario(codigoArticulo, descripcion, costo, codigoCategoria, estado, cantidad, codigoBodega) values ('11', 'Laptop Dell Inspiron', '60', 1, 'Activo', 2, 2);



 --Activos fijos 
  insert into ActivoFijo (placa, codigoCategoria, codigoEstado, serie, proveedor, modelo, marca, 
 fechaSalidaInventario, fechaExpiraGarantia, correoUsuarioAsociado, nombreUsuarioAsociado, departamentoUsuarioAsociado, jefaturaUsuarioAsociado) 
 values ('456', 1, 1, 'T67Y8', 'DELL', 'Inspiron', 'DELL', 
 '20180325','20180430', 'nubeblanca1997@outlook.com', 'Cristina Cascante', 'Tecnología de la información', 'Cristina Cascante');
  insert into ActivoFijo (placa, codigoCategoria, codigoEstado, serie, proveedor, modelo, marca, 
 fechaSalidaInventario, fechaExpiraGarantia, correoUsuarioAsociado, nombreUsuarioAsociado, departamentoUsuarioAsociado, jefaturaUsuarioAsociado) 
 values ('567', 1, 1, 'T6751', 'Soluciones Electrónicas', 'Ideapad', 'Lenovo', 
 '20180329','20180730', 'nubeblanca1997@outlook.com', 'Cristina Cascante', 'Tecnología de la información', 'Cristina Cascante');
  insert into ActivoFijo (placa, codigoCategoria, codigoEstado, serie, proveedor, modelo, marca, 
 fechaSalidaInventario, fechaExpiraGarantia, correoUsuarioAsociado, nombreUsuarioAsociado, departamentoUsuarioAsociado, jefaturaUsuarioAsociado) 
 values ('678', 1, 1, '8472F', 'HP', 'Spectre', 'HP',
 '20180326','20180830', 'nubeblanca1997@outlook.com', 'Cristina Cascante', 'Tecnología de la información', 'Cristina Cascante');

 
 
 insert into Licencia (fechaDeVencimiento, claveDeProducto, proveedor, fechaAsociado, descripcion, placa)
 values ('20180830', '2356-7763-U746-HGFT', 'Microsoft', '20180324', 'Excel', '456');
 insert into Licencia (fechaDeVencimiento, claveDeProducto, proveedor, fechaAsociado, descripcion, placa)
 values ('20180830', '8304-7763-U74G-HGFT', 'Microsoft', '20180324', 'Word document', '567');
 insert into Licencia (fechaDeVencimiento, claveDeProducto, proveedor, fechaAsociado, descripcion, placa)
 values ('20180830', '2830-7253-UR46-HBFT', 'Microsoft', '20180324', 'Power Point', '678');

 
 insert into Repuesto (descripcion, fechaAsociado, placa) values ('Mouse', '20180324', '456');
 insert into Repuesto (descripcion, fechaAsociado, placa) values ('Teclado', '20180324', '456');
 insert into Repuesto (descripcion, fechaAsociado, placa) values ('Parlante', '20180324', '567');
 insert into Repuesto (descripcion, fechaAsociado, placa) values ('Adaptador HDMI', '20180324', '678');
 

 insert into IndicadoresActivos (codigoIndicador, descripcionIndicador) values (1, 'Asocia licencia');
 insert into IndicadoresActivos (codigoIndicador, descripcionIndicador) values (2, 'Asocia repuesto');
 insert into IndicadoresActivos (codigoIndicador, descripcionIndicador) values (3, 'Activo creado');
 insert into IndicadoresActivos (codigoIndicador, descripcionIndicador) values (4, 'Adjunta documento');
 insert into IndicadoresActivos (codigoIndicador, descripcionIndicador) values (5, 'Actualiza estado');
 insert into IndicadoresActivos (codigoIndicador, descripcionIndicador) values (6, 'Elimina licencia');
 insert into IndicadoresActivos (codigoIndicador, descripcionIndicador) values (7, 'Elimina repuesto');
 insert into IndicadoresActivos (codigoIndicador, descripcionIndicador) values (8, 'Asocia usuario');
 insert into IndicadoresActivos (codigoIndicador, descripcionIndicador) values (9, 'Elimina usuario');
 insert into IndicadoresActivos (codigoIndicador, descripcionIndicador) values (10, 'Asocia tiquete');
 insert into IndicadoresActivos (codigoIndicador, descripcionIndicador) values (11, 'Desasocia tiquete');

 


 
 --DROPS
 DROP TABLE TiquetesActivos
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
 DROP PROCEDURE PAobtenerEstadosEquipo;
 DROP PROCEDURE PAactualizarEstadoEquipo;
 DROP PROCEDURE PAobtenerDetalleArticuloInventario;
 DROP PROCEDURE PAobtenerHistorialActivosFijos;
 DROP PROCEDURE PAeliminarLicencia;
 DROP PROCEDURE PAeliminarRepuesto;
 DROP PROCEDURE PAasociarUsuarioActivo;
 DROP PROCEDURE PAeliminarUsuarioActivo;
 DROP PROCEDURE PAbusquedaAvanzadaInventario;
 DROP PROCEDURE PAbusquedaAvanzadaActivos;
 DROP PROCEDURE PAobtenerActivosUsuario;
 DROP PROCEDURE PAasociarTiqueteActivo;
 DROP PROCEDURE PAdesasociarTiqueteActivo;
 DROP PROCEDURE PAobtenerActivosAsociadosTiquete;
 DROP PROCEDURE PAobtenerActivosFiltradosPlaca;
 DROP PROCEDURE PAobtenerArticuloFiltradoCodigoBodega;

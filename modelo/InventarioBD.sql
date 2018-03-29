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
  CONSTRAINT PKCategoria PRIMARY KEY(codigoCategoria),
  CONSTRAINT AK_Categoria UNIQUE (nombreCategoria)
 )
 GO
 

 CREATE TABLE Inventario(
 codigoArticulo varchar(150) NOT NULL,
 descripcion varchar(150) NOT NULL, 
 costo money NOT NULL,
 codigoCategoria int NOT NULL,
 estado varchar(150) NOT NULL,
 cantidad int NOT NULL,
 CONSTRAINT PKInventario PRIMARY KEY(codigoArticulo),
 CONSTRAINT AK_Inventario UNIQUE (descripcion),
 CONSTRAINT FKInventarioCategoria FOREIGN KEY (codigoCategoria) REFERENCES Categoria(codigoCategoria)
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
 bodega varchar(100) NOT NULL,    --Pedirlo cuando se realiza cada accion
 comentarioUsuario ntext NOT NULL,
 correoUsuarioCausante varchar(150) NOT NULL,
 nombreUsuarioCausante varchar(150) NOT NULL,
 CONSTRAINT PKDetalle PRIMARY KEY(codigoDetalle),
 CONSTRAINT FKDetalleInventario FOREIGN KEY (codigoArticulo) REFERENCES Inventario(codigoArticulo)
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
	select inve.codigoArticulo, inve.descripcion, inve.costo, cat.codigoCategoria, cat.nombreCategoria, inve.estado, inve.cantidad from
	(select codigoCategoria, nombreCategoria from Categoria) cat,
	(select codigoArticulo, descripcion, costo, codigoCategoria, estado, cantidad from Inventario) inve
	where inve.codigoCategoria = cat.codigoCategoria;
 GO

 --exec PAobtenerInventario;		

 CREATE PROCEDURE PAobtenerActivosFijos
 AS
	SET NOCOUNT ON;
	select activo.placa, cat.codigoCategoria, cat.nombreCategoria, estado.codigoEstado, estado.nombreEstado,
	activo.serie, activo.proveedor, activo.modelo, activo.marca, activo.fechaSalidaInventario, activo.fechaDesechado,
	activo.fechaExpiraGarantia, activo.correoUsuarioAsociado, activo.nombreUsuarioAsociado,
	activo.departamentoUsuarioAsociado, activo.jefaturaUsuarioAsociado from
	(select codigoCategoria, nombreCategoria from Categoria) cat,
	(select codigoEstado, nombreEstado from EstadoEquipo) estado,
	(select placa, codigoCategoria, codigoEstado, serie, proveedor, modelo, marca, 
	fechaSalidaInventario, fechaDesechado, fechaExpiraGarantia, correoUsuarioAsociado, nombreUsuarioAsociado, 
	departamentoUsuarioAsociado, jefaturaUsuarioAsociado from ActivoFijo) activo
	where activo.codigoCategoria = cat.codigoCategoria AND activo.codigoEstado = estado.codigoEstado;
 GO

 --exec PAobtenerActivosFijos;

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
	select codigoCategoria, nombreCategoria from Categoria;
 GO

 --exec PAobtenerCategorias;


 CREATE PROCEDURE PAagregarArticuloInventario
	@codigoArticulo varchar(150),
	@descripcion varchar(150), 
	@costo money,
	@codigoCategoria int,
	@estado varchar(150),
	@cantidad int,
	@bodega varchar(100),
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
	insert into Inventario (codigoArticulo, descripcion, costo, codigoCategoria, estado, cantidad) values
	(@codigoArticulo, @descripcion, @costo, @codigoCategoria, @estado, @cantidad);

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
--exec PAagregarArticuloInventario '987','Celular Huawei Gplay mini', '30', 2, 'Activo', 2, 'Bodega A7', 'Acaban de llegar
--los dos teléfono nuevos', 'nubeblanca1997@outlook.com', 'Tatiana Corrales', @men = @mens output;
--PRINT @mens;

--select * from Inventario;
--select * from Detalle;

 CREATE PROCEDURE PAaumentarCantidadInventario
	@codigoArticulo varchar(150),
	@cantidadEfecto int,
	@bodega varchar(100),
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
	@copiaCantidad int,
	@copiaCosto money,
	@copiaEstado varchar(150)

	SET @fechaActual = (select GETDATE());
	SET @copiaCantidad = (select cantidad from Inventario where codigoArticulo = @codigoArticulo);
	SET @copiaCosto = (select costo from Inventario where codigoArticulo = @codigoArticulo);
	set @copiaEstado = (select estado from Inventario where codigoArticulo = @codigoArticulo);

	Update Inventario SET cantidad = (@copiaCantidad + @cantidadEfecto) where codigoArticulo = @codigoArticulo;

	insert into Detalle (codigoArticulo, copiaCantidadInventario, cantidadEfecto, costo, fecha, estado, efecto, bodega, 
	comentarioUsuario, correoUsuarioCausante, nombreUsuarioCausante) values 
	(@codigoArticulo, (@copiaCantidad + @cantidadEfecto), @cantidadEfecto, @copiaCosto, @fechaActual, @copiaEstado, 'Entrada', @bodega,
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


--DECLARE @mens int
--exec PAaumentarCantidadInventario '987', 5, 'Bodega A7', 'Son muchos teléfonos', 'nubeblanca1997@outlook.com', 'Tatiana Corrales', @men = @mens output;
--PRINT @mens;

--select * from Inventario;
--select * from Detalle;
--DROP PROCEDURE PAaumentarCantidadInventario;

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

 insert into Categoria(codigoCategoria, nombreCategoria) values (1, 'Portatil');
 insert into Categoria(codigoCategoria, nombreCategoria) values (2, 'Teléfono móvil');
 insert into Categoria(codigoCategoria, nombreCategoria) values (3, 'Impresora');
 insert into Categoria(codigoCategoria, nombreCategoria) values (4, 'Batería');
 insert into Categoria(codigoCategoria, nombreCategoria) values (5, 'Cargador');
 insert into Categoria(codigoCategoria, nombreCategoria) values (6, 'Pantalla');
 insert into Categoria(codigoCategoria, nombreCategoria) values (7, 'Teclado');
 insert into Categoria(codigoCategoria, nombreCategoria) values (8, 'Chip');
 insert into Categoria(codigoCategoria, nombreCategoria) values (9, 'Docking station');
 insert into Categoria(codigoCategoria, nombreCategoria) values (10, 'Mouse');
 insert into Categoria(codigoCategoria, nombreCategoria) values (11, 'Cargador para móvil');
 insert into Categoria(codigoCategoria, nombreCategoria) values (12, 'Memoria');
 insert into Categoria(codigoCategoria, nombreCategoria) values (13, 'Otros');


 --Inventario
 insert into Inventario(codigoArticulo, descripcion, costo, codigoCategoria, estado, cantidad) values ('10', 'Bateria Dell 72X', '50', 4, 'Activo', 5);
 insert into Inventario(codigoArticulo, descripcion, costo, codigoCategoria, estado, cantidad) values ('11', 'Laptop Dell Inspiron', '60', 1, 'Activo', 2);



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
 

 DROP PROCEDURE PAobtenerInventario;
 DROP PROCEDURE PAobtenerActivosFijos;
 DROP PROCEDURE PAobtenerLicencias;
 DROP PROCEDURE PAobtenerRepuestos;
 DROP PROCEDURE PAobtenerCategorias;
 DROP PROCEDURE PAagregarArticuloInventario;
 DROP PROCEDURE PAaumentarCantidadInventario;

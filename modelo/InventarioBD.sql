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




 CREATE PROCEDURE PAobtenerEquiposPasivos
 AS
	SET NOCOUNT ON;
	select equipo.placa, tipo.codigoTipo, tipo.nombreTipo, equipo.esNuevo, estado.codigoEstado, estado.nombreEstado,
	equipo.serie, equipo.proveedor, equipo.modelo, equipo.marca, equipo.fechaIngresoSistema, equipo.fechaDesechado, 
	equipo.fechaExpiraGarantia, equipo.precio from
	(select codigoTipo, nombreTipo from TipoDispositivo) tipo,
	(select codigoEstado, nombreEstado from EstadoEquipo) estado,
	(select placa, codigoTipo, esNuevo, codigoEstado, serie, proveedor, modelo, marca, fechaIngresoSistema, 
	fechaDesechado, fechaExpiraGarantia, precio from Equipo where tipoDeBien = 1) equipo
	where equipo.codigoTipo = tipo.codigoTipo AND equipo.codigoEstado = estado.codigoEstado;
 GO

 --exec PAobtenerEquiposPasivos;

  CREATE PROCEDURE PAobtenerEquiposActivos
 AS
	SET NOCOUNT ON;
	select equipo.placa, tipo.codigoTipo, tipo.nombreTipo, equipo.esNuevo, estado.codigoEstado, estado.nombreEstado,
	equipo.serie, equipo.proveedor, equipo.modelo, equipo.marca, equipo.fechaIngresoSistema, equipo.fechaSalidaInventario,
	equipo.fechaExpiraGarantia, equipo.precio, equipo.correoUsuarioAsociado, equipo.nombreUsuarioAsociado,
	equipo.departamentoUsuarioAsociado, equipo.jefaturaUsuarioAsociado from
	(select codigoTipo, nombreTipo from TipoDispositivo) tipo,
	(select codigoEstado, nombreEstado from EstadoEquipo) estado,
	(select placa, codigoTipo, esNuevo, codigoEstado,tipoDeBien, serie, proveedor, modelo, marca, fechaIngresoSistema, 
	fechaSalidaInventario, fechaExpiraGarantia, precio,correoUsuarioAsociado, nombreUsuarioAsociado,
	departamentoUsuarioAsociado, jefaturaUsuarioAsociado from Equipo where tipoDeBien = 0) equipo
	where equipo.codigoTipo = tipo.codigoTipo AND equipo.codigoEstado = estado.codigoEstado;
 GO

 --exec PAobtenerEquiposActivos;

 CREATE PROCEDURE PAobtenerLicencias
 AS

	SET NOCOUNT ON;
	select fechaDeVencimiento, cantidadTotal, cantidadEnUso, claveDeProducto, proveedor, fechaIngresoSistema, descripcion from Licencia;
 GO

 --exec PAobtenerLicencias;

 CREATE PROCEDURE PAobtenerRepuestos
 AS

	SET NOCOUNT ON;
	select codigoRepuesto, cantidadTotal, cantidadEnUso, descripcion from Repuesto;
 GO

 --exec PAobtenerRepuestos;

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
 

 DROP PROCEDURE PAobtenerEquiposPasivos;
 DROP PROCEDURE PAobtenerEquiposActivos;
 DROP PROCEDURE PAobtenerLicencias;
 DROP PROCEDURE PAobtenerRepuestos;

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

 CREATE TABLE TipoDispositivo(
 codigoTipo int NOT NULL,
 nombreTipo varchar(100) NOT NULL,
  CONSTRAINT PKTipoDispositivo PRIMARY KEY(codigoTipo),
  CONSTRAINT AK_TipoDispositivo UNIQUE (nombreTipo)
 )
 GO

CREATE TABLE Equipo(
 placa varchar(150) NOT NULL,
 codigoTipo int NOT NULL,
 esNuevo bit NOT NULL, 
 codigoEstado int NOT NULL,
 tipoDeBien bit NOT NULL,   --1 -> pasivo  0 -> activo
 serie varchar(150) NOT NULL,
 proveedor varchar(300) NOT NULL,
 modelo varchar(150) NOT NULL,
 marca varchar(150) NOT NULL,
 fechaIngresoSistema datetime NOT NULL,
 fechaSalidaInventario datetime,
 fechaDesechado datetime,
 fechaExpiraGarantia datetime,
 precio float NOT NULL,
 correoUsuarioAsociado varchar(300),
 nombreUsuarioAsociado varchar(100),
 departamentoUsuarioAsociado varchar(150),
 jefaturaUsuarioAsociado varchar(100), 
 CONSTRAINT PKEquipo PRIMARY KEY(placa),
 CONSTRAINT FKEquipoEstado FOREIGN KEY (codigoEstado) REFERENCES EstadoEquipo(codigoEstado),
 CONSTRAINT FKEquipoTipo FOREIGN KEY (codigoTipo) REFERENCES TipoDispositivo(codigoTipo)
 )
 GO


 CREATE TABLE Licencia(
 fechaDeVencimiento datetime NOT NULL,
 cantidadTotal int NOT NULL,
 cantidadEnUso int NOT NULL,
 claveDeProducto varchar(150) NOT NULL,
 proveedor varchar(150) NOT NULL,
 fechaIngresoSistema datetime,
 descripcion varchar(500) NOT NULL
  CONSTRAINT PKEstadoLicencia PRIMARY KEY(claveDeProducto)
 )
 GO

CREATE TABLE EquipoLicencia(
 placa varchar(150) NOT NULL,
 claveDeProducto varchar(150) NOT NULL,
 CONSTRAINT PKEquipoLicencia PRIMARY KEY(placa,claveDeProducto),
 CONSTRAINT FKEquipoLicenciaLicencia FOREIGN KEY (claveDeProducto) REFERENCES Licencia(claveDeProducto),
 CONSTRAINT FKEquipoLicenciaEquipo FOREIGN KEY (placa) REFERENCES Equipo(placa)
 )
 GO

 CREATE TABLE Repuesto(
 codigoRepuesto int NOT NULL,
 cantidadTotal int NOT NULL,
 cantidadEnUso int NOT NULL,
 descripcion varchar(500) NOT NULL
  CONSTRAINT PKRepuesto PRIMARY KEY(codigoRepuesto)
 )
 GO

 
CREATE TABLE EquipoRepuesto(
 placa varchar(150) NOT NULL,
 codigoRepuesto int NOT NULL,
 CONSTRAINT PKEquipoRepuesto PRIMARY KEY(placa,codigoRepuesto),
 CONSTRAINT FKEquipoRepuestoRepuesto FOREIGN KEY (codigoRepuesto) REFERENCES Repuesto(codigoRepuesto),
 CONSTRAINT FKEquipoRepuestoEquipo FOREIGN KEY (placa) REFERENCES Equipo(placa)
 )
 GO
 

 CREATE TABLE IndicadoresEquipos(
 codigoIndicador int NOT NULL,
 descripcionIndicador varchar(100) NOT NULL,
 CONSTRAINT PKIndicadoresEquipos PRIMARY KEY(codigoIndicador),
 CONSTRAINT AK_IndicadoresEquipos UNIQUE (descripcionIndicador)
 )
 GO


 CREATE TABLE HistorialEquipo(
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
 CONSTRAINT FKHistorialEquipoEquipo FOREIGN KEY (placa) REFERENCES Equipo(placa),
 CONSTRAINT FKHistorialEquipoIndicador  FOREIGN KEY (codigoIndicador) REFERENCES IndicadoresEquipos(codigoIndicador)
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

 exec PAobtenerRepuestos;

 --INSERTS
 insert into estadoEquipo (codigoEstado, nombreEstado) values (1, 'En bodega');
 insert into estadoEquipo (codigoEstado, nombreEstado) values (2, 'En uso');
 insert into estadoEquipo (codigoEstado, nombreEstado) values (3, 'En reparación');
 insert into estadoEquipo (codigoEstado, nombreEstado) values (4, 'En mantenimiento');
 insert into estadoEquipo (codigoEstado, nombreEstado) values (5, 'Espera ser desechado');
 insert into estadoEquipo (codigoEstado, nombreEstado) values (6, 'Desechado');

 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (1, 2);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (1, 3);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (1, 4);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (1, 5);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (2, 1);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (2, 3);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (2, 4);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (2, 5);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (3, 1);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (3, 2);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (3, 5);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (4, 1);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (4, 2);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (4, 5);
 insert into estadoEquipoPermitido(estadoEquipoActual, estadoEquipoSiguiente) values (5, 6);

 insert into TipoDispositivo(codigoTipo, nombreTipo) values (1, 'Portatil');
 insert into TipoDispositivo(codigoTipo, nombreTipo) values (2, 'Teléfono móvil');
 insert into TipoDispositivo(codigoTipo, nombreTipo) values (3, 'Impresora');

 --Pasivos
 insert into Equipo (placa, codigoTipo, esNuevo, codigoEstado, tipoDeBien, serie, proveedor, modelo, marca, fechaIngresoSistema, 
 fechaExpiraGarantia, precio) values ('123', 1, 1, 1, 1, 'A164B', 'DELL', 'Inspiron', 'DELL', '2018/03/24', '2018/04/30', 1005);
 insert into Equipo (placa, codigoTipo, esNuevo, codigoEstado,tipoDeBien, serie, proveedor, modelo, marca, fechaIngresoSistema, 
 fechaExpiraGarantia, precio) values ('234', 2, 1, 1, 1, 'A164C', 'SAMSUNG', 'Galaxy', 'SAMSUNG', '2018/03/24', '2018/05/30', 1005);
 insert into Equipo (placa, codigoTipo, esNuevo, codigoEstado,tipoDeBien, serie, proveedor, modelo, marca, fechaIngresoSistema, 
 fechaExpiraGarantia, precio) values ('345', 1, 0, 1, 1, 'A164R', 'Lenovo', 'Ideapad', 'Lenovo', '2018/03/24', '2018/06/24', 1005);

 --Activos
  insert into Equipo (placa, codigoTipo, esNuevo, codigoEstado,tipoDeBien, serie, proveedor, modelo, marca, fechaIngresoSistema, 
 fechaSalidaInventario, fechaExpiraGarantia, precio,correoUsuarioAsociado, nombreUsuarioAsociado,
 departamentoUsuarioAsociado, jefaturaUsuarioAsociado) values ('456', 1, 0, 2, 0, 'T67Y8', 'DELL', 'Inspiron', 'DELL', '2018/03/24', 
 '2018/03/25','2018/04/30', 1005, 'nubeblanca1997@outlook.com', 'Cristina Cascante', 'Tecnología de la información', 'Cristina Cascante');
  insert into Equipo (placa, codigoTipo, esNuevo, codigoEstado,tipoDeBien, serie, proveedor, modelo, marca, fechaIngresoSistema, 
 fechaSalidaInventario, fechaExpiraGarantia, precio,correoUsuarioAsociado, nombreUsuarioAsociado,
 departamentoUsuarioAsociado, jefaturaUsuarioAsociado) values ('567', 1, 0, 3, 0, 'T6751', 'Soluciones Electrónicas', 'Ideapad', 'Lenovo', '2018/03/24', 
 '2018/03/29','2018/07/30', 1005, 'nubeblanca1997@outlook.com', 'Cristina Cascante', 'Tecnología de la información', 'Cristina Cascante');
  insert into Equipo (placa, codigoTipo, esNuevo, codigoEstado,tipoDeBien, serie, proveedor, modelo, marca, fechaIngresoSistema, 
 fechaSalidaInventario, fechaExpiraGarantia, precio,correoUsuarioAsociado, nombreUsuarioAsociado,
 departamentoUsuarioAsociado, jefaturaUsuarioAsociado) values ('678', 1, 0, 2, 0, '8472F', 'HP', 'Spectre', 'HP', '2018/03/24', 
 '2018/03/26','2018/08/30', 1005, 'nubeblanca1997@outlook.com', 'Cristina Cascante', 'Tecnología de la información', 'Cristina Cascante');

 
 insert into Licencia (fechaDeVencimiento, cantidadTotal, cantidadEnUso, claveDeProducto, proveedor, fechaIngresoSistema, descripcion)
 values ('2018/08/30', 50, 45, '2356-7763-U746-HGFT', 'Microsoft', '2018/03/24', 'Excel');
 insert into Licencia (fechaDeVencimiento, cantidadTotal, cantidadEnUso, claveDeProducto, proveedor, fechaIngresoSistema, descripcion)
 values ('2018/08/30', 30, 8, '8304-7763-U74G-HGFT', 'Microsoft', '2018/03/24', 'Word document');
 insert into Licencia (fechaDeVencimiento, cantidadTotal, cantidadEnUso, claveDeProducto, proveedor, fechaIngresoSistema, descripcion)
 values ('2018/08/30', 15, 5, '2830-7253-UR46-HBFT', 'Microsoft', '2018/03/24', 'Power Point');


 insert into Repuesto (codigoRepuesto, cantidadTotal, cantidadEnUso, descripcion) values (1, 14, 5, 'Mouse');
 insert into Repuesto (codigoRepuesto, cantidadTotal, cantidadEnUso, descripcion) values (2, 5, 5, 'Teclado');
 insert into Repuesto (codigoRepuesto, cantidadTotal, cantidadEnUso, descripcion) values (3, 20, 4, 'Parlante');
 insert into Repuesto (codigoRepuesto, cantidadTotal, cantidadEnUso, descripcion) values (4, 3, 2, 'Adaptador HDMI');
 

 --DROPS
 DROP TABLE HistorialEquipo;
 DROP TABLE IndicadoresEquipos;
 DROP TABLE EquipoRepuesto;
 DROP TABLE Repuesto;
 DROP TABLE EquipoLicencia;
 DROP TABLE Licencia;
 DROP TABLE Equipo;
 DROP TABLE EstadoEquipoPermitido;
 DROP TABLE EstadoEquipo;

 DROP PROCEDURE PAobtenerEquiposPasivos;
 DROP PROCEDURE PAobtenerEquiposActivos;
 DROP PROCEDURE PAobtenerLicencias;
 DROP PROCEDURE PAobtenerRepuestos;


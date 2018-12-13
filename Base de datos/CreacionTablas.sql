drop table OFERTAS;
drop table FACTURA;
drop table DETALLEVENTA;
drop table DETALLECOMPRA;
drop table COMPRAS;
drop table PROVEEDOR;
drop table VENTAS;
drop table CATALOGO;
drop table CLIENTES;
drop table EMPLEADOS;

CREATE TABLE EMPLEADOS (
IdEmpleado NUMBER,
Dni VARCHAR(9) not null,
Nombre VARCHAR(50) not null,
Apellidos VARCHAR (50) not null,
Direccion VARCHAR(100),
Correo VARCHAR(50) not null,
Salario NUMBER not null,
FechaInicio DATE not null,
FechaFin DATE,
Edad NUMBER NOT NULL CHECK(EDAD>=16),
Telefono VARCHAR(9) not null,
Usuario VARCHAR(50) not null,
Pass VARCHAR(50),
  PRIMARY KEY(IdEmpleado),
  UNIQUE(Usuario),
  UNIQUE(Dni));
/

CREATE TABLE CLIENTES (
IdCliente NUMBER  ,
Dni VARCHAR(9),
Nombre VARCHAR(50),
Apellidos VARCHAR (50),
Correo VARCHAR(50),
Direccion VARCHAR(100),
Telefono VARCHAR(9),
Tipo VARCHAR(50),
Usuario VARCHAR(50) not NULL,
Pass VARCHAR(50)not NULL,
constraint tipoCliente check (Tipo IN('Universitario', 'NoUniversitario')),
PRIMARY KEY(IdCliente),
UNIQUE(Usuario)
);
/
CREATE TABLE CATALOGO(
IdCatalogo NUMBER,
Nombre VARCHAR(50) not null,
Descripcion VARCHAR (100) ,
Precio NUMBER (10,2 )not null,
IVA NUMBER (10,2 )not null,
Stock NUMBER ,
StockMinimo NUMBER ,
TipoProducto VARCHAR(50),
TipoCatalogo VARCHAR (50),

constraint cTipoProducto check (TipoProducto IN ('Papeleria','Electronica','Otros')),
constraint cTipoCatalogo check (TipoCatalogo IN ('Producto','Servicio')),
constraint ivaCatalogo check (IVA>0 AND IVA<1),
constraint cPrecio check (Precio>0),
PRIMARY KEY(IdCatalogo),
UNIQUE(Nombre)
);
/
CREATE TABLE VENTAS( 
IdVentas NUMBER , 
FechaVenta Date,
Total NUMBER (10,2), 
IdEmpleado NUMBER,
IdCliente NUMBER,
constraint TotalVentas check (Total>=0),
PRIMARY KEY (IdVentas),
FOREIGN KEY(IdEmpleado) REFERENCES EMPLEADOS ON DELETE SET NULL, 
FOREIGN KEY(IdCliente) REFERENCES CLIENTES ON DELETE SET NULL); 
/
CREATE TABLE PROVEEDOR (
IdProveedor NUMBER,
Cif VARCHAR(9) not null,
Empresa VARCHAR(50) NOT NULL ,
Direccion VARCHAR(50) not null,
PRIMARY KEY (IdProveedor),
UNIQUE (Cif));

/

CREATE TABLE COMPRAS( 
IdCompras NUMBER , 
FechaCompra Date,
Total NUMBER (10,2), 
IdProveedor NUMBER,
constraint TotalCompras check (Total>=0),
PRIMARY KEY (IdCompras),
FOREIGN KEY(IdProveedor) REFERENCES PROVEEDOR ON DELETE SET NULL ); 
/
CREATE TABLE DETALLECOMPRA(
IdDetalleCompra NUMBER,
Cantidad NUMBER NOT NULL,
PrecioCompra NUMBER NOT NULL,
IVA NUMBER(10,2) NOT NULL,
IdCompras NUMBER,
IdCatalogo NUMBER NOT NULL,
constraint cantidadesCompra check (cantidad>0 AND PrecioCompra >0),
constraint compruebaIVACompra check (IVA<1 AND IVA>0),
PRIMARY KEY (IdDetalleCompra),
FOREIGN KEY (IdCompras) REFERENCES COMPRAS ON DELETE CASCADE,
FOREIGN KEY (IdCatalogo) REFERENCES CATALOGO ON DELETE SET NULL
); 
/
CREATE TABLE DETALLEVENTA(
IdDetalleVenta NUMBER,
Cantidad NUMBER NOT NULL,
PrecioVenta NUMBER NOT NULL,
IVA NUMBER (10,2) NOT NULL,
IdVentas NUMBER,
IdCatalogo NUMBER,
constraint cantidadesVenta check (cantidad>0 AND PrecioVenta >0),
constraint compruebaIVAVenta check (IVA<1 AND IVA>0),
PRIMARY KEY (IdDetalleVenta),
FOREIGN KEY (IdVentas) REFERENCES VENTAS ON DELETE CASCADE,
FOREIGN KEY (IdCatalogo) REFERENCES CATALOGO ON DELETE SET NULL
); 
/
CREATE TABLE FACTURA(
IdFactura NUMBER,
FechaFactura DATE,
IdVenta NUMBER,
PRIMARY KEY( IdFactura),
FOREIGN KEY (IdVenta) REFERENCES VENTAS
);
 / 
CREATE TABLE OFERTAS(
IdOferta NUMBER,
FechaInicio DATE not null,
FechaFin DATE,
Descuento NUMBER(10,2) not null,
IdCatalogo NUMBER,
constraint fechasOferta check (FechaInicio <= FechaFin),
constraint descuentos check (Descuento >0 AND Descuento <1),
constraint checkFechasOferta check (Fechafin is not null AND FechaInicio<FechaFin),
PRIMARY KEY(IdOferta),
FOREIGN KEY(IdCatalogo) REFERENCES Catalogo
);

/

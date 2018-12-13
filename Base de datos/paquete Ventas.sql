create or replace 
PACKAGE PRUEBAS_VENTAS AS

PROCEDURE inicializar;
PROCEDURE insertar
(nombre_prueba VARCHAR2, w_FECHAVENTA DATE , w_IDEMPLEADO NUMBER, w_IDCLIENTE NUMBER, w_salida_esperada Boolean);
PROCEDURE Actualizar (nombre_prueba VARCHAR2,w_IDVENTA NUMBER, w_FECHAVENTA DATE , w_Total NUMBER ,w_IDEMPLEADO NUMBER, w_IDCLIENTE NUMBER, w_salida_esperada Boolean);
PROCEDURE eliminar (nombre_prueba VARCHAR2,w_IDVENTA NUMBER,  w_salida_esperada boolean);
end PRUEBAS_VENTAS;
/



CREATE OR REPLACE 
PACKAGE BODY PRUEBAS_VENTAS AS
  PROCEDURE INICIALIZAR AS
  BEGIN
  DELETE FROM VENTAS;
END INICIALIZAR;


PROCEDURE INSERTAR 
(nombre_prueba VARCHAR2, w_FECHAVENTA DATE , w_IDEMPLEADO NUMBER, w_IDCLIENTE NUMBER, w_salida_esperada Boolean)AS
SALIDA BOOLEAN := TRUE;
VENTA VENTAS%ROWTYPE;
w_IDVENTA NUMBER;
BEGIN
INSERTAR_VENTAS(w_FECHAVENTA,w_IDEMPLEADO,w_IDCLIENTE);
--INSERT INTO VENTAS VALUES (sec_ventas.NEXTVAL,w_FECHAVENTA,0, w_IDEMPLEADO, w_IDCLIENTE);
w_IDVENTA := SEC_VENTAS.CURRVAL;
SELECT * INTO VENTA FROM VENTAS WHERE (IDVENTAS=w_IDVENTA);
IF(VENTA.FECHAVENTA <> w_FECHAVENTA OR VENTA.IDEMPLEADO<>w_IDEMPLEADO OR VENTA.IDCLIENTE<>w_IDCLIENTE) THEN
  SALIDA :=FALSE;

END IF;
COMMIT WORK;

DBMS_OUTPUT.PUT_LINE(NOMBRE_PRUEBA || ':' || ASSERT_EQUALS(SALIDA,w_salida_esperada));

EXCEPTION 
WHEN OTHERS THEN
DBMS_OUTPUT.PUT_LINE(NOMBRE_PRUEBA || ':' || ASSERT_EQUALS (FALSE,w_salida_esperada));
ROLLBACK;
end INSERTAR;


PROCEDURE actualizar (nombre_prueba VARCHAR2,w_IDVENTA NUMBER, w_FECHAVENTA DATE , 
w_Total NUMBER ,w_IDEMPLEADO NUMBER, w_IDCLIENTE NUMBER, w_salida_esperada Boolean) AS
salida Boolean := TRUE;
Venta VENTAS%ROWTYPE;
BEGIN
UPDATE VENTAS SET FECHAVENTA=w_FECHAVENTA, TOTAL=w_TOTAL, IDEMPLEADO=w_IDEMPLEADO, IDCLIENTe=w_IDCLIENTE WHERE (IDVENTAS=w_IDVENTA);
SELECT * INTO VENTA FROM VENTAS WHERE (IDVENTAS=W_IDVENTA);

IF(VENTA.FECHAVENTA <> w_FECHAVENTA OR VENTA.TOTAL<>w_TOTAL OR VENTA.IDEMPLEADO<>w_IDEMPLEADO OR VENTA.IDCLIENTE<>w_IDCLIENTE) THEN
  SALIDA :=FALSE;

END IF;
COMMIT WORK;

DBMS_OUTPUT.PUT_LINE(NOMBRE_PRUEBA || ':' || ASSERT_EQUALS(SALIDA,w_salida_esperada));

EXCEPTION 
WHEN OTHERS THEN
DBMS_OUTPUT.PUT_LINE(NOMBRE_PRUEBA || ':' || ASSERT_EQUALS (FALSE,w_salida_esperada));
ROLLBACK;

END actualizar;


PROCEDURE eliminar (nombre_prueba VARCHAR2,w_IDVENTA NUMBER,  w_salida_esperada boolean) AS
SALIDA BOOLEAN := TRUE;
n_ventas INTEGER;
BEGIN
ELIMINAR_VENTAS(w_IDVENTA);
--DELETE FROM VENTAS WHERE (IDVENTAS=w_IDVENTA);
SELECT COUNT (*) INTO n_ventas FROM VENTAS WHERE (IDVENTAS=w_IDVENTA);
IF(n_ventas <> 0) THEN
SALIDA :=FALSE;
END IF;
DBMS_OUTPUT.PUT_LINE(NOMBRE_PRUEBA || ':' || ASSERT_EQUALS(SALIDA,w_salida_esperada));

EXCEPTION 
WHEN OTHERS THEN
DBMS_OUTPUT.PUT_LINE(NOMBRE_PRUEBA || ':' || ASSERT_EQUALS (FALSE,w_salida_esperada));
ROLLBACK;

END eliminar;




end;


 
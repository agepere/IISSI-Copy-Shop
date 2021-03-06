CREATE OR REPLACE PACKAGE PRUEBAS_CLIENTES AS
PROCEDURE INICIALIZAR;
PROCEDURE INSERTAR(NOMBRE_PRUEBA VARCHAR2,W_DNI VARCHAR,W_NOMBRE VARCHAR,W_APELLIDOS VARCHAR,W_CORREO VARCHAR,W_DIRECCION VARCHAR,W_TELEFONO NUMBER,W_TIPO VARCHAR,SALIDAESPERADA BOOLEAN);
PROCEDURE ACTUALIZAR(NOMBRE_PRUEBA VARCHAR2,W_IDCLIENTE NUMBER,W_DNI VARCHAR,W_NOMBRE VARCHAR,W_APELLIDOS VARCHAR,W_CORREO VARCHAR,W_DIRECCION VARCHAR,W_TELEFONO NUMBER,W_TIPO VARCHAR,SALIDAESPERADA BOOLEAN);
PROCEDURE ELIMINAR(NOMBRE_PRUEBA VARCHAR2,W_IDCLIENTE NUMBER,SALIDAESPERADA BOOLEAN);
END PRUEBAS_CLIENTES;
/
CREATE OR REPLACE PACKAGE BODY PRUEBAS_CLIENTES AS
FUNCTION ASSERT_EQUALS(SALIDA BOOLEAN,SALIDA_ESPERADA BOOLEAN)RETURN VARCHAR2 AS 
BEGIN
IF(SALIDA = SALIDA_ESPERADA) THEN
 RETURN 'EXITO';
 ELSE
  RETURN 'FALLO';
END IF;
END ASSERT_EQUALS;

PROCEDURE INICIALIZAR AS 
BEGIN 
 DELETE FROM CLIENTES;
 COMMIT WORK;
END INICIALIZAR;

 Procedure INSERTAR(NOMBRE_PRUEBA VARCHAR2,W_DNI VARCHAR,W_NOMBRE VARCHAR,W_APELLIDOS VARCHAR,W_CORREO VARCHAR,W_DIRECCION VARCHAR,W_TELEFONO NUMBER,W_TIPO VARCHAR,SALIDAESPERADA BOOLEAN) AS
SALIDA BOOLEAN:= TRUE;
CLIENTE CLIENTES%ROWTYPE;
W_IDCLIENTE NUMBER;
BEGIN
--INSERT INTO CLIENTES VALUES(SEC_CLIENTES.NEXTVAL,W_DNI VARCHAR,W_NOMBRE VARCHAR,W_APELLIDOS VARCHAR,W_CORREO VARCHAR,W_DIRECCION VARCHAR,TELEFONO NUMBER,TIPO VARCHAR );
INSERTAR_CLIENTES (W_DNI,W_NOMBRE,W_APELLIDOS,W_CORREO,W_DIRECCION,W_TELEFONO,W_TIPO);
W_IDCLIENTE :=SEC_CLIENTES.CURRVAL;
SELECT * INTO CLIENTE FROM CLIENTES WHERE IDCLIENTE=W_IDCLIENTE;
IF(CLIENTE.DNI<>W_DNI OR CLIENTE.NOMBRE<>W_NOMBRE OR CLIENTE.APELLIDOS<>W_APELLIDOS OR CLIENTE.CORREO<>W_CORREO OR CLIENTE.DIRECCION<>W_DIRECCION OR CLIENTE.TELEFONO<>W_TELEFONO OR CLIENTE.TIPO<>W_TIPO)THEN
SALIDA :=FALSE;
END IF;
COMMIT WORK;
DBMS_OUTPUT.PUT_LINE(NOMBRE_PRUEBA || '1:' || ASSERT_EQUALS(SALIDA, SALIDAESPERADA));

EXCEPTION
WHEN OTHERS THEN
DBMS_OUTPUT.PUT_LINE(NOMBRE_PRUEBA || '2:' || ASSERT_EQUALS(FALSE, SALIDAESPERADA));
ROLLBACK;
END INSERTAR;





 Procedure ACTUALIZAR(NOMBRE_PRUEBA VARCHAR2,W_IDCLIENTE NUMBER,W_DNI VARCHAR,W_NOMBRE VARCHAR,W_APELLIDOS VARCHAR,W_CORREO VARCHAR,W_DIRECCION VARCHAR,W_TELEFONO NUMBER,W_TIPO VARCHAR,SALIDAESPERADA BOOLEAN) AS
SALIDA BOOLEAN:= TRUE;
CLIENTE CLIENTES%ROWTYPE;

BEGIN
UPDATE CLIENTES SET DNI=W_DNI,NOMBRE=W_NOMBRE ,APELLIDOS=W_APELLIDOS,CORREO=W_CORREO,DIRECCION=W_DIRECCION,TELEFONO=W_TELEFONO,TIPO=W_TIPO WHERE IDCLIENTE=W_IDCLIENTE;

SELECT * INTO CLIENTE FROM CLIENTES WHERE IDCLIENTE=W_IDCLIENTE;
IF(CLIENTE.DNI<>W_DNI OR CLIENTE.NOMBRE<>W_NOMBRE OR CLIENTE.APELLIDOS<>W_APELLIDOS OR CLIENTE.CORREO<>W_CORREO OR CLIENTE.DIRECCION<>W_DIRECCION OR CLIENTE.TELEFONO<>W_TELEFONO OR CLIENTE.TIPO<>W_TIPO)THEN
SALIDA :=FALSE;
END IF;
COMMIT WORK;
DBMS_OUTPUT.PUT_LINE(NOMBRE_PRUEBA || '1:' || ASSERT_EQUALS(SALIDA, SALIDAESPERADA));

EXCEPTION
WHEN OTHERS THEN
DBMS_OUTPUT.PUT_LINE(NOMBRE_PRUEBA || '2:' || ASSERT_EQUALS(FALSE, SALIDAESPERADA));
ROLLBACK;
END ACTUALIZAR;


 Procedure ELIMINAR(NOMBRE_PRUEBA VARCHAR2,W_IDCLIENTE NUMBER,SALIDAESPERADA BOOLEAN) AS
SALIDA BOOLEAN:= TRUE;
N_CLIENTE INTEGER;

BEGIN
DELETE FROM CLIENTES WHERE IDCLIENTE=W_IDCLIENTE;

SELECT COUNT (*) INTO N_CLIENTE FROM CLIENTES WHERE IDCLIENTE=W_IDCLIENTE;
IF(N_CLIENTE<>0)THEN
SALIDA :=FALSE;
END IF;
COMMIT WORK;
DBMS_OUTPUT.PUT_LINE(NOMBRE_PRUEBA || ':' || ASSERT_EQUALS(SALIDA, SALIDAESPERADA));

EXCEPTION
WHEN OTHERS THEN
DBMS_OUTPUT.PUT_LINE(NOMBRE_PRUEBA || ':' || ASSERT_EQUALS(FALSE, SALIDAESPERADA));
ROLLBACK;
END ELIMINAR;

END PRUEBAS_CLIENTES;
/

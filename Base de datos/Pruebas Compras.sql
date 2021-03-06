
SET SERVEROUTPUT ON;
DECLARE
  IDCOMPRAS NUMBER;
  FECHACOMPRA DATE;
  TOTAL NUMBER;
  IDPROVEEDOR NUMBER;
BEGIN

PRUEBAS_COMPRAS.INICIALIZAR;
PRUEBAS_COMPRAS.INSERTAR('PRUEBA 1 - INSERTAR COMPRA', SYSDATE, 10, NULL, TRUE);  
IDCOMPRAS:=SEC_COMPRAS.CURRVAL;
PRUEBAS_COMPRAS.INSERTAR('PRUEBA 2 - INSERTAR COMPRA CON NULOS', SYSDATE, 0, NULL, TRUE);
PRUEBAS_COMPRAS.INSERTAR('PRUEBA 3 - INSERTAR COMPRA CON PROVEEDOR', SYSDATE, 9, 1, TRUE); --Suponiendo que el proveedor 1 existe
PRUEBAS_COMPRAS.INSERTAR('PRUEBA 4 - INSERTAR COMPRA', SYSDATE, 10, 2345, FALSE); -- no se puede insertar una compra de un proveeedor que no existe

PRUEBAS_COMPRAS.ACTUALIZAR('PRUEBA 5 - ACTUALIZAR COMPRA', IDCOMPRAS, SYSDATE, 11, 2989, FALSE);-- no se puede poner una compra de un proveeedor que no existe
PRUEBAS_COMPRAS.ACTUALIZAR('PRUEBA 6 - ACTUALIZAR COMPRA CON NULOS', IDCOMPRAS, SYSDATE, 11, null, TRUE);
PRUEBAS_COMPRAS.ACTUALIZAR('PRUEBA 7 - ACTUALIZAR COMPRA CON PROVEEDOR', IDCOMPRAS, SYSDATE, 11, 1, TRUE);--Suponiendo que el proveedor 1 existe


PRUEBAS_COMPRAS.ELIMINAR('PRUEBA 8 - ELIMINAR COMPRA', IDCOMPRAS, TRUE);
END;
/

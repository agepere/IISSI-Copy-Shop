SET SERVEROUTPUT ON;
DECLARE
  IDDETALLECOMPRA NUMBER;
  CANTIDAD INTEGER;
  PRECIOCOMPRA NUMBER;
  IVA NUMBER;
  IDCOMPRAS NUMBER;
  IDCATALOGO NUMBER;
BEGIN
PRUEBAS_DETALLECOMPRA.INICIALIZAR;
PRUEBAS_DETALLECOMPRA.INSERTAR('PRUEBA 1 - INSERTAR DETALLECOMPRA', 10,  10,  '0,1', 3, 3, TRUE);  --SE SUPONE QUE EXISTE ID CATALOGO E ID COMPRA
IDDETALLECOMPRA:=SEC_DETALLECOMPRA.CURRVAL;
PRUEBAS_DETALLECOMPRA.INSERTAR('PRUEBA 2 - INSERTAR DETALLECOMPRA', 10,  10, '0,1', NULL, 3, FALSE); -- no se puede insertar un detalle sin indicar la compra a la que pertenece  
PRUEBAS_DETALLECOMPRA.INSERTAR('PRUEBA 3 - INSERTAR DETALLECOMPRA CON IVA MAYOR',  1, 3, 2 , 3, 3, FALSE); -- no se puede poner un IVA fuera de rango
PRUEBAS_DETALLECOMPRA.INSERTAR('PRUEBA 4 - INSERTAR DETALLECOMPRA CON CANTIDAD NULO',  NULL, 3, '0,1' ,3, NULL, FALSE); -- no se permita el NULO en la cantidad
PRUEBAS_DETALLECOMPRA.INSERTAR('PRUEBA 5 - INSERTAR DETALLECOMPRA CON PRECIO NULO',  NULL, 3, '0,1' , 3, NULL, FALSE); -- no se permita el NULO en la precio
PRUEBAS_DETALLECOMPRA.INSERTAR('PRUEBA 6 - INSERTAR DETALLECOMPRA CON IVA NULO',  NULL, 3, '0,1' , 3, NULL, FALSE); -- no se permita el NULO en la IVA
PRUEBAS_DETALLECOMPRA.INSERTAR('PRUEBA 7 - INSERTAR DETALLECOMPRA SIN CATALOGO', 10, 3, '0,3' , 3, NULL, FALSE);

PRUEBAS_DETALLECOMPRA.ACTUALIZAR('PRUEBA 8 - ACTUALIZAR DETALLECOMPRA', IDDETALLECOMPRA, 1, 11, '0,5', 3, TRUE);
PRUEBAS_DETALLECOMPRA.ACTUALIZAR('PRUEBA 9 - ACTUALIZAR DETALLECOMPRA CON IVA MAYOR', IDDETALLECOMPRA, 1, 11, 2, 3, FALSE);
PRUEBAS_DETALLECOMPRA.ACTUALIZAR('PRUEBA 10 - ACTUALIZAR DETALLECOMPRA CON NULOS', IDDETALLECOMPRA, NULL, NULL, NULL, NULL, FALSE);

PRUEBAS_DETALLECOMPRA.ELIMINAR('PRUEBA 11 - ELIMINAR DETALLECOMPRA', IDDETALLECOMPRA, TRUE);
END;
/


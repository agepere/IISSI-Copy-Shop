EXECUTE INSERTAR_VENTAS (SYSDATE, 2,2) ;
-- SE SUPONE QUE EXISTE EL EMPLEADO 2 Y EL CLIENTE 2
SET SERVEROUTPUT ON;

DECLARE
w_IDFACTURA NUMBER;
w_IDVENTAS NUMBER;

BEGIN
w_IDVENTAS:=sec_VENTAS.currval;
PRUEBAS_FACTURA.INICIALIZAR;
PRUEBAS_FACTURA.INSERTAR('Prueba 1','10-11-2013',w_IDVENTAS,true);
w_IDFACTURA:=sec_FACTURA.currval;
PRUEBAS_FACTURA.INSERTAR('Prueba 2','10-11-2017',w_IDVENTAS,false);

PRUEBAS_FACTURA.ACTUALIZAR('Prueba 3', w_IDFACTURA, '10-11-2014',w_IDVENTAS,true);
PRUEBAS_FACTURA.ACTUALIZAR('Prueba 5', w_IDFACTURA, '10-11-2017',w_IDVENTAS,false);
PRUEBAS_FACTURA.Eliminar('Prueba 6', w_IDFACTURA,true);






END;

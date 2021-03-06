SET SERVEROUTPUT ON;

DECLARE 
  IDPROVEEDOR NUMBER;
  
  
  BEGIN
  PRUEBAS_PROVEEDOR.INICIALIZAR;
  PRUEBAS_PROVEEDOR.INSERTAR('PRUEBA 1 - INSERTAR PROVEEDOR','12345678A','PROVEEDORES SA','AVENIDA DE LA CONSTITUCION',TRUE);
  IDPROVEEDOR:= SEC_PROVEEDOR.CURRVAL;
  PRUEBAS_PROVEEDOR.INSERTAR('PRUEBA 1.2 - INSERTAR PROVEEDOR 2','98765432B','APPLE','AVENIDA DE LA PALMERA',TRUE);
  IDPROVEEDOR:= SEC_PROVEEDOR.CURRVAL;
  PRUEBAS_PROVEEDOR.INSERTAR('PRUEBA 2 - INSERTAR PROVEEDOR(CIF MAYOR QUE 9 DIGITOS','122345678A','PROVEEDORES SA','AVENIDA DE LA CONSTITUCION',FALSE);
  PRUEBAS_PROVEEDOR.INSERTAR('PRUEBA 3 - INSERTAR PROVEEDOR(SIN EMPRESA)','12345678A',NULL,'AVENIDA DE LA CONSTITUCION',FALSE);
  PRUEBAS_PROVEEDOR.INSERTAR('PRUEBA 4 - INSERTAR PROVEEDOR(LONGITUD DE DIRECCION MAYOR','12345678A','PROVEEDORES SA','AVENIDA DE LA PRIMERA CONSTITUCION ESPA�OLA  NUMERO TRESCIENTOS CUARENTA Y CUATRO',FALSE);
  PRUEBAS_PROVEEDOR.INSERTAR('PRUEBA 5 - INSERTAR PROVEEDOR(SIN CIF)',NULL,'PROVEEDORES SA','AVENIDA DE LA CONSTITUCION',FALSE);
  PRUEBAS_PROVEEDOR.INSERTAR('PRUEBA 6 - INSERTAR PROVEEDOR(DIRECCION NULA)','12345678A','PROVEEDORES SA',NULL,FALSE);
  
  PRUEBAS_PROVEEDOR.ACTUALIZAR('PRUEBA 7 - ACTUALIZAR PROVEEDOR',IDPROVEEDOR,'98756322A','ABENGOA SA','CALLE FERIA',TRUE);
  PRUEBAS_PROVEEDOR.ACTUALIZAR('PRUEBA 8 - ACTUALIZAR PROVEEDOR(CIF MAYOR QUE 9 DIGITOS',IDPROVEEDOR,'987556322A','ABENGOA SA','CALLE FERIA',FALSE);
  PRUEBAS_PROVEEDOR.ACTUALIZAR('PRUEBA 9 - ACTUALIZAR PROVEEDOR(SIN EMPRESA)',IDPROVEEDOR,'98756322A',NULL,'CALLE FERIA',FALSE);
  PRUEBAS_PROVEEDOR.ACTUALIZAR('PRUEBA 10 - ACTUALIZAR PROVEEDOR(SIN CIF)',IDPROVEEDOR,NULL,'ABENGOA','CALLE TORNEO',FALSE);
  PRUEBAS_PROVEEDOR.ACTUALIZAR('PRUEBA 11 - ACTUALIZAR PROVEEDOR(DIRECCION NULA)',IDPROVEEDOR,'98756322A','ABENGOA SA',NULL,FALSE);
  
  PRUEBAS_PROVEEDOR.ELIMINAR('PRUEBA 12 - ELIMINAR PROVEEDOR',IDPROVEEDOR,TRUE);
  
  
  END;

EXECUTE INSERTAR_CATALOGOS('Boligrafos','Pinta',3, '0,3',10,7,'Papeleria','Producto');
EXECUTE INSERTAR_CATALOGOS ('Copias','Fotocopia','0,1','0,3',null,null,null,'Servicio');
EXECUTE INSERTAR_CATALOGOS('Cartucheras','guarda cosas',3, '0,3',100,7,'Papeleria','Producto');

SET SERVEROUTPUT ON;

DECLARE 
  IDOFERTA NUMBER;
  IDCATALOGO NUMBER;   
  BEGIN
  
  IDCATALOGO:=SEC_CATALOGO.CURRVAL;
  
  
  PRUEBAS_OFERTAS.INICIALIZAR;
  PRUEBAS_OFERTAS.INSERTAR('PRUEBA 1 - INSERTAR OFERTA 1','02-03-2016','05-06-2016','0,1',IDCATALOGO,TRUE);
  IDOFERTA:=SEC_OFERTAS.CURRVAL;
  PRUEBAS_OFERTAS.INSERTAR('PRUEBA 1.2 - INSERTAR OFERTA 2','10-11-2016',NULL,'0,2',IDCATALOGO-1,TRUE);
  PRUEBAS_OFERTAS.INSERTAR('PRUEBA 2 - INSERTAR OFERTA(FECHA INICIO NULL) ',NULL,'05-06-2016','0,1',IDCATALOGO,FALSE);
  PRUEBAS_OFERTAS.INSERTAR('PRUEBA 3 - INSERTAR OFERTA(IDCATALOGO NULL)','02-03-2016','05-06-2016','0,1',NULL,FALSE);
  PRUEBAS_OFERTAS.INSERTAR('PRUEBA 4 - INSERTAR OFERTA(FECHAINICIO > FECHAFIN)','10-12-2016','05-12-2016','0,1',IDCATALOGO,FALSE);
  PRUEBAS_OFERTAS.INSERTAR('PRUEBA 5 - INSERTAR OFERTA(DESCUENTO<0)','02-03-2016','05-06-2016',-1,IDCATALOGO,FALSE);
  PRUEBAS_OFERTAS.INSERTAR('PRUEBA 6 - INSERTAR OFERTA(DESCUENTO>1)','02-03-2016','05-06-2016',2,IDCATALOGO,FALSE);
  
  PRUEBAS_OFERTAS.ACTUALIZAR('PRUEBA 7 - ACTUALIZAR OFERTA 1 ',IDOFERTA,'11-11-2016','12-12-2016','0,15',IDCATALOGO,TRUE);
  PRUEBAS_OFERTAS.ACTUALIZAR('PRUEBA 7.2 - ACTUALIZAR OFERTA 2 ',IDOFERTA,'13-10-2016','20-12-2016','0,15',IDCATALOGO-1,TRUE);
  PRUEBAS_OFERTAS.ACTUALIZAR('PRUEBA 8 - ACTUALIZAR OFERTA(FECHA INICIO NULL) ',IDOFERTA,NULL,'12-12-2016','0,15',IDCATALOGO,FALSE);
  PRUEBAS_OFERTAS.ACTUALIZAR('PRUEBA 9 - ACTUALIZAR OFERTA(IDCATALOGO NULL) ',IDOFERTA,'11-11-2016','12-12-2016','0,15',NULL,FALSE);
  PRUEBAS_OFERTAS.ACTUALIZAR('PRUEBA 10 - ACTUALIZAR OFERTA(FECHAINICIO > FECHAFIN) ',IDOFERTA,'20-12-2016','10-12-2016','0,15',IDCATALOGO,FALSE);
  PRUEBAS_OFERTAS.ACTUALIZAR('PRUEBA 11 - ACTUALIZAR OFERTA(DESCUENTO<0) ',IDOFERTA,'11-11-2016','12-12-2016',-5,IDCATALOGO,FALSE);
  PRUEBAS_OFERTAS.ACTUALIZAR('PRUEBA 12 - ACTUALIZAR OFERTA(DESCUENTO>1) ',IDOFERTA,'11-11-2016','12-12-2016',5,IDCATALOGO,FALSE);
  
  PRUEBAS_OFERTAS.ELIMINAR('PRUEBA 13- ELIMINAR OFERTA',IDOFERTA,TRUE);
  END;
/
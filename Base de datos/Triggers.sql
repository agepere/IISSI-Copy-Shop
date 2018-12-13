

CREATE OR REPLACE TRIGGER COMPRUEBA_FECHAVENTA
BEFORE INSERT ON VENTAS
FOR EACH ROW 
BEGIN 
IF :new.FECHAVENTA > SYSDATE
THEN raise_application_error (-20600,:new.FECHAVENTA || 'La fecha de venta no puede ser posterior a la fecha del sistema');
END IF;
END COMPRUEBA_FECHAVENTA;
/
CREATE OR REPLACE TRIGGER COMPRUEBA_FECHACOMPRA
BEFORE INSERT ON COMPRAS
FOR EACH ROW 
BEGIN 
IF :new.FECHACOMPRA > SYSDATE
THEN raise_application_error (-20600,:new.FECHACOMPRA || 'La fecha de compra no puede ser posterior a la fecha del sistema');
END IF;
END COMPRUEBA_FECHACOMPRA;
/




create or replace TRIGGER COMPRUEBA_FECHAVENTA_ACTUALIZA
BEFORE UPDATE ON VENTAS
FOR EACH ROW 
BEGIN 
IF :new.FECHAVENTA > SYSDATE
THEN raise_application_error (-20600,:new.FECHAVENTA || 'La fecha de venta no puede ser posterior a la fecha del sistema');
END IF;
END COMPRUEBA_FECHAVENTA_ACTUALIZA;
/

CREATE OR REPLACE TRIGGER COMPRUEBA_FECHAFACTURA
BEFORE INSERT ON FACTURA
FOR EACH ROW 
BEGIN 
IF :new.FECHAFACTURA > SYSDATE
THEN raise_application_error (-20600,:new.FECHAFACTURA|| 'La fecha de factura no puede ser posterior a la fecha del sistema');
END IF;
END COMPRUEBA_FECHAFACTURA;
/

CREATE OR REPLACE TRIGGER COMPRUEBA_FECHAFACTURA_ACT
BEFORE UPDATE ON FACTURA
FOR EACH ROW 
BEGIN 
IF :new.FECHAFACTURA > SYSDATE
THEN raise_application_error (-20600,:new.FECHAFACTURA|| 'La fecha de factura no puede ser posterior a la fecha del sistema');
END IF;
END COMPRUEBA_FECHAFACTURA_ACT;
/

CREATE OR REPLACE TRIGGER COMPRUEBA_FECHACOMPRA_ACT
BEFORE UPDATE ON COMPRAS
FOR EACH ROW 
BEGIN 
IF :new.FECHACOMPRA > SYSDATE
THEN raise_application_error (-20600,:new.FECHACOMPRA || 'La fecha de compra no puede ser posterior a la fecha del sistema');
END IF;
END COMPRUEBA_FECHACOMPRA;
/

CREATE OR REPLACE TRIGGER COMPRUEBA_STOCK
BEFORE INSERT ON CATALOGO
FOR EACH ROW
BEGIN
IF(:new.tipocatalogo='Producto' AND (:new.Stock<0 OR :new.StockMinimo<0 OR :new.Stock is null OR :new.StockMinimo is null))THEN
raise_application_error (-20600,:new.TipoCatalogo || 'Un producto debe tener stock y stock minimo mayor que 0');
END IF;


END COMPRUEBA_STOCK;
/

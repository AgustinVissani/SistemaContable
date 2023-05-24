CREATE TABLE renglones(
 	id INTEGER UNSIGNED NOT NULL,
    id_asiento INTEGER UNSIGNED NOT NULL,
    id_cuenta INTEGER UNSIGNED NOT NULL ,
    fecha_vencimiento DATETIME NOT NULL,
    fecha_oper DATETIME NOT NULL,
    comprobante VARCHAR(255) NOT NULL,
    id_sucursal INTEGER UNSIGNED NOT NULL,
    id_seccion INTEGER UNSIGNED NOT NULL,
    debe_haber INT(1)  NOT NULL,
    importe FLOAT(16,2)  NOT NULL,
    leyenda VARCHAR(100)  NOT NULL,
 	created_at DATETIME,
    updated_at DATETIME,



    FOREIGN KEY (id_asiento) REFERENCES asientos(id)
	ON UPDATE CASCADE ON DELETE RESTRICT,

    FOREIGN KEY (id_seccion) REFERENCES secciones(id)
	ON UPDATE CASCADE ON DELETE RESTRICT,

    FOREIGN KEY (id_sucursal) REFERENCES sucursales(id)
	ON UPDATE CASCADE ON DELETE RESTRICT,

    FOREIGN KEY (id_cuenta) REFERENCES plancuentas(id)
	ON UPDATE CASCADE ON DELETE RESTRICT

) ENGINE=InnoDB;

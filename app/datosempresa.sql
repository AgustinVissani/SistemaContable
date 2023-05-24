CREATE TABLE datosempresa(
 	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    nombrepila VARCHAR(255),
    id_provincia INTEGER UNSIGNED NOT NULL,
    cp INT(4),
    id_localidad VARCHAR(100) ,
    calle VARCHAR(255),
    numero VARCHAR(10),
    piso VARCHAR(10),
    tipo_responsable INT(3) NOT NULL,
    cuit VARCHAR(15),
    fecha_emision_diario DATETIME,
    ult_tomo INT(3),
    ult_folio INT(6),
    ult_asiento INT(8),
    ult_renglon INT(8),
    ult_transporte FLOAT(16,2),
    fecha_apertura DATETIME,
    fecha_cierre DATETIME,
    created_at DATETIME,
    updated_at DATETIME,



 	PRIMARY KEY (id),


    FOREIGN KEY (id_provincia) REFERENCES provincias(id)
	ON UPDATE CASCADE ON DELETE RESTRICT


) ENGINE=InnoDB;

CREATE TABLE sucursales(
 	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    denominacion VARCHAR(100) NOT NULL,
    id_provincia INTEGER UNSIGNED NOT NULL,
    cp INT(4),
    id_localidad VARCHAR(90) ,
    calle VARCHAR(255),
    numero VARCHAR(10),
    piso VARCHAR(10),
 	created_at DATETIME,
    updated_at DATETIME,

 	PRIMARY KEY (id),


    FOREIGN KEY (id_provincia) REFERENCES provincias(id)
	ON UPDATE CASCADE ON DELETE RESTRICT

) ENGINE=InnoDB;

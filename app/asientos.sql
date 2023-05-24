CREATE TABLE asientos(
 	id INTEGER UNSIGNED NOT NULL,
    fecha DATETIME NOT NULL,
    tipo_asiento INT(1) UNSIGNED NOT NULL,
    proximo_id_renglon INTEGER UNSIGNED NOT NULL,
    ok_carga INT(1)  NOT NULL,
    registrado INT(1)  NOT NULL,
    created_at DATETIME,
    updated_at DATETIME,

 	PRIMARY KEY (id)


) ENGINE=InnoDB;



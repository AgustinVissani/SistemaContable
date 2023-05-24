CREATE TABLE secciones(
 	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    denominacion VARCHAR(100) NOT NULL,
 	created_at DATETIME,
    updated_at DATETIME,

 	PRIMARY KEY (id)

) ENGINE=InnoDB;

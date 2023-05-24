CREATE TABLE plancuentas(
 	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    codigo VARCHAR(255),
    prefijo VARCHAR(100),
    sufijo VARCHAR(3),
    nombre VARCHAR(200) UNIQUE NOT NULL,
    imp VARCHAR(2) NOT NULL,
    nivel INT UNSIGNED,
    created_at DATETIME,
    updated_at DATETIME,

 	PRIMARY KEY (id)

) ENGINE=InnoDB;

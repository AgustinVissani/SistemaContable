CREATE TABLE balances(
 	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    id_cuenta INTEGER UNSIGNED NOT NULL ,
    codigo VARCHAR(255),
    prefijo VARCHAR(100),
    sufijo VARCHAR(3),
    nombre VARCHAR(200) UNIQUE NOT NULL,
    nivel INT UNSIGNED,
    debitos FLOAT(16,2) NOT NULL,
    creditos FLOAT(16,2) NOT NULL,
    saldo_inicial FLOAT(16,2)  NOT NULL,
    saldo_acumulado FLOAT(16,2)  NOT NULL,
    saldo_cierre FLOAT(16,2)  NOT NULL,
 	created_at DATETIME,
    updated_at DATETIME,

    PRIMARY KEY (id)

) ENGINE=InnoDB;

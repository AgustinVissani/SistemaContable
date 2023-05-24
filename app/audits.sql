CREATE TABLE audits(
 	id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_type VARCHAR(191) UNIQUE,
    user_id INTEGER UNSIGNED UNIQUE,
    event VARCHAR(191) NOT NULL,
    auditable_type VARCHAR(191) UNIQUE NOT NULL,
    auditable_id BIGINT UNIQUE NOT NULL,
    old_values TEXT,
    new_values TEXT,
    url TEXT,
    ip_address VARCHAR(45),
    user_agent VARCHAR(1023),
    tags VARCHAR(191),
 	created_at DATETIME,
    updated_at DATETIME,

 	PRIMARY KEY (id),


    FOREIGN KEY (user_id) REFERENCES users(id)
	ON UPDATE CASCADE ON DELETE RESTRICT

) ENGINE=InnoDB;

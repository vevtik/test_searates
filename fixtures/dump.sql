DROP TABLE IF EXISTS ports;
CREATE TABLE ports (
     locode char(5) NOT NULL PRIMARY KEY,
     country char(2) NOT NULL,
     port_code char(3) NOT NULL,
     name varchar (255) NOT NULL,
     UNIQUE KEY (country, port_code)
);
DROP TABLE IF EXISTS countries;
CREATE TABLE countries (
    alpha2 char(2) NOT NULL PRIMARY KEY,
    name varchar (255) NOT NULL,
    UNIQUE KEY (name)
);
DROP TABLE IF EXISTS rates;
CREATE TABLE rates (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    port_from char(5) NOT NULL,
    port_to char (5) NOT NULL,
    container_type varchar(25) NOT NULL,
    rate decimal (10, 2) NOT NULL,
    currency char(3) NOT NULL DEFAULT 'USD',
    UNIQUE KEY (port_from, port_to, container_type)
);
CREATE INDEX rates_ports USING BTREE ON rates (port_from, port_to);
CREATE INDEX rates_container ON rates (container_type);

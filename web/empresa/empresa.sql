DROP TABLE IF EXISTS departamentos CASCADE;

CREATE TABLE departamentos 
(
    id        bigserial    PRIMARY KEY
  , numero    numeric(2)   NOT NULL UNIQUE
  , dnombre   varchar(255) NOT NULL
  , localidad varchar(255)
);

DROP TABLE IF EXISTS empleados CASCADE;

CREATE TABLE empleados 
(
    id              bigserial      PRIMARY KEY
  , num_emp         numeric(4)     NOT NULL UNIQUE
  , nombre          varchar(255)   NOT NULL
  , salario         numeric(6,2) 
  , departamento_id bigint         NOT NULL REFERENCES departamentos(id)
                                   ON DELETE NO ACTION ON UPDATE CASCADE 
);

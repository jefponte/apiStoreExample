
CREATE TABLE produto (
        id serial NOT NULL, 
        CONSTRAINT pk_produto PRIMARY KEY (id), 
        descricao character varying(150), 
        valor numeric(8,2)
);

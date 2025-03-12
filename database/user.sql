DROP TABLE IF EXISTS public.usuario;

CREATE TABLE IF NOT EXISTS public.usuario
(
    id_usuario SERIAL                                                                                               ,
    id_cliente                      integer                                                                         ,
    id_orgao                        integer                                                                         ,

    nome                            character varying(50) COLLATE pg_catalog."default" NOT NULL                     ,
    imagem                          character varying(50) COLLATE pg_catalog."default" NOT NULL                     ,
    email                           character varying(50) COLLATE pg_catalog."default"                              ,
    telefone                        character varying(50) COLLATE pg_catalog."default"                              ,

    login                           character varying(20) COLLATE pg_catalog."default" NOT NULL                     ,
    senha                           character varying(40) COLLATE pg_catalog."default" NOT NULL                     ,
    administrador                   character varying(1) COLLATE pg_catalog."default" NOT NULL DEFAULT 'N'::bpchar  ,
    
    habilitado                      character(1) COLLATE pg_catalog."default" DEFAULT 'S'::bpchar                   ,
    alterou_senha                   character(1) COLLATE pg_catalog."default" DEFAULT 'N'::bpchar                   ,
    dt_validade                     date                                                                            ,
    dt_inatividade_inicio           date                                                                            ,
    dt_inatividade_fim              date                                                                            ,

    CONSTRAINT usuario_pkey PRIMARY KEY (id_usuario)                                                                ,

    CONSTRAINT usuario_id_orgao FOREIGN KEY (id_orgao)
        REFERENCES public.orgao (id_orgao) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID                                                                                                   ,


    CONSTRAINT usuario_id_cliente FOREIGN KEY (id_orgao)
        REFERENCES public.cliente (id_cliente) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID                                                                                                   ,
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.usuario
    OWNER to postgres;
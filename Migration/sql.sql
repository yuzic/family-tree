CREATE TABLE "comment" (
  "id" serial,
  "name" character varying(100) NOT NULL,
  "email" character varying(100)  NOT NULL,
  "homepage" character varying(100)  NOT NULL,
  "ip" character varying(100)  NOT NULL,
  "agent" character varying(500)  NOT NULL,
  "message" text,
  "created_at" integer DEFAULT NULL,
  CONSTRAINT comment_pkey PRIMARY KEY (id )
);



CREATE TABLE "family_tree"
(
  "id" serial NOT NULL,
  "parent_id" INTEGER DEFAULT NULL references family_tree(id),
  "name"  CHARACTER VARYING(500) NOT NULL,
  "created_at" INTEGER NOT NULL,
  "modified_at" INTEGER DEFAULT NULL,
  CONSTRAINT family_tree_pkey PRIMARY KEY (id )
);


INSERT INTO "family_tree" ("parent_id","name","created_at") VALUES (2, 'отец', 2);
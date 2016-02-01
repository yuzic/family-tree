CREATE TABLE "family_tree"
(
  "id" serial NOT NULL,
  "parent_id" INTEGER DEFAULT NULL references family_tree(id) ON DELETE CASCADE,
  "name"  CHARACTER VARYING(500) NOT NULL,
  "created_at" INTEGER NOT NULL,
  "modified_at" INTEGER DEFAULT NULL,
  CONSTRAINT family_tree_pkey PRIMARY KEY (id )
);

 INSERT INTO "family_tree"
                (
                  "name",
                  "parent_id",
                  "created_at"
                )
                VALUES('Все семьи', null, 1);


<?php
namespace App\Model;

class FamilyTree extends \Aqua\Db\Model
{

    public function lists()
    {
        $sql = 'WITH RECURSIVE "recursive_family" (
                "id",
                "parent_id",
                "name",
                "level") AS (
                (
                  SELECT
                    "id",
                    "parent_id",
                    "name",
                    1 AS "level"
                  FROM "family_tree"
                  WHERE "parent_id" IS NULL
                )
              UNION ALL SELECT
                "f_dir"."id",
                "f_dir"."parent_id" ,
                "f_dir"."name",
                "r"."level" + 1
              FROM "family_tree" "f_dir"
              JOIN "recursive_family" "r"
                  ON ("f_dir"."parent_id" = "r"."id")
            )
            SELECT
              "id",
              "parent_id",
              "name"
            FROM "recursive_family"';

        $query = (new \Aqua\Db\Query)->instances($sql, []);

        return  \Aqua\Db\Connection::query($query)->asArray();
    }  


    public function add($params)
    {
        $sql = 'BEGIN;
                INSERT INTO "family_tree"
                (
                  "name",
                  "parent_id",
                  "created_at"
                )
                VALUES
                (
                  ?name,
                  ?parent_id,
                  ?created_at
                );
                COMMIT;';

        $query = (new \Aqua\Db\Query)->instances($sql, $params);

        return  \Aqua\Db\Connection::query($query);
    }  
}

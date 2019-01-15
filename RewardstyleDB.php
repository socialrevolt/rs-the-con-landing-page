<?php

class RewardstyleDB {

    public static $default = null;

    public static $pdo = null;

    public static function execute($sql, $args) {
        list ($dsn, $user, $pass) = RewardstyleDB::$default;
        $pdo = RewardstyleDB::$pdo;
        try {
            if (!$pdo) {
                $pdo = new PDO($dsn, $user, $pass, $options);
                RewardstyleDB::$pdo = $pdo;
            }
            $stmt = $pdo->prepare($sql);
            $stmt->execute($args);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e)  {
            RewardstyleDB::$pdo = null;
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

}

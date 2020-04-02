<?php
namespace app\config;

use \PDO;

class DB {

    private static $PDOInstance;
    private static $db_name = '';
    private static $db_user = '';
    private static $db_pass = '';
    private static $stmt;

    static private $ConInstance;

    static public function getInstance() {
      if (!self::$PDOInstance) {
          self::$PDOInstance = new self;
      }
      return self::$PDOInstance;
    }

    private  function __construct() {
        try {
            $this::$ConInstance = new \PDO('mysql:host=localhost;dbname='.self::$db_name, self::$db_user, self::$db_pass);
            $this::$ConInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this::$ConInstance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this::$ConInstance->exec('SET NAMES utf8');

        } catch (PDOException $e) {
            die("PDO CONNECTION ERROR: " . $e->getMessage() . "<br/>");
        }
    }

    private function __clone() {}

    private function __wakeup() {}

    private function __sleep() {}

    public function query($sql,$params = []){
        if(!is_array($params)){ $params = array($params); }
        try{
          self::$stmt = self::$ConInstance->prepare($sql);
          self::$stmt->execute($params);
          return self::$PDOInstance;
        }catch(PDOException $e){
           die("PDO SQL ERROR: " . $e->getMessage() . "<br/>");
        }
    }

    public function fetchAssocAll(){
      return self::$stmt->fetchall(PDO::FETCH_ASSOC);
    }
    public function fetchAssoc(){
      return self::$stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchObjAll(){
      return self::$stmt->fetchall(PDO::FETCH_OBJ);
    }
    public function fetchObj(){
      return self::$stmt->fetch(PDO::FETCH_OBJ);
    }
    public function lastID(){
      return self::$ConInstance->lastInsertId();
    }

}

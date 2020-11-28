<?php

abstract class PDOConnect {
    private $dbs = "localhost";
    private $dbu = "root";
    private $dbp = "";
    private $dbn = "Learning_languages";
    private $dbo = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );
    private $conn;
    private $stmt;


    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->dbs;dbname=$this->dbn", $this->dbu, $this->dbp, $this->dbo);
        } catch (PDOException $e) {
            Header::headerError("error.php", "حصل خطأ اثناء الاتصال بقاعدة البيانات");
        }
    }
    
    /*
     * تابع يقوم بعملية الادخال الى قاعدة البيانات 
     */
    public function insert($table, $column, $values) {
        return $this->stmt = $this->conn->prepare("INSERT INTO $table($column) VALUES($values)");                
    }
    /*
     * تابع يقوم بعملية التعديل على قواعد البيانات
     */
    public function update($table, $column, $where = null) {
        $this->stmt = $this->conn->prepare("UPDATE $table SET $column $where");
    }
    /*
     * تابع يقوم بحذف من قواعد البيانات
     */
    public function delete($table, $where = null){
        $this->stmt = $this->conn->prepare("DELETE FROM $table $where");
    }
    /*
     * تابع يقوم بجلب البيانات من قاعدة البيانات
     */
    public function select($column, $table, $where = null){
        $this->stmt = $this->conn->prepare("SELECT $column FROM $table $where");
    }
    /*
     * تابع يقوم باخذ البيانات
     */
    public function fetch($type = null){
        return $this->stmt->fetch($type);
    }
    /*
     * تابع يقوم باخذ البيانات
     */
    public function fetchAll($type = null){
        return $this->stmt->fetchAll($type);
    }
    /*
     * select تابع يقوم بجلب عدد البيانات العائدة من
     */
    public function rowCount() {
        return $this->stmt->rowCount();
    }
    /*
     * تابع لتنفيذ الاستعلامات
     */
    public function execute($array = null) {
        return $this->stmt->execute($array) ? true : false;
    }
    /*
     * تابع لفلترة الخقول
     */
    public function filter($input, $type) {
        return trim(filter_var($input, $type));
    }
    
    /*
     * تابع لجلب عدد حقول جدول معين
     */
    public function countColumn($column, $table, $where = null){
        if ( $where === null ) {
            $this->select("count($column) as getCount", $table);
        } else {
            $this->select("count($column) as getCount", $table, $where);
        }
        $this->execute();
        $c = $this->fetch();
        return $c['getCount'];
    }
    
    public function signOut($session) {
        if ( !isset($session->userInfo) ) {
            $session->kill();
            Header::headerTo("index.php");
        }
    }
    
}
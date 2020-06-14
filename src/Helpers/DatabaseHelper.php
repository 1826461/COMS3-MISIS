<?php

namespace Helpers;

use PDO;
use PDOException;
use PDOStatement;

class DatabaseHelper
{
    public PDOStatement $statement;
    public ?string $error = null;
    protected PDO $databaseHelper;
    protected string $mySQLHost = "localhost";
    protected int $mySQLPort = 3306;
    protected string $mySQLSocket = "";
    protected string $mySQLUser = "root";
    protected string $mySQLPassword = "";
    protected string $mySQLDbName = "coms3-misis";

    public function __construct()
    {
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT);

        $this->databaseHelper = new PDO("mysql:host={$this->mySQLHost};port={$this->mySQLPort};dbname={$this->mySQLDbName}", $this->mySQLUser, $this->mySQLPassword, $options);
    }

    public function query($query)
    {
        $this->statement = $this->databaseHelper->prepare($query);
    }

    public function bind($param, $value, $type = null)
    {
        //uncomment if needed in future
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    //$type = PDO::PARAM_BOOL;
                    //break;
                case is_null($value):
                    //$type = PDO::PARAM_NULL;
                    //break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->statement->bindValue($param, $value, $type);

    }

    public function resultSet()
    {
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function execute()
    {
        return $this->statement->execute();
    }

    public function single()
    {
        $this->execute();
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount()
    {
        return $this->statement->rowCount();
    }

    public function lastInsertId()
    {
        return $this->databaseHelper->lastInsertId();
    }

}
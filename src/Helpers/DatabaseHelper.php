<?php

namespace Helpers;

use PDO;
use PDOStatement;

class DatabaseHelper
{
    public PDOStatement $statement;
    public ?string $error = null;
    protected PDO $databaseHelper;
    protected string $mySQLHost = "localhost";
    protected int $mySQLPort = 3306;
    //protected string $mySQLSocket = "";
    protected string $mySQLUser = "root";
    protected string $mySQLPassword = "";

    /**
     * DatabaseHelper constructor.
     * @param string $mySQLDbName
     */
    public function __construct(string $mySQLDbName)
    {
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT);

        $this->databaseHelper = new PDO("mysql:host={$this->mySQLHost};port={$this->mySQLPort};dbname={$mySQLDbName}", $this->mySQLUser, $this->mySQLPassword, $options);
    }

    /**
     * @param $query
     */
    public function query($query)
    {
        $this->statement = $this->databaseHelper->prepare($query);
    }

    /**
     * @param $param
     * @param $value
     * @param null $type
     */
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

    /**
     * @return array
     */
    public function resultSet()
    {
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return bool
     */
    public function execute()
    {
        return $this->statement->execute();
    }

    /**
     * @return mixed
     */
    public function single()
    {
        $this->execute();
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @return int
     */
    public function rowCount()
    {
        return $this->statement->rowCount();
    }

    /**
     * @return string
     */
    public function lastInsertId()
    {
        return $this->databaseHelper->lastInsertId();
    }

}

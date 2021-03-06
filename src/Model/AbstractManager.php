<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 20:52
 * PHP version 7
 */

namespace Model;

use App\Connection;

/**
 * Abstract class handling default manager.
 */
abstract class AbstractManager
{
    protected $pdoConnection; //variable de connexion

    protected $table;
    protected $className;

    /**
     *  Initializes Manager Abstract class.
     *
     * @param string $table Table name of current model
     */
    public function __construct(string $table)
    {
        $connexion = new Connection();
        $this->pdoConnection = $connexion->getPdoConnection();
        $this->table = $table;
        $className = str_replace('_', '', ucwords($table, '_'));
        $this->className = __NAMESPACE__ . '\\' . $className;
    }

    /**
     * @return int
     */
    public function nextAutoIncrement():int
    {
        $autoIncrement = $this->pdoConnection
            ->query('SELECT AUTO_INCREMENT
                                FROM information_schema.TABLES
                                WHERE TABLE_SCHEMA = "kitchenkustoms"
                                AND TABLE_NAME = "' . self::TABLE . '"')
            ->fetch(\PDO::FETCH_ASSOC);

        $nextAutoIncrement = (int)$autoIncrement['AUTO_INCREMENT'] + 1;

        return $nextAutoIncrement;
    }

    /**
     * Get all row from database.
     *
     * @return array
     */
    public function selectAll(): array
    {
        return $this->pdoConnection
            ->query('SELECT * FROM ' . $this->table, \PDO::FETCH_CLASS, $this->className)->fetchAll();
    }

    /**
     * Get one row from database by ID.
     *
     * @param  int $id
     *
     * @return array
     */
    public function selectOneById(int $id)
    {
        // prepared request
        $statement = $this->pdoConnection->prepare("SELECT * FROM $this->table WHERE id=:id");
        $statement->setFetchMode(\PDO::FETCH_CLASS, $this->className);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    /**
     * DELETE on row in dataase by ID
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id=:id';

        $prepare = $this->pdoConnection->prepare($query);
        $prepare->bindValue(':id', $id, \PDO::PARAM_INT);
        $prepare->execute();
        $data = $prepare->fetch(\PDO::FETCH_ASSOC);

        if ($data !== false) {
            $query = 'DELETE FROM ' . $this->table . ' WHERE id=:id';

            $prepare = $this->pdoConnection->prepare($query);
            $prepare->bindValue('id', $id, \PDO::PARAM_INT);

            $prepare->execute();

            return true;
        }
        return false;
    }


    /**
     * Simple INSERT one row in database
     *
     * @param array $data
     * @return bool
     */
    public function insert(array $data): bool
    {
        $queryFields = implode(',', array_keys($data));
        $markers = array_fill(0, count($data), '?');
        $queryMarkers = implode(',', $markers);
        $query = "INSERT INTO $this->table ($queryFields) VALUES ($queryMarkers)";
        $statement = $this->pdoConnection->prepare($query);
        return $statement->execute(array_values($data));
    }


    /**
     * @param int $id Id of the row to update
     * @param array $data $data to update
     */
    public function update(int $id, array $data)
    {
        //TODO : Implements SQL UPDATE request
    }
}

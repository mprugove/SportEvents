<?php

declare(strict_types = 1);

namespace App\Model;

use Core\Data\DataObject;
use Core\Data\Database;
use Exception;

abstract class AbstractModel extends DataObject
{
    protected static $tableName;

    protected static function getTableName(): string
    {
        if (static::$tableName) {
            return static::$tableName;
        }

        throw new Exception('$tableName property is not set.');
    }

    protected static function createObject(array $data): self
    {
        return new static($data);
    }

    public static function getOne(string $column, $value): self
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE {$column} = :value";

        $statement = Database::getInstance()->prepare($sql);
        $statement->bindValue('value', $value);
        $statement->execute();

        $firstRow = $statement->fetch() ?: [];
        return static::createObject($firstRow);
    }

    public static function getMultiple(string $column, $value, string $orderBy = null, array $limit = []): array
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE {$column} = :value";

        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }

        if ($limit) {
            $sql .= " LIMIT {$limit[0]}, {$limit[1]}";
        }

        $statement = Database::getInstance()->prepare($sql);
        $statement->bindValue('value', $value);
        $statement->execute();

        $models = [];
        while ($row = $statement->fetch())
        {
            $models[] = static::createObject($row);
        }

        return $models;
    }

    public static function getAll(string $orderBy = null, array $limit = []): array
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName}";

        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }

        if ($limit) {
            $sql .= " LIMIT {$limit[0]}, {$limit[1]}";
        }

        $statement = Database::getInstance()->prepare($sql);
        $statement->execute();

        $models = [];
        while ($row = $statement->fetch()) {
            $models[] = static::createObject($row);
        }

        return $models;
    }

    public static function insert($data)
    {
        $tableName = static::getTableName();

        $columns = [];
        $values = [];
        foreach (array_keys($data) as $column) {
            $columns[] = $column;
            $values[] = ":{$column}";
        }

        $columnsString = implode(', ', $columns);
        $valuesString = implode(', ', $values);

        $sql = "INSERT INTO {$tableName} ($columnsString) VALUES ($valuesString)";

        $db = Database::getInstance();

        $statement = $db->prepare($sql);
        $statement->execute($data);

        return $db->lastInsertId(static::getTableName());
    }

    public static function update($data, string $key, string $value)
    {
        $tableName = static::getTableName();

        $columns = [];
        foreach (array_keys($data) as $column) {
            $columns[] = $column . " = :{$column}";
        }

        $columnsString = implode(', ', $columns);

        $sql = "UPDATE {$tableName} SET {$columnsString} WHERE {$key} = {$value}";

        $db = Database::getInstance();

        $statement = $db->prepare($sql);
        $statement->execute($data);
    }

    public static function delete(string $column, $value)
    {
        $tableName = static::getTableName();
        $sql = "DELETE FROM {$tableName} WHERE {$column} = :value";

        $statement = Database::getInstance()->prepare($sql);
        $statement->bindValue('value', $value);
        $statement->execute();
    }
}

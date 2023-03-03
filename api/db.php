<?php


class db
{

    private $conn;

    function __construct()
    {
        $dbuser = 'root';
        $dbpass = '';
        $dbname = 'ct_site';
        $dbhost = 'localhost';

        try {
            $con = new PDO("mysql:dbhost={$dbhost};dbname={$dbname}", $dbuser, $dbpass, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8;SET time_zone = 'Asia/Bangkok'"]);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conn = $con;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    function select_all($table, array $field_arr)
    {
        $sql = 'SELECT ' . implode(',', $field_arr) . ' FROM ' . $table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    function select_fetch($table, array $select_field_arr, array $where_arr, array $value_arr)
    {
        $sql = 'SELECT ' . implode(', ', $select_field_arr) . ' FROM ' . $table . ' WHERE ' . implode(' = ? AND ', $where_arr) . ' = ? ';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($value_arr);
        $result = $stmt->fetch();
        return $result;
    }

    function select_not_null($table, string $select_field, string $field_default)
    {
        $sql = 'SELECT ' . $select_field .  ' FROM ' . $table . ' WHERE ' . $field_default . ' IS NOT NULL';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    function select_belong(string $table, string $belong_table, string $select_field, string $on, array $where_arr, array $where_value_arr)
    {
        $sql = 'SELECT ' . $select_field . ' FROM ' . $table . ' LEFT JOIN ' . $belong_table . ' ON ' . $on . ' WHERE ' . implode(' = ? AND ', $where_arr) . ' = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($where_value_arr);
        $result = $stmt->fetch();
        return $result;
    }

    function select_join_group($table, $belong_table, $select_field, string $on, array $where_arr, array $where_value_arr)
    {
        $sql = 'SELECT ' . $select_field . ' FROM ' . $table . ' LEFT JOIN ' . $belong_table . ' ON ' . $on . ' WHERE ' . implode(' = ? AND ', $where_arr) . ' = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($where_value_arr);
        $result = $stmt->fetchAll();
        return $result;
    }

    function select_join($table, $belong_table, array $select_field, string $on)
    {
        $sql = 'SELECT ' . implode(',', $select_field) . ' FROM ' . $table . ' LEFT JOIN ' . $belong_table . ' ON ' . $on;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    function insert($table, array $field_arr, array $value_arr)
    {
        $sql_as = '';
        for ($i = 0; $i < count($field_arr); $i++) {
            if ($i == count($field_arr) - 1) {
                $sql_as .= '?';
                continue;
            }
            $sql_as .= '?,';
        }
        $sql = 'INSERT INTO ' . $table . '(' . implode(',', $field_arr) . ')' . ' VALUE (' . $sql_as . ')';
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($value_arr);
    }


    function update_where($table, array $field_arr, array $value_arr, string $where)
    {
        $sql = 'UPDATE ' . $table . ' SET ' . implode(' = ?,', $field_arr) . '= ? WHERE ' . $where . ' = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($value_arr);
        return true;
    }


    function delete_where($table, string $where)
    {
        $sql = 'DELETE FROM ' . $table . ' WHERE '.$where;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return true;
    }

    function search_data(string $table, array $field_arr, array $where_arr, array $where_value_arr)
    {
        $sql = 'SELECT ' . implode(', ', $field_arr) . ' FROM ' . $table . ' WHERE ' . implode('LIKE ?, ', $where_arr) . ' LIKE ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['%' . implode('', $where_value_arr) . '%']);
        $result = $stmt->fetchAll();
        return $result;
    }

    function dateFormat($data)
    {
        $date = date_create($data);
        $year = date_format($date, 'Y');
        $format = date_format($date, 'd-m');
        return $format.'-'.$year + 543;
    }

}

<?php 
namespace Laramus\Liberius\Models;

use Laramus\Liberius\Ancient\DBCon;

class Model extends DBCon{
    protected $table;
    protected static $tbl;
    protected static $dbhandler;
    protected static $stmt;

    public function __construct()
    {
        parent::__construct();
        self::$tbl = $this->table;
        self::$dbhandler = $this->dbh;
    }

    // prepare query
    public static function query ($query) 
    {
        $self = new static();
        self::$stmt = self::$dbhandler->prepare($query);
        
        return $self;
    }

    // bind value
    public static function bind($param, $value, $type = null) 
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = \PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = \PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = \PDO::PARAM_NULL;
                    break;
                default:
                    $type = \PDO::PARAM_STR;
            }
        }

        self::$stmt->bindValue($param, $value, $type);
    } 

    // execute value
    public static function execute()
    {
        self::$stmt->execute();
    }

    // get many data
    public static function resultSet()
    {
        self::execute();
        return self::$stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // get single data
    public static function single()
    {
        self::execute();
        return self::$stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function find($id, $datas = [])
    {
        new static;
        
        if(count($datas) > 0) {
            $datas = implode(', ', $datas);
        } else {
            $datas = "*";
        }

        $sql = "SELECT " . $datas . " FROM " . self::$tbl ." WHERE id = :id";
        self::query($sql);

        self::bind("id", $id);

        return self::single();
    }

    public static function create($datas) 
    {
        new static();

        $coloumns = implode(', ', array_keys($datas));
        $binds = ':' . implode(", :", array_keys($datas));

        $sql = "INSERT INTO " . self::$tbl . " ($coloumns) VALUES ($binds)";
        self::query($sql);

        foreach($datas as $key => $data) {
            self::bind($key, $data);
        }

        self::execute();

        // get latest data
        $lastid = self::$dbhandler->lastInsertId();
        return self::find($lastid);

    }

    public static function update($id, $datas) 
    {
        new static();

        $binds = [];
        foreach($datas as $key => $data) 
        {
            $binds[] = "$key = :$key";
        }
        
        $values = implode(', ', $binds);

        $sql = "UPDATE " . self::$tbl . " SET " . $values . " WHERE id = :id";
        self::query($sql);

        self::bind("id", $id);
        foreach($datas as $key => $data) {
            self::bind($key, $data);
        }

        self::execute();

        return self::find($id);

    }

    public static function delete($id)
    {
        try {
            new static;

            $sql = "DELETE FROM " . self::$tbl . " WHERE id = :id";

            self::query($sql);
            self::bind("id", $id);

            self::execute();

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    } 
    
}
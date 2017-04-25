<?php
namespace application;

class App
{
    private $db;

    public function __construct($server, $user, $pass, $dbname)
    {
        $this->db = mysqli_connect($server, $user, $pass, $dbname);
        return $this->db;
    }

    public function closeDb()
    {
        mysqli_close($this->db);
    }

    public function request($sql)
    {
        return mysqli_query($this->db, $sql);
    }

    public function getDb()
    {
        return $this->db;
    }
}

$app = new App("localhost", "root", '', 'Job');

//$app = new App("mysql92.1gb.ru", "gb_x_ambiense", 'f8b4ae9awp' , 'gb_x_ambiense');

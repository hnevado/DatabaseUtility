<?php 
class DatabaseUtility {

    private mysqli $mysqli;
    private int $retryCount = 3;

    public function __construct(
        private string $host = 'localhost',
        private string $db = 'database',
        private string $user = 'root',
        private string $password = 'password',  
    ) 
    {
        $this->connect($this->host, $this->user, $this->password, $this->db);
    }


    private function connect($host, $user, $password, $db) {
        $this->mysqli = new mysqli($host, $user, $password, $db);

        if ($this->mysqli->connect_error) {
            die("Error al conectar a la BD: " . $this->mysqli->connect_error);
        }
    }    

}

?>
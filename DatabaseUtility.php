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


    private function connect(string $host, string $user, string $password, string $db) : void
    {
        $this->mysqli = new mysqli($host, $user, $password, $db);

        if ($this->mysqli->connect_error) {
            $this->logError("Falló la conexión a la BD: " . $this->mysqli->connect_error);
            die("Error al conectar a la BD: " . $this->mysqli->connect_error);
        }
    }    

    public function query(string $sql, bool $lastId = false, bool $numRows = false) : bool | array {
        //Devolveremos un true o false si la sql se ejecutó correctamente
        //Si nos pide lastId y/o numRows, un array

        return [];
    }

    private function logError(string $message) : void
    { 
        //TODO - usar error_log()
    }



}

?>
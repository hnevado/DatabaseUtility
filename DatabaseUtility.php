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

    public function lanzarQuery(string $sql, bool $lastId = false, bool $numRows = false) : bool | array {
        //Devolveremos un true o false si la sql se ejecutó correctamente
        //Si nos pide lastId y/o numRows, un array

        $array = [];

        for ($i = 0; $i < $this->retryCount; $i++) {
            if ($result = $this->mysqli->query($sql)) {
                
                if (!$lastId && !$numRows)
                 return true;
                
                $array[] = true;
                
                if ($lastId)
                 $array[]=$this->mysqli->insert_id;
                
                if ($numRows)
                 $array[] = $result->num_rows;

                $result->free();

                return $array;

            } else {
                $this->logError("Error en query en el intento: ".($i+1)." - ". $this->mysqli->error);
                if ($i == $this->retryCount - 1) {
                    return false;
                }
            }
        }
       
    }

    private function logError(string $message) : void
    { 
        //https://www.php.net/manual/es/function.error-log.php
        error_log($message, 3, 'db_errors.log');
    }



}

?>
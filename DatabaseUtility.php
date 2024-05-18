<?php
class DatabaseUtility {

    private mysqli $mysqli;
    private int $retryCount = 3;

    public function __construct(
        private string $host = '',
        private string $db = '',
        private string $dbUser = '',
        private string $password = '',
    ) 
    {
        $this->connect($this->host, $this->dbUser, $this->password, $this->db);
    }


    private function connect(string $host, string $dbUser, string $password, string $db) : void
    {
        $this->mysqli = new mysqli($host, $dbUser, $password, $db);
        
        if ($this->mysqli->connect_error) {
            $this->logError("Falló la conexión a la BD: " . $this->mysqli->connect_error);
            die("Error al conectar a la BD: " . $this->mysqli->connect_error);
        }
    }    

    public function lanzarQuery(string $sql, bool $numRows = false, string $tipo="consultar") : bool | array {
     
        $tiposConsulta=['consultar','actualizar','eliminar','insertar'];

        if (!in_array($tipo,$tiposConsulta))
        {
            $this->logError("El tipo de consulta que se ha especificado en lanzarQuery no es valido: ".$tipo);
            return false;
        }
        
        for ($i = 0; $i < $this->retryCount; $i++) {
            
         try   
         { 
            if ($result = $this->mysqli->query($sql)) {
             
                if (!$numRows)
                {

                  if ($tipo === "consultar")
                    return $result->fetch_all(MYSQLI_ASSOC);
                 
                  return true;

                }
                else
                {
                    if ($tipo === "consultar")
                    {
                      $array[] = $result->fetch_all(MYSQLI_ASSOC);
                      $array[] = $result->num_rows;
                      $result->free();
                    }
                    else
                    {
                      $array[] = true;
                      $array[] = $this->mysqli->affected_rows;
                    }
  
                }

                return $array;

            } else {

                if ($i == $this->retryCount - 1) {
                    return false;
                }
            }

         } catch (Exception $e) {

            $this->logError("Error en query intento ".($i+1)." - ".$e->getMessage());
            
            if ($i == $this->retryCount - 1)
            {
              $this->logError("Error en query: se agotaron todos los intentos de ejecución sin éxito para la query ".$sql);
              return false;
            }
         }

        }
       
    }

    private function logError(string $message) : void
    { 
        //https://www.php.net/manual/es/function.error-log.php
        error_log($message."\n", 3, 'db_errors.log');
    }



}

?>
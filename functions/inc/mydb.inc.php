<?php
class mydb {
        var $id; //esto es porque devuelve un id cada vez que insertas
        var $db; // esta es la base de datos
        var $username; //este es el nombre del usuario
        var $password; //esta es la password ???? de conexion??
        var $pag; //esto es para paginar
        var $m; //array indexado por los nombres de los campos
        var $num_rows; //esta es la cantidad de columnas
        var $dump;
        var $connection;//indice de conexion a la bd
  
      // function mydb($val=0,$v2='nuevo_ciclo_fix',$v3='root',$v4=''){
       function mydb($val=0,$v2='texur',$v3='root',$v4=''){
            $this->id=$val;
            $this->db=$v2;
            $this->username=$v3;
            $this->password=$v4;
            $this->dump="D:/xampp/mysql/bin/mysqldump.exe";
            
            $this->connection = false;
        }
        function setPag($val){
                $this->pag=$val;
        }
        function getPag(){
                return $this->pag;
        }
        function setId($val){
                $this->id=$val;
        }
        function getId(){
                return $this->id;
        }
        function valor($field,$fila=0){
                return $this->m[$field][$fila];
        }
        function setDB($val){
                $this->db=$val;
        }
        function setUsername($val){
                $this->username=$val;
        }
        function setPassword($val){
                $this->password=$val;
        }
        function closeConn(){
			if($this->connection){
				mysql_close($this->connection);
				$this->connection = false;
			}
		}
        function connDB(){
          if(!$this->connection){
              $this->connection = mysql_connect("localhost",$this->username,$this->password);
              //$this->connection = mysql_connect("mysql1.000webhost.com",$this->username,$this->password);
              if(!$this->connection){
                die("Error en la Conexi�n");
              }else{
                $db = mysql_select_db($this->db,$this->connection);
                if(!$db)
			        die("BD inexistente");
              }
           }
        }
        
        function add($values,$campos,$table){
        //values=cadena con los valores a ingresar
        //campos=cadena ocn los campos de la tabla
        //table=nombre de la tabla
                $this->connDB();
                $query="INSERT INTO $table($campos) VALUES ($values)";

                $r=mysql_query($query,$this->connection);
                if(!$r){
                    die( "<br> Error al insertar registro<br>".mysql_errno($this->connection).":<br> ".mysql_error($this->connection)."<br><br> Se detecto un error en la sentencia:<br>INSERT INTO $table($campos) VALUES ($values) ");
                    $this->closeConn();
                	die();
                }else{
                    $id = mysql_insert_id($this->connection);
                }

                return $id;
        }
        function update($prkey,$values,$table){
        // values=cadena con los campos y los valores a ingresar
        // prkey=nombre del campo que es clave primaria
        // table=nombre de la tabla
                $this->connDB();
                if($prkey){
                    $query = "UPDATE $table SET $values WHERE $prkey";
                    //die($query);
                    $r=mysql_query($query,$this->connection);
                }else{
                    $r=mysql_query("UPDATE $table SET $values",$this->connection);
                }
                if (!$r){
                        die("Error al actualizar registro <br>".
                        mysql_errno($this->connection).": ".mysql_error($this->connection)."<br> UPDATE $table
                        SET $values WHERE $prkey" );
                        $this->closeConn();
                	    die();  
                }
                //mysql_close();
        }
        function del($prkey,$table){
        //prkey=nombre del campo que es clave primaria
        //table=nombre de la tabla
                $this->connDB();
                $query="DELETE FROM $table WHERE $prkey";

                $r=mysql_query($query,$this->connection);
                if(!$r){
                        die ("Error al eliminar registro <br><br>DELETE FROM $table WHERE $prkey <br>".mysql_errno($this->connection).": ".mysql_error($this->connection));
                        $this->closeConn();
                	    die();
                }else{
                        $this->id=0;
                }
               // mysql_close();
        }
        //busca un registro en particular
        function get($prkey,$campos,$table){
        //campos=cadena con los campos de la tabla
        //table=nombre de la tabla
        //prkey=nombre del campo que es clave primaria
            if ($this->id > 0){
                $this->connDB();
                $result=mysql_query("SELECT $campos FROM $table WHERE $prkey=$this->id",$this->connection);
                if (!$result){
                    die("Error al obtener registro de la tabla $tables<br>".mysql_errno($this->connection).": ".mysql_error($this->connection)."<br>La Consulta es: <br> <b>SELECT $campos FROM $tables $where $order </b>");
                    $this->closeConn();
                    die();
                }else{
                    $aux = 0;
                    while ($fields = mysql_fetch_array($result)){
                        $out[$aux++] = $fields;
                    }
                }
                    //mysql_close($this->connection);
                    return $out;
            }
        }
        //devuelve varios registros
        function consulta($sql_s){
            $out = array();
            $this->connDB();
            $result = mysql_query($sql_s,$this->connection);
            if(!$result){
                die("Error al obtener registro de la tabla $tables<br>".mysql_errno($this->connection).": ".mysql_error($this->connection)."<br>La Consulta es: <br> <b>$sql_s</b>");
                $this->closeConn();
                die();
            }else{
                ($result) ? $this->num_rows = mysql_num_rows($result) : $this->num_rows = 0;
                 $aux = 0;
                if($this->num_rows){
                    while ($fields = mysql_fetch_assoc($result)){
                        $out[$aux++] = $fields;
                        //echo print_r($fields) ."<br>";
                    }
                }
           }
           //mysql_close($this->connection);
           return $out;
       }

       function rawData($consulta){
          $this->connDB();
          $result = mysql_query($consulta,$this->connection);
          if(!$result){
            die("Error<br>".mysql_errno($this->connection).": ".mysql_error($this->connection)."<br>La Consulta es: <br> <b>$consulta</b>");
            $this->closeConn();
            die();
          }
         // $this->closeConn();
          return $result;
       }


        /**
		 * Retorna un iterador sobre el resultset de una consulta
		 * @access		 public
		 * @param		 string       $qry
		 */
        function iterate($qry){
        	require_once(dirname(__FILE__) . "/Mysql_Resultset.class.php");
    		$this->connDB();
    		$iterator = new Mysql_Resultset();
  			$iterator->iterateOn(mysql_query($qry,$this->connection));
  			return $iterator;
        }

}
?>

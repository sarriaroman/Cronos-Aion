<?php
/**
 *
 * Objeto principal de datos<br />
 * permite que la capa de datos<br />
 * pueda ser facilmente reemplazada<br />
 * sin modificaciones en las capas<br />
 * superiores.<br /><br />
 *
 * El objeto esta incompleto al dia de la fecha.<br />
 * - Funciones de Busqueda.<br />
 * - Devolucion de objetos del tipo indicado.<br />
 * - Abstraccion del tipo de DQL (Data Query Language) utilizado.<br />
 *
 * @name DataObject
 * @version 0.6.0
 * @copyright Cronos Development (R)
 * @author Román A. Sarria
 */

class DataObject {
    private $table = ""; //The table to query
    public  $id = ""; //Object id
    public  $ar_vars = array(); //Propiedades del Objeto
    private $ar_changed_vars = array(); //Propiedades modificadas
    private $ar_forbiden_vars = array('0' => 'id'); //Propiedades que no se pueden modificar
    private $connection; // Connection Object

    /**
     * Gets the registry from the database and stores them in variables
     * @param <string> $table, the table to query
     * @param <mixed> $id, the number of the registry
     */
    public function __construct($table="", $id="") {
        $this->id = $id;
        $this->table = $table;

        if( $table=="" ) die("Table and id needed to access the registry");
        //Searh in the db

        $this->connection = new Connection();
        //Search the registry
        if( $this->id != "" ) {
            $sql = "select * from $table where id = '$this->id';";
            if(!$query = $this->connection->make_request($sql)) die("Cannot query table $table ".mysql_error());
            $fields = mysql_num_fields($query);
            $data = mysql_fetch_array($query);
            for($i=0;$i<$fields;$i++) {
                $this->ar_vars[mysql_field_name($query, $i)] =  $data[$i];
            }
            mysql_free_result($query);

        } else {
            $sql = "select * from {$table};";

            if(!$query = $this->connection->make_request($sql)) die("Cannot query table $table ".mysql_error());

            $fields = mysql_num_fields($query);

            for($i=0;$i<$fields;$i++) {
                $this->ar_vars[mysql_field_name($query, $i)] =  "";
            }
            mysql_free_result($query);
        }

    }

    /**
     * Magic method, finds the variable an sets it value. If there is a user defined method for that variable, then
     * calls it.
     * @param <mixed> $property to set
     * @param <mixed> $value for the property
     * @return nothing
     */
    private function __set($property, $value) {
        //Compruebo si la propiedad existe
        if(!array_key_exists($property, $this->ar_vars)) die("Inexistent property '$property'!. __set()");

        //Llamamos al método sólo para las variables permititdas
        if(in_array($property, $this->ar_forbiden_vars, true))
            die("Value '".$value."' forbiden for property ".$property."");

        if(method_exists($this, "set".$property)) {
            //return call_user_func_array("set".$property, &$this, array($value));
        }
        else {
            $this->ar_changed_vars[$property] = $value;
        }

    }

    /**
     * Same as __set
     * @param <string> $property
     * @return nothing
     */
    private function __get($property) {

        //Compruebo si la propiedad existe
        if(!array_key_exists($property, $this->ar_vars)) die("Inexistent property '$property'!. __get()");

        if(method_exists($this, "get".$property)) {
            //return call_user_func("get".$property, &$this);
        }
        else {
            //Si la variable ha cambiado, devuelvo el valor m?s actualizado
            if(!array_key_exists($property, $this->ar_changed_vars)) return $this->ar_vars[$property];

            return $this->ar_changed_vars[$property];
        }

    }

    /**
     *
     * The Save method, save or update the data of the Object
     *
     * This method do a die if the query is wrong
     * This make better security for data.
     * 
     * @return true
     *
     */
    public function save() {
        if( $this->id == "" ) {
            
            $xSQL = "INSERT INTO $this->table (";

            foreach($this->ar_changed_vars as $property => $value) {

                $this->ar_vars[$property] = $this->ar_changed_vars[$property];

                $xProperties .= $property . ", ";
                $xValues .= "'{$value}', ";
            }
            //Quito la ultima coma
            $xProperties = substr($xProperties, 0, -2);
            $xValues = substr($xValues, 0, -2);

            $xSQL .= $xProperties . ") VALUES (" . $xValues . ")";

            if(!$query = $this->connection->make_request($xSQL)) die("Unable to update the object! ".mysql_errno().": ".mysql_error());

            // Asignamos el id si el mismo es autoincremental y dejamos
            // el objeto preparado para actualizar.

            if( $this->get_last_ID() ) $this->id = $this->get_last_ID ();

            return $query;

        } else {
            //Método que se encarga de actualizar las propiedades del objeto y escribir en la DB
            //Si hay cambios sin actualizar, los actualizo

            $xSQL = "UPDATE $this->table SET ";

            foreach($this->ar_changed_vars as $property => $value) {

                $this->ar_vars[$property] = $this->ar_changed_vars[$property];
                $xSQL .= $property." = '".$value."', ";
            }
            //Quito la ultima coma
            $xSQL = substr($xSQL, 0, -2)." WHERE id = '".$this->id."';";

            if(!$query = $this->connection->make_request($xSQL)) die("Unable to update the object! ".mysql_errno().": ".mysql_error());

            return $query;
        }
    }

    /**
    * Get the last ID inserted on a table.
    */
    function get_last_ID() {
        return $this->connection->get_last_ID();
    }

    /**
     * This function delete the row associated to the object
     *
     * @return <type>
     */
    public function delete() {
        if( $this->id != "" ) {
            $xSQL = "DELETE FROM " . $this->table . " WHERE id = '" . $this->id . "';";

            if( ($query = $this->connection->delete_data( $xSQL ) ) ) die("Unable to update the object! ".mysql_errno().": ".mysql_error());

            return $query;
        }
    }

}

?>

<?php
class MySQLi_conexion {
    /**
    * MySQL server hostname
    * @access private
    * @var string
    */
    var $host;

    /**
    * MySQL username
    * @access private
    * @var string
    */
    var $dbUser;

    /**
    * MySQL user's password
    * @access private
    * @var string
    */
    var $dbPass;

    /**
    * Name of database to use
    * @access private
    * @var string
    */
    var $dbName;

    /**
    * MySQL Resource link identifier stored here
    * @access private
    * @var string
    */
    var $dbConn;

    /**
    * Stores error messages for connection errors
    * @access private
    * @var string
    */
    var $connectError;

    /**
    * MySQL constructor
    * @param string host (MySQL server hostname)
    * @param string dbUser (MySQL User Name)
    * @param string dbPass (MySQL User Password)
    * @param string dbName (Database to select)
    * @access public
    */
	
	var $transaccion;
	
    function __construct () {
		/*
        $host = 'localhost';
        $dbUser = 'root';
        $dbPass = '12345678';        
        $dbName = 'vendimia';   
        */

        
        $host = 'localhost';
        $dbUser = 'pymeauoh_test';
        $dbPass = '123456789';        
        $dbName = 'pymeauoh_vendimia';   
        


        

        $this->host=$host;
        $this->dbUser=$dbUser;
        $this->dbPass=$dbPass;
        $this->dbName=$dbName;
        $this->connectToDb();
    }
	
    /**
    * Establishes connection to MySQL and selects a database
    * @return void
    * @access private
    */
    function connectToDb ()
	{
        // Make connection to MySQL server
        if (!$this->dbConn = mysqli_connect($this->host,
                                      $this->dbUser,
                                      $this->dbPass)) {
            trigger_error('Could not connect to server');
            $this->connectError=true;
            //mysql_set_charset('utf8');
        // Select database
        }         
        else if ( !@mysqli_select_db($this->dbConn,$this->dbName) ) {
            trigger_error('Could not select database');
            $this->connectError=true;
        }
    }
	
	function Transaccion()
	{
		$this->transaccion = new Transaccion($this->dbConn);
	}
	
    /**
    * Checks for MySQL errors
    * @return boolean
    * @access public
    */
    function isError ()
	 {
        if ( $this->connectError )
            return true;
        $error=mysql_error ($this->dbConn);
        if ( empty ($error) )
            return false;
        else
            return true;
    }

    /**
    * Returns an instance of MySQLResult to fetch rows with
    * @param $sql string the database query to run
    * @return MySQLResult
    * @access public
    */
    function query($sql)
	{
        //if (!$queryResource=mysqli_query($sql,$this->dbConn))
        if (!$queryResource=mysqli_query($this->dbConn,$sql))
		{
				trigger_error ('Query failed: '.mysql_error($this->dbConn).' SQL: '.$sql);
		}            
        return new MySQLiResult($this,$queryResource);
    }
	
	
	
	
}//end class mysql

/**
* MySQLResult Data Fetching Class
* @access public
* @package SPLIB
*/
class MySQLiResult 
{
    /**
    * Instance of MySQL providing database connection
    * @access private
    * @var MySQL
    */
    var $mysql;

    /**
    * Query resource
    * @access private
    * @var resource
    */
    var $query;

    /**
    * MySQLResult constructor
    * @param object mysql   (instance of MySQL class)
    * @param resource query (MySQL query resource)
    * @access public
    */
    function MySQLiResult( $mysql,$query)
	{
        $this->mysql=& $mysql;
        $this->query=$query;
    }

    /**
    * Fetches a row from the result
    * @return array
    * @access public
    */
    function fetch () 
	{
        if ( $row=mysqli_fetch_array($this->query,MYSQL_ASSOC) )
		{
            return $row;
        } else if ( $this->size() > 0 ) 
		{
            mysqli_data_seek($this->query,0);
            return false;
        } else 
		{
            return false;
        }
    }//end fetch
	
	function fetchRow()
	{
		 if ( $row=mysqli_fetch_row($this->query) )
		{
            return $row;
        } else if ( $this->size() > 0 ) 
		{
            mysqli_data_seek($this->query,0);
            return false;
        } else 
		{
            return false;
        }
	}//end fetchRow
	

    /**
    * Returns the number of rows selected
    * @return int
    * @access public
    */
    function size () 
	{
        return mysqli_num_rows($this->query);
    }
    /**
    * Returns the number of rows affected
    * @return int
    * @access public
    */	
	 function affectedRows ()
	 {
        return mysqli_affected_rows($this->mysql->dbConn);
    }

    /**
    * Returns the ID of the last row inserted
    * @return int
    * @access public
    */
    function insertID () 
	{
        return mysqli_insert_id($this->mysql->dbConn);
    }
    
    /**
    * Checks for MySQL errors
    * @return boolean
    * @access public
    */
    function isError ()
	{
        return mysqli_error($this->mysql->dbConn);
    }
}//end mysqlResult

/**********************************************************************************/
/* Transacciones con PHP - MYSQL */
/**********************************************************************************/

class Transaccion/* Nombre de la clase */
{
	
	private $Cnn; /* Variable de conexxion */
	
	/****************************************/
	function Transaccion($Con)
	{
		//mysql_disconnect($this->Cnn); /* Desconecta la conexion a la BD */
		$this->Cnn=$Con;
		//
	}
	
	/****************************************/
	function begin()
	{
		mysql_query("BEGIN",$this->Cnn); /* Abre la transaccion */
	}
	
	/****************************************/
	function rollback()
	{
		mysql_query("ROLLBACK",$this->Cnn); /* Deshace la transaccion */
	}
	
	/****************************************/
	function commit()
	{
		mysql_query("COMMIT ", $this->Cnn); /* Ejecuta la transaccion */
	}
}//end Class

?>
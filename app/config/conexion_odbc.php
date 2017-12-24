<?php
class Odbc_conexion {
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
    * DNS del sistema
    * @access private
    * @var string
    */
    var $dns;

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
    function __construct ($datos = array()) 
    {

        /* CONEXION PRODUCCION*/
        
        $dns    = 'FMXSQL';
        //$dns    = 'FMXPRUEBAS';
        $host   = '192.168.0.23';         
        $dbUser = 'adminsif';        
        $dbPass = 'f1nc4m3x?';        
        $dbName = 'SIF';
        

        $this->dns    = $dns;
        $this->host   = $host;
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
        $this->dbName = $dbName;
        $this->connectToDb();
    }	
    /**
    * Establishes connection to MySQL and selects a database
    * @return void
    * @access private
    **/
    function connectToDb ()
	{
        if(!$this->dbConn = odbc_connect ( $this->dns, $this->dbUser, $this->dbPass))
        {
            trigger_error('No es posible conectarse al servidor ');
            $this->connectError=true;
        } 
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
        $error = odbc_error ($this->dbConn);
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
        try
        {
            if (!$queryResource = odbc_do($this->dbConn,$sql))
    		{
    			trigger_error ('Query failed: '.mysql_error($this->dbConn).' SQL: '.$sql);
    		}

            return new OdbcResult($this,$queryResource);
        }
        catch (Exception $e) 
        {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
    }
    /*  FUNCIONES PARA  QUERY 
    function query($sql)
    {
        try
        {
            if (!$queryResource=sqlsrv_query($this->dbConn,$sql))
            {
                if( ($errors = sqlsrv_errors() ) != null) 
                {
                    foreach( $errors as $error ) 
                    {
                        $data['sql_estado'] = $error['SQLSTATE']; 
                        $data['codigo']     = $error['code']; 
                        $data['mensaje']    = str_replace("'",'*', $error[ 'message']);
                    }
                }
            }
            else
            {
                $data['sql_estado'] = 0 ;
                $data['codigo']     = 0 ;
                $data['mensaje']    = '';
            } 

            return $data;                                     
        } 
        catch (Exception $e) 
        {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
    }
    */



}//end class ODBC


/**
* MySQLResult Data Fetching Class
* @access public
* @package SPLIB
*/
class OdbcResult 
{
    /**
    * Instance of MySQL providing database connection
    * @access private
    * @var MySQL
    */
    var $odbc;

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
    function __construct( $odbc,$query)
	{
        $this->odbc = &$odbc;
        $this->query=$query;
    }
    /**
    * Fetches a row from the result
    * @return array
    * @access public
    */

    function result ()
    {

    }

    function fetch () 
	{
        if ( $row=odbc_fetch_array($this->query,0) )
		{
            return $row;
        }         
		{
            return false;
        }
    }//end fetch
	
	function fetchAll()
	{
        $datos = array(); 

        while($rec = odbc_fetch_array($this->query,0))
        {   
            $datos[] = $rec; 
        }   

        return $datos; 
	}//end fetchRow
	

    /**
    * Returns the number of rows selected
    * @return int
    * @access public
    */
    function size () 
	{
        return odbc_num_rows($this->query);
    }
    /**
    * Returns the number of rows affected
    * @return int
    * @access public
    */	
	 function affectedRows ()
	 {
        return sybase_affected_rows($this->sybase->dbConn);
    }

    /**
    * Returns the ID of the last row inserted
    * @return int
    * @access public
    */
    function insertID () 
	{
        //return mysqli_insert_id($this->sybase->dbConn);
    }
    
    /**
    * Checks for MySQL errors
    * @return boolean
    * @access public
    */
    function isError ()
	{
        return odbc_error($this->odbc->dbConn);
    }
}//end ODBC Result


?>
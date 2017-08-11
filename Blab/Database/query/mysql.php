<?php

namespace Blab\Database\Query;

use Blab\Database;
use Blab\Database\Exception;
use Blab\Libs\ArrayMethods;

class Mysql extends Database\Query
{
    /**
     * @var object
     */

    protected $_results;

    /**
     * Get All results
     *
     * @return object 
     */

    public function results(){

        $sql = $this->_prepareSelect();

        //$sql = "SELECT * FROM users WHERE username = ?";
        $bindValues = $this->_bindValues;
        $query = $this->connector->execute($sql,$bindValues);

       //print_r($query->getResults());
        
        if ($query === false){

            $error = $this->connector->lastError;
            //print_r($error);
            throw new Exception\Sql("There was an error with your SQL query.");
        }
          
        if($query->getAffectedRows()){

            return $query->getResults();
        }
        
    }

    /**
     * Get Single Result
     *
     * @return object
     */

    public function firstResult(){

        return $this->results()[0];
    }

    /**
     * Check data exists
     *
     * @return bool
     */

    public function exists($table,$where=array()){

        if (count($where)===3) {
            
            $operators = array('=','<','>','<=','>=','<>','!=');

            $field = $where[0];
            $operator = $where[1];
            $value[] = $where[2];

            if (in_array($operator, $operators)) {
                
                $sql = "SELECT * FROM {$table} WHERE {$field} {$operator} ?";
                $query = $this->connector->execute($sql,$value);
                if ($query->getAffectedRows()) {
                    $this->_results = $query->getResults();
                    return $query;

                }
            }
        }

        return false;

    }
    /**
     * Count table records from database
     *
     * @return int
     */

    public function countRows(){

        $sql = $this->_prepareSelect();

        $bindValues = $this->_bindValues;
        $query = $this->connector->execute($sql,$bindValues);
        
        if ($query === false){

            $error = $this->connector->lastError;

            throw new Exception\Sql("There was an error with your SQL query.");
        }
          
        if($query->getAffectedRows()){

            return $query->getAffectedRows();
        }
        
    }
}
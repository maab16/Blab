<?php

namespace Blab\Database;

use Blab\Libs\Core as Core;
use Blab\Libs\ArrayMethods as ArrayMethods;
use Blab\Database\Exception as Exception;

class Query extends Core
{
    /**
     * @var PDO
     * @readwrite
     */
    protected $_connector;
    
    /**
     * @var string
     * @read
     */
    protected $_table;
    
    /**
     * @var int
     * @read
     */
    protected $_limit;
    
    /**
     * @var int
     * @read
     */
    protected $_offset;
    
    /**
     * @var string
     * @read
     */
    protected $_order;
    
    /**
     * @var string
     * @read
     */
    protected $_direction;
    
    /**
     * @var array
     * @read
     */
    protected $_join = [];

    /**
     * @var array
     * @read
     */
    protected $_fields = [];
    
    /**
     * @var array
     * @read
     */
    protected $_where = [];

    /**
     * @var array
     * @read
     */

    protected $_bindValues = [];
    
    protected function _getExceptionForImplementation($method)
    {
        return new \Exception("{$method} method not implemented");
    }

    /**
     * Sanitize Input Data
     *
     * @param  string    $value
     * @return string
     */
                
    protected function _quote($value)
    {
        if (is_string($value))
        {
            $escaped = $this->connector->escape($value);
            return "'{$escaped}'";
        }
        
        if (is_array($value))
        {
            $buffer = array();
            
            foreach ($value as $i)
            {
                array_push($buffer, $this->_quote($i));
            }
    
            $buffer = implode(", ", $buffer);
            return "({$buffer})";
        }
        
        if (is_null($value))
        {
            return "NULL";
        }
        
        if (is_bool($value))
        {
            return (int) $value;
        }
        
        return $this->connector->escape($value);
    }

    /**
     * Prepare SQL Query for SELECT Statement
     *
     * @return string
     */
    
    protected function _prepareSelect()
    {
        if (empty($this->_table))
        {
            
            throw new Exception\Argument("Table Name Invalid ");
        }

        $fields = array();
        $where = $order = $limit = $join = "";
        // %s is formate symbole those are used by sprintf()
        $template = "SELECT %s FROM %s %s %s %s %s";

        if (!empty($this->_fields)) {

            $fields = implode(" , " , $this->_fields);
        }else {

            $fields = "*";
        }
        
        if (!empty($this->_join))
        {
            $join = implode(" ", $this->_join);
        }
        
        if (!empty($this->_where))
        {
            $this->_where = implode(" AND " , $this->_where);
            $where = "WHERE {$this->_where}";
        }
        
        if (!empty($this->_order))
        {
            $order = "ORDER BY {$this->_order} {$this->_direction}";
        }
        
        if (!empty($this->_limit))
        {
            $_offset = $this->_offset;
            
            if ($_offset)
            {
                $limit = "LIMIT {$_offset} , {$this->_limit} ";
            }
            else
            {
                $limit = "LIMIT {$this->_limit}";
            }
        }
        
       return sprintf($template, $fields, $this->_table, $join, $where, $order, $limit);
    }

    /**
     * Prepare SQL Query for SELECT Statement
     *
     * @param  array    $data
     * @return string
     */
    
    protected function _prepareInsert($data)
    {
        if(!is_array($data) && !empty($data))
        {
            throw new Exception\Argument("Invalid argument . Argument must be an array");
        }

        if (empty($this->_table)) 
        {
            
            throw new Exception\Argument("Table Name Invalid ");
        }

        $template = "INSERT INTO `%s` (%s) VALUES (%s)";
        
        $fields = $values = [];
        foreach ($data as $field => $value) 
        {
            
            $fields[]= "`{$field}`";
            $values[]= "?";
            $this->_bindValues[] = $value;
        }

        $fields = implode(" , ", $fields);
        $values = implode(" , ", $values);

       return sprintf($template, $this->_table, $fields, $values);
    }

    /**
     * Prepare SQL Query for UPDATE Statement
     *
     * @param  array    $data
     * @return string
     */
    
    protected function _prepareUpdate($data)
    {
        if(!is_array($data) || empty($data))
        {

            throw new Exception\Argument("Invalid argument . Argument must be an array");
        }

        if (empty($this->_table)) 
        {
            
            throw new Exception\Argument("Table Name Invalid ");
        }

        $fields = $values = [];
        $where = $limit = "";

        $template = "UPDATE %s SET %s %s %s";

        foreach ($data as $field => $value)
        {
            $fields[]= "{$field} = ?";
            $values[] = $value;
        }

        $fields = implode(" , ", $fields);

        // Push $values into _bindValues array first
        if (!empty($values)) 
        {

            $i = count($values);

            while ($i) 
            {
                array_unshift($this->_bindValues,$values[$i-1]);
                $i--;
            }
        }
        
        if (!empty($this->_where))
        {
            $this->_where = implode(" AND " , $this->_where);
            $where = "WHERE {$this->_where}";
        }
        
        if (!empty($this->_limit))
        {
            $_offset = $this->offset;
            $limit = "LIMIT {$this->_limit} {$_offset}";
        }

        return sprintf($template, $this->_table, $fields, $where, $limit);
    }

    /**
     * Prepare SQL Query for DELETE Statement
     *
     * @return string
     */
    
    protected function _prepareDelete()
    {
        if (empty($this->_table)) {
            
            throw new Exception\Argument("Table Name Invalid ");
        }
        $table = $this->_table;
        $where = $limit ="";
        $template = "DELETE FROM %s %s %s";
    
        if (!empty($this->_where))
        {
            $this->_where = implode(" AND " , $this->_where);
            $where = "WHERE {$this->_where}";
        }
        
        if (!empty($this->_limit))
        {
            $_offset = $this->offset;
            $limit = "LIMIT {$this->_limit} {$_offset}";
        }
        
        return sprintf($template, $table, $where, $limit);
    }

    /**
     * Check given array associate or not
     *
     * @param  array    $arr
     * @return bool
     */

    public function isAssoc(array $arr){

        if (array() === $arr) return false;
        return (array_keys($arr) !== range(0, count($arr) - 1)) ? true : false;
    }

    /**
     * Insert data into database
     *
     * @param  array    $data
     * @return int
     */

    public function insert($data){

        echo $sql = $this->_prepareInsert($data);

        $result = $this->_connector->execute($sql,$this->_bindValues); 
        
        if ($result === false)
        {
            throw new Exception\Sql();
        }

        return $result->getLastInsertId();
    }

    /**
     * Update data
     *
     * @param  array    $data
     * @return int
     */

    public function update($data){

        $sql = $this->_prepareUpdate($data);

        $result = $this->_connector->execute($sql,$this->_bindValues);
        
        if ($result === false)
        {
            throw new Exception\Sql();
        }

        return $result->getAffectedRows();
    }

    /**
     * Delete data from database
     *
     * @return int
     */
    
    public function delete()
    {
        $sql = $this->_prepareDelete();
        $result = $this->_connector->execute($sql,$this->_bindValues);
        
        if ($result === false)
        {
            throw new Exception\Sql();
        }
        
        return $result->getAffectedRows();
    }

    /**
     * @param  string   $table
     * @param  array    $fields
     * @return object  $this
     */
    
    public function from($table, $fields = [])
    {
        if (empty($table))
        {
            throw new Exception\Argument("Invalid argument");
        }
        
        $this->_fields = [];
        $this->_table = $table;
        
        if (!empty($fields) && $this->isAssoc($fields))
        {
            foreach ($fields as $field => $value) 
            {

                if (is_string($field)) 
                {
                    $this->_fields[] = "{$field} AS ?";

                    $this->_bindValues[] = $value; 
                }
                else
                {
                    $this->_fields[] = "{$value}";
                }
  
            }        
        }
        else
        {
            foreach ($fields as $field) 
            {

               $this->_fields[] = "{$field}"; 
            }
        }
        
        return $this;
    }

    /**
     * @param  string   $table
     * @param  array    $fields
     * @return object  $this
     */

    public function into($table, $fields = [])
    {
        if (empty($table))
        {
            throw new Exception\Argument("Invalid argument");
        }
        
        $this->_table = $table;
        
        if (!empty($fields))
        {
            foreach ($fields as $field => $value) 
            {

               if (is_string($field)) 
                {
                    $this->_fields[] = "{$field} AS ?";

                    $this->_bindValues[] = $value; 
                }
                else
                {
                    $this->_fields[] = "{$value}";
                }  
            }        
        }
        
        return $this;
    }

    /**
     * Prepare Join Query
     *
     * @param  string     $type
     * @param  string   $join
     * @param  string   $on
     * @param  array    $fields
     * @return object  $this
     */
    
    public function join($type="INNER",$join, $on, $fields = [])
    {
        if (empty($join))
        {
            throw new Exception\Argument("Invalid argument");
        }
        
        if (empty($on))
        {
            throw new Exception\Argument("Invalid argument");
        }

        if (!empty($fields)) 
        {
            
            foreach ($fields as $field => $value) 
            {
                $this->_fields[] = "{$field} AS ?";

                $this->_bindValues[] = $value;
                    
            }
        }
        
        $this->_join[] = "{$type} JOIN {$join} ON {$on}";
        
        return $this;
    }

    /**
     * Prepare LIMIT for SQL
     *
     * @param  int   $limit
     * @param  int    $page
     * @return object  $this
     */
    
    public function limit($limit, $page = 1)
    {
        if (empty($limit))
        {
            throw new Exception\Argument("Invalid argument");
        }
        
        $this->_limit = $limit;
        $this->_offset = $limit * ($page - 1);
        
        return $this;
    }

    /**
     * Prepare Order for SQL
     *
     * @param  array    $order
     * @return object  $this
     */
    
    public function order($order=[])
    {
        $orderBy = "";
        $orderDirection = "";

        if (!empty($order))
        {
            foreach ($order as $key => $value) 
            {
                $orderBy = $key;
                $orderDirection = $value;
            }
        }
       
        $this->_order = $orderBy;
        $this->_direction = $orderDirection;
        
        return $this;
    }

    /**
     * WHERE Clause
     *
     * @param  array   $where
     * @param  string  $oparator
     * @param  string  $joint
     * @return object  $this
     */
    
     public function where($where=array(),$oparator = "",$joint="AND")
    {

        if(!is_array($where)){

            throw new Exception\Argument("Invalid argument . First argument must be an array");
        }

        if (empty($where)) {
            
            $this->_where = array();
            return $this;
        }

        if (!empty($oparator)) {
            
            $operators = array('=','<','>','<=','>=','<>','!=');

            if (in_array($oparator,$operators)) {
               
                foreach ($where as $field => $value) {
                    
                    $this->_where[] = "{$field} {$oparator} ?";
                    $this->_bindValues[] = $value;;
                }
            }
        }else{

            foreach ($where as $field => $value) {
                    
                $this->_where[] = "{$field} = ?";
                $this->_bindValues[] = $value;
            }
        }

        $this->_where[] = implode(" {$joint} ", $this->_where);
        array_splice($this->_where,0,-1);
        
        return $this;
    }

    /**
     * WHERE Clause with AND
     *
     * @param  array   $where
     * @param  string  $oparator
     * @return object  $this
     */

    public function andWhere($where=array(),$oparator="")
    {
        if(!is_array($where)){

            throw new Exception\Argument("Invalid argument . First argument must be an array");
        }

        if (empty($where)) {
            
            $this->_where = array();
            return $this;
        }

        if (!empty($oparator)) {
            
            $operators = array('=','<','>','<=','>=','<>','!=');

            if (in_array($oparator,$operators)) {
               
                foreach ($where as $field => $value) {
                    
                    $this->_where[] = "{$field} {$oparator} ?";
                    $this->_bindValues[] = $value;;
                }
            }
        }else{

            foreach ($where as $field => $value) {
                    
                $this->_where[] = "{$field} = ?";
                $this->_bindValues[] = $value;
            }
        }

        $this->_where[] = implode(' AND ', $this->_where);
        array_splice($this->_where,0,-1);
        
        return $this;
    }

    /**
     * WHERE Clause with OR
     *
     * @param  array   $where
     * @param  string  $oparator
     * @return object  $this
     */

    public function orWhere(array $where=array(),$oparator="")
    {
        if(!is_array($where)){

            throw new Exception\Argument("Invalid argument . First argument must be an array");
        }
        if (empty($where)) {
            
            $this->_where = array();
            return $this;
        }


        if (!empty($oparator)) {
            
            $operators = array('=','<','>','<=','>=','<>','!=');

            if (in_array($oparator,$operators)) {
               
                foreach ($where as $field => $value) {
                    
                    $this->_where[] = "{$field} {$oparator} ?";
                    $this->_bindValues[] = $value;;
                }
            }
        }else{

            foreach ($where as $field => $value) {
                    
                $this->_where[] = "{$field} = ?";
                $this->_bindValues[] = $value;
            }
        }

        $this->_where[] = implode(' OR ', $this->_where);
        array_splice($this->_where,0,-1);
        
        return $this;
    }
}
<?php
/* Copyright (C) 2013 WebSystem Development Team - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Brian Floersch <gh123man@gmail.com>
 */

include_once './utils/sql_util.php';

/**
 * This is an "as needed" database access object. all variables are automaticly
 * kept up to date in the database.
 */
class Project {
    
    //=-=-=-=-=-=-=-=-=-=-=-=  Member variables  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=//
    
    public static $tableName = "Projects"; //name of table in database
    public static $maxNameLen = 80;
    public static $maxDescriptionLen = 500;

    
    //account data          //boolean data changed
    private $ID;
    private $owner;         private $c_owner;
    private $name;          private $c_name;
    private $description;   private $c_description;
    private $deadline;      private $c_deadline;
    private $time;          private $c_time;
    
    
    //=-=-=-=-=-=-=-=-=-=-=-=  Constructors  -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//
    
    public function __construct($ID, $owner = null, $name = null, $description = null, $deadline = null, $time = null) {
        $this->ID = $ID;
        $this->owner = $owner;              $this->c_owner = false;
        $this->description = $description;  $this->c_description = false;
        $this->deadline = $deadline;        $this->c_deadline = false;
        $this->time = $time;                $this->c_time = false;
        
    }
    

    //=-=-=-=-=-=-=-=-=-=-=-=  Destructor  -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//
    
    public function __destruct() {
        $this->flush();
    }
    
    //=-=-=-=-=-=-=-=-=-=-=-=  Setters  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-//
    
    public function setOwner($owner) {
        $this->owner = $owner;
        $this->c_owner = true;
    }
    public function setName($hash) {
        $this->name = $name;
        $this->c_name = true;
    }
    public function setDescription($setdescription) {
        $this->setdescription = $setdescription;
        $this->c_setdescription = true;
    }
    public function setDeadline($salt) {
        $this->deadline = $deadline;
        $this->c_deadline = true;
    }
    public function setTime($time) {
        $this->time = $time;
        $this->c_time = true;
    }
    


    //=-=-=-=-=-=-=-=-=-=-=-=  Getters  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-//
    
    public function getID() {
        return $this->ID;
    }
    public function getowner() {
        if ($this->owner == null) {
            $this->owner = $this->dbSelect('owner', Project::$tableName);
        }
        return $this->owner;
    }
    public function getName() {
        if ($this->name == null) {
            $this->name = $this->dbSelect('name', Project::$tableName);
        }
        return $this->hash;
    }
    public function getdescription() {
        if ($this->description == null) {
            $this->description = $this->dbSelect('description', Project::$tableName);
        }
        return $this->description;
    }
    public function getDeadline() {
        if ($this->deadline == null) {
            $this->deadline = $this->dbSelect('deadline', Project::$tableName);
        }
        return $this->hash;
    }
    public function getTime() {
        if ($this->time == null) {
            $this->time = $this->dbSelect('time', Project::$tableName);
        }
        return $this->time;
    }
    
    //=-=-=-=-=-=-=-=-=-=-=-=  SQL Access Functions  =-=-=-=-=-=-=-=-=-=-=-=-=-//
    
    /**
     * selects one item from this post in the database
     */
    protected function dbSelect($what, $where) {
        $query = $GLOBALS['currentConnection']->prepare('SELECT ' . $what . ' FROM ' . $where . ' WHERE ID = :ID');
        $query->execute(array(':ID' => $this->getID()));
        $query->setFetchMode(PDO::FETCH_ASSOC); 
        $results = $query->fetch();
        return $results["$what"];
    }
    
    /**
     * updates a given column in the database
     */
    protected function update($col, $arg, $where) {
        $query = $GLOBALS['currentConnection']->prepare('UPDATE ' . $where . ' SET ' . $col . ' = :data WHERE ID = :ID');
        return ($query->execute(array(':data' => $arg, ':ID' => $this->getID())));
    }
    
    /**
     * inserts a new feed into the database
     */
    protected function insertProject($ID, $owner, $name, $description, $deadline, $time) {
        $query = $GLOBALS['currentConnection']->prepare('INSERT INTO ' . Project::$tableName . ' VALUES (:ID, :owner, :name, :description, :deadline, :time)');
        return ($query->execute(array(':ID' => $ID, ':owner' => $owner, ':name' => $name, ':description' => $description, ':deadline' => $deadline, ':time' => $time)));
    }
    
    /**
     * select n items from the database for a post (required for some static functions)
     */
    public static function selectFromProject($what, $col, $arg, $where) {
        connect();
        $query = $GLOBALS['currentConnection']->prepare('SELECT ' . $what . ' FROM ' . $where . ' WHERE ' . $col . ' = :data');
        $query->execute(array(':data' => $arg));
        $query->setFetchMode(PDO::FETCH_ASSOC); 
        $results = $query->fetch();
        return $results;
    }
    

    //=-=-=-=-=-=-=-=-=-=-=-=  Core Functions  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-//
    
    /**
     * flushes changed members to the database. called on object destruction
     */
    public function flush() {
        if ($this->c_owner) {
            if ($this->update('owner', $this->owner, Project::$tableName)) {
                $this->c_owner = false;
            }
        }
        if ($this->c_name) {
            if ($this->update('name', $this->name, Project::$tableName)) {
                $this->c_name = false;
            }
        }
        if ($this->c_description) {
            if ($this->update('description', $this->description, Project::$tableName)) {
                $this->c_description = false;
            }
        }
        
        if ($this->c_deadline) {
            if ($this->update('deadline', $this->deadline, Project::$tableName)) {
                $this->c_deadline = false;
            }
        }
        if ($this->c_time) {
            if ($this->update('time', $this->time, Project::$tableName)) {
                $this->c_time = false;
            }
        }
    }
    
    /**
     * generates a new unique ID
     */
    protected function genID($user, $seed) {
        $loop = 0;
        while (true) {
            $time = time();
            $loop++;
            $ID = md5($time . $user . $seed . $loop);
            $ID = 'P' . substr($ID, 1, strlen($ID));
            
            if (!Project::projectExistsId($ID)) {
                return $ID;
            }
        }
    }
    
    //=-=-=-=-=-=-=-=-=-=-=-=  Static Functions  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-//
    
    /**
     * checks if  project exists
     */
    public static function projectExistsId($ID) {
        $results = Project::selectFromProject('ID', 'ID', $ID, Project::$tableName);
        if (isset($results['ID']) && $results['ID'] == $ID) {
            return true;
        } else {
            return false;
        }
    }
    
    
    public static function createProject($owner, $name, $description, $deadline) {
        
        if (isset($owner) && (isset($name) && (strlen($name) < Project::$maxNameLen)) && (isset($description) && (strlen($description) < Project::$maxDescriptionLen)) && isset($deadline)) {
            $ID = Project::genID($name, $owner);
            $time = time();
            return Project::insertProject($ID, $owner, $name, $description, $deadline, $time);
            
        }
        return false;
    }
    
    
    //=-=-=-=-=-=-=-=-=-=-=-=  Member Functions  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-//
    
    
    
    
    
    
}

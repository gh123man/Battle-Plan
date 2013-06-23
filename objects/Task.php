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
class Task {
    
    //=-=-=-=-=-=-=-=-=-=-=-=  Member variables  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=//
    
    public static $tableName = "Tasks"; //name of table in database
    public static $maxNameLen = 80;
    public static $maxDescriptionLen = 2000;

    
    //account data          //boolean data changed
    private $ID;
    private $parent;        private $c_parent;
    private $owner;         private $c_owner;
    private $project;       private $c_project;
    private $name;          private $c_name;
    private $description;   private $c_description;
    private $deadline;      private $c_deadline;
    private $assigned;      private $c_assigned;
    private $finished;      private $c_finished;
    private $time;          private $c_time;
    
    
    //=-=-=-=-=-=-=-=-=-=-=-=  Constructors  -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//
    
    public function __construct($ID, $parent = null, $owner = null, $project = null, $name = null, $description = null, $deadline = null, $assigned = null, $finished = null, $time = null) {
        $this->ID = $ID;
        $this->parent = $parent;            $this->c_parent = false;
        $this->owner = $owner;              $this->c_owner = false;
        $this->project = $project;          $this->c_project = false;
        $this->name = $name;                $this->c_name = false;
        $this->description = $description;  $this->c_description = false;
        $this->deadline = $deadline;        $this->c_deadline = false;
        $this->assigned = $assigned;        $this->c_assigned = false;
        $this->finished = $finished;        $this->c_finished = false;
        $this->time = $time;                $this->c_time = false;
        
    }
    

    //=-=-=-=-=-=-=-=-=-=-=-=  Destructor  -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//
    
    public function __destruct() {
        $this->flush();
    }
    
    //=-=-=-=-=-=-=-=-=-=-=-=  Setters  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-//
    
    public function setParent($parent) {
        $this->parent = $parent;
        $this->c_parent = true;
    }
    public function setOwner($owner) {
        $this->owner = $owner;
        $this->c_owner = true;
    }
    public function setProject($project) {
        $this->project = $project;
        $this->c_project = true;
    }
    public function setName($name) {
        $this->name = $name;
        $this->c_name = true;
    }
    public function setDescription($setdescription) {
        $this->setdescription = $setdescription;
        $this->c_setdescription = true;
    }
    public function setDeadline($deadline) {
        $this->deadline = $deadline;
        $this->c_deadline = true;
    }
    public function setAssigned($assigned) {
        $this->assigned = $assigned;
        $this->c_assigned = true;
    }
    public function setFinished($finished) {
        $this->finished = $finished;
        $this->c_finished = true;
    }
    public function setTime($time) {
        $this->time = $time;
        $this->c_time = true;
    }
    


    //=-=-=-=-=-=-=-=-=-=-=-=  Getters  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-//
    
    public function getID() {
        return $this->ID;
    }
    public function getParent() {
        if ($this->parent == null) {
            $this->parent = $this->dbSelect('parent', Task::$tableName);
        }
        return $this->parent;
    }
    public function getOwner() {
        if ($this->owner == null) {
            $this->owner = $this->dbSelect('owner', Task::$tableName);
        }
        return $this->owner;
    }
    public function getProject() {
        if ($this->project == null) {
            $this->project = $this->dbSelect('project', Task::$tableName);
        }
        return $this->project;
    }
    public function getName() {
        if ($this->name == null) {
            $this->name = $this->dbSelect('name', Task::$tableName);
        }
        return $this->name;
    }
    public function getDescription() {
        if ($this->description == null) {
            $this->description = $this->dbSelect('description', Task::$tableName);
        }
        return $this->description;
    }
    public function getAssigned() {
        if ($this->assigned == null) {
            $this->assigned = $this->dbSelect('assigned', Task::$tableName);
        }
        return $this->assigned;
    }
    public function getDeadline() {
        if ($this->deadline == null) {
            $this->deadline = $this->dbSelect('deadline', Task::$tableName);
        }
        return $this->deadline;
    }
    public function getFinished() {
        if ($this->finished == null) {
            $this->finished = $this->dbSelect('finished', Task::$tableName);
        }
        return $this->finished;
    }
    public function getTime() {
        if ($this->time == null) {
            $this->time = $this->dbSelect('time', Task::$tableName);
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
    protected function insertTask($ID, $parent, $project, $owner, $name, $description, $deadline, $assigned, $finished, $time) {
        $query = $GLOBALS['currentConnection']->prepare('INSERT INTO ' . Task::$tableName . ' VALUES (:ID, :parent, :owner, :project, :name, :description, :deadline, :assigned, :finished, :time)');
        return ($query->execute(array(':ID' => $ID, ':parent' => $parent,  ':owner' => $owner, ':project' => $project, ':name' => $name, ':description' => $description, ':deadline' => $deadline, ':assigned' => $assigned, ":finished" => $finished, ':time' => $time)));
    }
    
    /**
     * select n items from the database for a post (required for some static functions)
     */
    public static function selectFromTask($what, $col, $arg, $where) {
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
        if ($this->c_parent) {
            if ($this->update('parent', $this->parent, Task::$tableName)) {
                $this->c_parent = false;
            }
        }
        if ($this->c_owner) {
            if ($this->update('owner', $this->owner, Task::$tableName)) {
                $this->c_owner = false;
            }
        }
        if ($this->c_project) {
            if ($this->update('project', $this->project, Task::$tableName)) {
                $this->c_project = false;
            }
        }
        if ($this->c_name) {
            if ($this->update('name', $this->name, Task::$tableName)) {
                $this->c_name = false;
            }
        }
        if ($this->c_description) {
            if ($this->update('description', $this->description, Task::$tableName)) {
                $this->c_description = false;
            }
        }
        
        if ($this->c_deadline) {
            if ($this->update('deadline', $this->deadline, Task::$tableName)) {
                $this->c_deadline = false;
            }
        }
        if ($this->c_assigned) {
            if ($this->update('assigned', $this->assigned, Task::$tableName)) {
                $this->c_assigned = false;
            }
        }
        if ($this->c_finished) {
            if ($this->update('finished', $this->finished, Task::$tableName)) {
                $this->c_finished = false;
            }
        }
        if ($this->c_time) {
            if ($this->update('time', $this->time, Task::$tableName)) {
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
            $ID = 'T' . substr($ID, 1, strlen($ID));
            
            if (!Task::taskExistsId($ID)) {
                return $ID;
            }
        }
    }
    
    //=-=-=-=-=-=-=-=-=-=-=-=  Static Functions  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-//
    
    /**
     * checks if  task exists
     */
    public static function taskExistsId($ID) {
        $results = Task::selectFromTask('ID', 'ID', $ID, Task::$tableName);
        if (isset($results['ID']) && $results['ID'] == $ID) {
            return true;
        } else {
            return false;
        }
    }
    
    
    public static function createTask($owner, $parent, $project, $name, $description, $assigned, $deadline) {
        
        if (isset($owner) && isset($project) && (isset($name) && (strlen($name) < Task::$maxNameLen)) && (isset($description) && (strlen($description) < Task::$maxDescriptionLen)) && isset($deadline)) {
            $ID = Task::genID($name, $owner);
            $time = time();
            return Task::insertTask($ID, $parent, $project, $owner, $name, $description, $deadline, $assigned, 0, $time);
            
        }
        return false;
    }
    
    
    //=-=-=-=-=-=-=-=-=-=-=-=  Member Functions  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-//
    
    public function childrenCount() {
        $query = $GLOBALS['currentConnection']->prepare('SELECT count(*) FROM Tasks where parent = "' . $this->getID() . '"');
        
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC); 
        
        $result = $query->fetch();
        
            
        if (isset($result['count(*)']) && $result['count(*)'] > 0) {
            return $result['count(*)'];
        }
        return 0;
    }
    
    public function hasChildren() {
        return ($this->childrenCount() > 0);
    }
    
    
    public function getStatus() {
    
        //get children
        //for each child, get score
        //avg scores
        //return val
        
        if ($this->hasChildren()) {
        
            $query = $GLOBALS['currentConnection']->prepare('SELECT ID FROM Tasks where parent = "' . $this->getID() . '"');
            
            $query->execute();
            $query->setFetchMode(PDO::FETCH_ASSOC); 
            
            $count = 0;
            $sum = 0;
            
            while($result = $query->fetch()) {
                $sub = new Task($result['ID']);
                $sum += $sub->getStatus();
                $count ++;
            }
            
            return intval($sum / $count);
        
        } else {
        
            if ($this->getFinished() == 1) {
                return 100;
            } 
            return 0;
            
        }
       
    }
    
    public function getDeadlineDiff() {
        
        if ($this->getDeadline() != 0) {
            
            $diff = (($this->getDeadline() / $this->getTime()) *100);
        
        } else {
        
            return 0;
            
        }
       
    }
    
}






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
class Account {
    
    //=-=-=-=-=-=-=-=-=-=-=-=  Member variables  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=//
    
    public static $tableName = "Accounts"; //name of table in database
    public static $tableName1 = "cookieLog"; //name of table in database
    public static $serverSignKey = "potatosInSpace";

    
    //account data          //boolean data changed
    private $ID;
    private $email;         private $c_email;
    private $fname;         private $c_fname;
    private $lname;         private $c_lname;
    private $hash;          private $c_hash;
    private $salt;          private $c_salt;
    private $time;          private $c_time;
    
    private $loginStatus;
    
    
    //=-=-=-=-=-=-=-=-=-=-=-=  Constructors  -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//
    
    public function __construct($ID, $fname = null, $lname = null, $profile = null, $time = null) {
        $this->ID = $ID;
        $this->fname = $fname;          $this->c_fname = false;
        $this->lname = $lname;          $this->c_lname = false;
        $this->time = $time;            $this->c_time = false;
        
        $this->loginStatus = "";
        
    }
    

    //=-=-=-=-=-=-=-=-=-=-=-=  Destructor  -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//
    
    public function __destruct() {
        $this->flush();
    }
    
    //=-=-=-=-=-=-=-=-=-=-=-=  Setters  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-//
    
    public function setEmail($email) {
        $this->email = $email;
        $this->c_email = true;
    }
    public function setfname($fname) {
        $this->fname = $fname;
        $this->c_fname = true;
    }
    public function setlname($setlname) {
        $this->setlname = $setlname;
        $this->c_setlname = true;
    }
    public function setHash($hash) {
        $this->hash = $hash;
        $this->c_hash = true;
    }
    public function setSalt($salt) {
        $this->salt = $salt;
        $this->c_salt = true;
    }
    public function setStatus($status) {
        $this->loginStatus = $status;
    }
    public function setTime($time) {
        $this->time = $time;
        $this->c_time = true;
    }
    


    //=-=-=-=-=-=-=-=-=-=-=-=  Getters  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-//
    
    public function getID() {
        return $this->ID;
    }
    public function getEmail() {
        if ($this->email == null) {
            $this->email = $this->dbSelect('email', Account::$tableName);
        }
        return $this->email;
    }
    public function getfname() {
        if ($this->fname == null) {
            $this->fname = $this->dbSelect('fname', Account::$tableName);
        }
        return $this->fname;
    }
    public function getlname() {
        if ($this->lname == null) {
            $this->lname = $this->dbSelect('lname', Account::$tableName);
        }
        return $this->lname;
    }
    public function getHash() {
        if ($this->hash == null) {
            $this->hash = $this->dbSelect('hash', Account::$tableName);
        }
        return $this->hash;
    }
    public function getSalt() {
        if ($this->salt == null) {
            $this->salt = $this->dbSelect('salt', Account::$tableName);
        }
        return $this->salt;
    }
    public function getTime() {
        if ($this->time == null) {
            $this->time = $this->dbSelect('time', Account::$tableName);
        }
        return $this->time;
    }
    public function getStatus() {
        return $this->loginStatus;
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
    protected function insertAccount($ID, $email, $fname, $lname, $hash, $salt, $time) {
        $query = $GLOBALS['currentConnection']->prepare('INSERT INTO ' . Account::$tableName . ' VALUES (:ID, :email, :fname, :lname, :hash, :salt, :time)');
        return ($query->execute(array(':ID' => $ID, ':email' => $email, ':fname' => $fname, ':lname' => $lname, ':hash' => $hash, ':salt' => $salt, ':time' => $time)));
    }
    
    /**
     * select n items from the database for a post (required for some static functions)
     */
    public static function selectFromAccount($what, $col, $arg, $where) {
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
        if ($this->c_email) {
            if ($this->update('email', $this->email, Account::$tableName)) {
                $this->c_email = false;
            }
        }
        if ($this->c_fname) {
            if ($this->update('fname', $this->fname, Account::$tableName)) {
                $this->c_fname = false;
            }
        }
        if ($this->c_lname) {
            if ($this->update('lname', $this->lname, Account::$tableName)) {
                $this->c_lname = false;
            }
        }
        if ($this->c_hash) {
            if ($this->update('hash', $this->hash, Account::$tableName)) {
                $this->c_hash = false;
            }
        }
        if ($this->c_salt) {
            if ($this->update('salt', $this->salt, Account::$tableName)) {
                $this->c_salt = false;
            }
        }
        if ($this->c_time) {
            if ($this->update('time', $this->time, Account::$tableName)) {
                $this->c_time = false;
            }
        }
    }
    
    /**
     * generates a new unique post ID
     */
    protected function genID($email, $hash) {
        $loop = 0;
        while (true) {
            $time = time();
            $loop++;
            $userid = substr(base_convert(md5($email . $hash . $time . $loop), 16, 10), 0, 10);
            if (!Account::accountExistsId($userid)) {
                return $userid;
            }
            error_log('colision avoided');
        }
    }
    

    //=-=-=-=-=-=-=-=-=-=-=-=  Static Functions  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-//
    
    public static function fromEmail($email) {
        $result = Account::selectFromAccount('ID', 'email', $email, Account::$tableName);
        return new Account($result['ID']);
    }
    
    /**
     * checks if  account exists
     */
    public static function accountExistsId($ID) {
        $results = Account::selectFromAccount('ID', 'ID', $ID, Account::$tableName);
        if (isset($results['ID']) && $results['ID'] == $ID) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * logs out account
     */
    public static function logOut() {
        session_start();
        connect();
        $account = new Account($_SESSION['userid']);
        $account->removeCookie();
        session_destroy();
        header('Location: /');
    }
    
    //=-=-=-=-=-=-=-=-=-=-=-=  Member Functions  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-//
    
    /**
     * verifys that this account exists
     */
    public function exists() {
        return Account::accountExistsId($this->ID);
    }
    
    
    /**
     * generates password hash for account
     */
    protected function hash($password, $salt) {
        return substr(crypt($password, '$6$rounds=5000$' . $salt . '$'), 15);
    }
    
    
    /**
     * register new account and login
     */
    public static function register($email, $password, $fname, $lname, $auto) {
        //check for email address here!
        if (strlen($password) > 0 && strlen($password) <= 100 && strlen($fname) > 0 && strlen($lname) > 0) { //validate chars too..
            
        
            connect();
            //$password = md5($password);
            $bytes = openssl_random_pseudo_bytes(16, $cstrong);
            $salt = md5(sha1($bytes));
            $hash = Account::hash($password, $salt);
            
            $userid = Account::genID($email, $hash);
            
            $time = time();
            
            if(Account::insertAccount($userid, $email, $fname, $lname, $hash, $salt, $time)) {
            
		        unset($account);
		        return Account::login($email, $password, $auto);
                
            }
        }
        echo false;
    }
    
     /**
     * login a normal account
     */
    public static function login($email, $password, $auto) {
        
        connect();
        session_start();
        $account = Account::fromEmail($email);
        
        $hash = Account::hash($password, $account->getSalt());
                
        if ($account->getHash() == $hash) {
            $account->setStatus("true");
            
            $_SESSION['account'] = $account;
		    $_SESSION['loggedin'] = true;
		    
		    if($auto == "true") {
                $account->makeCookie();
            }
            
        } else if ($account->getEmail() == $email) {
            $account->setStatus("badpass");
        } else {
            $account->setStatus("noacc");
        }
        
        return $account;
    }
    
    
    /**
     * checks if there is a cookie to log in. (rewrite?)
     */
    public static function checkCookie() {
        if(isset($_COOKIE['login'])) {
            
	        
	        list($user, $token, $sig) = explode(':', $_COOKIE['login'], 3);
	        
	        $serverSig = hash('sha256', sha1(Account::$serverSignKey) . $token);
	        
	        
	        if ($serverSig != $sig) {
	             return false;
	        } else {
	        
	        
                connect();
                
                $account = new Account($user);
                Account::reLogin($account, $account->getHash());
	            return true;
		    }
	    }
        
        return false;
    }
    
    /**
     * recovers account from cookie
     */
    public static function reLogin($account, $hash) {
        
        if ($account->getHash() == $hash) {
            
            session_destroy();
            session_start();
            
            $_SESSION['account'] = $account;
		    $_SESSION['loggedin'] = true;
		    
            return true;            
        } else {
            return false;
        }
    }
    
    
    /**
     * verifys password
     */
    public function verifyPass($password) {
            
        $hash = Account::hash($password, $this->getSalt());
        if ($hash == $this->getHash()) {
            return true;
        } else {
            return false;
        }

    }
    
    /**
     * makes a login cookie (broke?)
     */
    public function makeCookie() {
    
        $token = hash('sha256', sha1($this->getID()) . time() . rand());
        
        $sig = hash('sha256', sha1(Account::$serverSignKey) . $token);
        
	    setcookie('login', $this->getID() . ':' . $token . ':' . $sig, time() + (3600 * 24 * 30), '/');
	    
	    
    
        $query = $GLOBALS['currentConnection']->prepare('SELECT ID FROM ' . Account::$tableName1 . ' where ID = :ID');
        $query->execute(array(':ID' => $this->getID()));
        $query->setFetchMode(PDO::FETCH_ASSOC); 
        $results = $query->fetch();
        
        
        if (isset($results['ID'])) {
             $query = $GLOBALS['currentConnection']->prepare('UPDATE ' . Account::$tableName1 . ' SET token = :token WHERE ID = :ID');
             $query->execute(array(':ID' => $this->getID(), ':token' => $token));
             
        } else {
            $query = $GLOBALS['currentConnection']->prepare('INSERT INTO ' . Account::$tableName1 . ' VALUES (:ID, :token, :time)');
            $query->execute(array(':ID' => $this->getID(), ':token' => $token, ':time' => time()));
        }
    }
    
    /**
     * removes logged in cookie
     */
    public static function removeCookie() {
        setcookie ("login", "", time() - 3600);
    }
    
    
}
    
    
    
    
  

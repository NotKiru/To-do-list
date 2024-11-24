<?php

namespace Web;

class Registration extends \Application\Main  {

    
    public function __construct($cmd,$config){

       parent::__construct($cmd,$config);

    }
     
    public function Show(){
        if(!$_SESSION['isLoggedIn']) {
            $this->AddStyle('bootstrap.min.css');
            $this->AddStyle('style_'.$_SESSION['theme'].'.css');
            $this->AddStyle('registration.css');
            $this->AddJava('bootstrap.bundle.min.js');
            $this->AddJava('jquery-3.2.1.slim.min.js');
            $this->AddJava('popper.min.js');
            $Controller = $this->GetInstance("Application\Controller"); 
            $DataBase = $this->GetInstance("Drivers\DataBase");
   
            $DataBase->dbConnect();

            $isUsernameTaken = false;
            $isEmailTaken = false;
   
            if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) != '' && $_POST['email'] != '' && $_POST['username'] != '' && $_POST['password'] != '') {
                $data = array();
                $usernameSql = "SELECT IF(username = \"".$_POST['username']."\",true,false) as isTaken FROM users;";
                $emailSql = "SELECT IF(email = \"".$_POST['email']."\",true,false) as isTaken FROM users;";
                $DataBase->sqlSelect($usernameSql);
                $DataList = $DataBase->GetAllData();

                foreach($DataList as $row) {
                    if($row['isTaken']) {
                        $isUsernameTaken = true;
                    }
                }

                $DataBase->sqlSelect($emailSql);
                $DataList = $DataBase->GetAllData();

                foreach($DataList as $row) {
                    if($row['isTaken']) {
                        $isEmailTaken = true;
                    }
                }


                if(!$isUsernameTaken && !$isEmailTaken) {
                    $userData['username'] = $_POST['username'];
                    $userData['email'] = $_POST['email'];
                    $userData['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);

                    $DataBase->sqlInsert('users', $userData);

                    $sql = "SELECT id FROM users WHERE username = '".$_POST['username']."';";
                    $DataBase->sqlSelect($sql);               
                    $settingsData['user_id'] = $DataBase->GetAllData()[0]['id'];

                    $DataBase->sqlInsert('settings', $settingsData);
                    $_SESSION['isLoggedIn'] = true;
                    $_SESSION['username'] = $_POST['username'];
                    header("Location: Start.html");
                    die();
                }
            }
            if ($this->isTemplateExists("header.php")) { include_once($this->IncludePath('header.php')); }
            if ($this->isTemplateExists("login.php")) { include_once($this->IncludePath('registration.php')); }
        } else {
             header("Location: Start.html");
             die();
        }
    } 
}

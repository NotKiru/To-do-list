<?php

namespace Web;

class Login extends \Application\Main  {

    
    public function __construct($cmd,$config){

       parent::__construct($cmd,$config);

    }
     
    public function Show(){
        if(!$_SESSION['isLoggedIn']) {     
            $this->AddStyle('bootstrap.min.css');
            $this->AddStyle('style_'.$_SESSION['theme'].'.css');
            $this->AddStyle('login.css');
            $this->AddJava('bootstrap.bundle.min.js');
            $this->AddJava('jquery-3.2.1.slim.min.js');
            $this->AddJava('popper.min.js');
            $Controller = $this->GetInstance("Application\Controller"); 
            $DataBase = $this->GetInstance("Drivers\DataBase");
   
            $DataBase->dbConnect();
            $DataList = " ";
   
            if(isset($_POST['username']) && isset($_POST['password']) && $_POST['username'] != '' && $_POST['password'] != '') {
               $sql = "SELECT * FROM users WHERE username = '".$_POST["username"]."'";
               $DataBase->sqlSelect($sql);
               $DataList = $DataBase->GetAllData();

               if($DataList != NULL && password_verify($_POST["password"], $DataList[0]['password'])) {
                    $sql = "SELECT theme FROM settings WHERE user_id = \"".$DataList[0]['id']."\"";
                    $DataBase->sqlSelect($sql);
                    $theme = $DataBase->GetAllData()[0]['theme'];

                    $_SESSION['theme'] = $theme;
                    $_SESSION['isLoggedIn'] = true;
                    $_SESSION['username'] = $_POST["username"];
                    header("Location: Start.html");
                    die();
               }
            }
            if ($this->isTemplateExists("header.php")) { include_once($this->IncludePath('header.php')); }
            if ($this->isTemplateExists("login.php")) { include_once($this->IncludePath('login.php')); }
        } else {
             header("Location: Start.html");
             die();
        }
    } 
}

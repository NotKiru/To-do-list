<?php

namespace Web;

class Start extends \Application\Main  {

    
    public function __construct($cmd,$config){

       parent::__construct($cmd,$config);

    }
     
    public function Show(){
        $this->AddStyle('bootstrap.min.css');
        $this->AddStyle('style_'.$_SESSION['theme'].'.css');
        $this->AddStyle('start.css');
        $this->AddJava('bootstrap.bundle.min.js');
        $this->AddJava('jquery-3.2.1.slim.min.js');
        $this->AddJava('popper.min.js');
        $Controller = $this->GetInstance("Application\Controller"); 
        $DataBase = $this->GetInstance("Drivers\DataBase");

        $DataBase->dbConnect();

        $myDayCount = $priorityCount = $upcomingCount = $listCount = $userId = 0;
        $isAddTask = $isAddList = $isDelList = $isConfirmDelList = $isEditSettings = false;

        if($Controller->GetParam("logOut") == "true") {
            $_SESSION['isLoggedIn'] = false;
            $_SESSION['username'] = "";   
        } 
        $username = $_SESSION['username'];

        $listName = $Controller->GetParam("navItemName");
        $editTaskId = $Controller->GetParam("editTask");
        $delTaskId = $Controller->GetParam("delTask");

        if($Controller->GetParam("addTask") == "true") $isAddTask = $Controller->GetParam("addTask");
        if($Controller->GetParam("addList") == "true") $isAddList = $Controller->GetParam("addList"); 
        if($Controller->GetParam("delList") == "true") $isDelList = $Controller->GetParam("delList"); 
        if($Controller->GetParam("confirmDelList") == "true") $isConfirmDelList = $Controller->GetParam("confirmDelList"); 
        if($Controller->GetParam("editSettings") == "true") $isEditSettings = $Controller->GetParam("editSettings");      
        
        if($_SESSION['username'] != '') {
            $sql = "SELECT id FROM users WHERE username = \"".$_SESSION['username']."\"";
            $DataBase->sqlSelect($sql);
            $userId = $DataBase->GetAllData()[0]['id'];
        }

        $todaysDate = date("Y-m-d");
        $sql = "SELECT COUNT(tasks.id) as count FROM tasks JOIN users ON users.id = tasks.user_id WHERE due_date = '$todaysDate' AND users.username = '$username';";
        $DataBase->sqlSelect($sql);
        $myDayCount = $DataBase->GetAllData();

        $sql = "SELECT COUNT(tasks.id) as count FROM tasks JOIN users ON users.id = tasks.user_id WHERE due_date >= '$todaysDate' AND users.username = '$username';";
        $DataBase->sqlSelect($sql);
        $upcomingCount = $DataBase->GetAllData();

        $sql = "SELECT DISTINCT * FROM todolists WHERE user_id = '$userId';";
        $DataBase->sqlSelect($sql);
        $toDoLists = $DataBase->GetAllData();
        
        if($listName == "Mój dzień") {   
            $sql = "SELECT tasks.id, title, description FROM tasks JOIN users ON users.id = tasks.user_id WHERE due_date = '$todaysDate' AND users.username = '$username';";
            $DataBase->sqlSelect($sql);
            $dataList = $DataBase->GetAllData();
            $listCount = $myDayCount[0]['count'];
        } elseif($listName == "Nadchodzące") {
            $sql = "SELECT tasks.id, title, description FROM tasks JOIN users ON users.id = tasks.user_id WHERE due_date >= '$todaysDate' AND users.username = '$username';";
            $DataBase->sqlSelect($sql);
            $dataList = $DataBase->GetAllData();
            $listCount = $upcomingCount[0]['count'];
        } else {
            $sql = "SELECT id FROM todolists WHERE user_id = '$userId' AND title = '$listName';";
            $DataBase->sqlSelect($sql);
            if($DataBase->GetAllData() == NULL) {
                header('Location: '.$this->GetUrl('/Web/Start/navItemName/Mój dzień'));
                die();
            }
            $sql = "SELECT tasks.id, tasks.title, tasks.description FROM tasks JOIN users ON users.id = tasks.user_id JOIN todolists ON todolists.id = tasks.todolist_id WHERE users.username = '$username' AND todolists.title = '$listName';";
            $DataBase->sqlSelect($sql);
            $dataList = $DataBase->GetAllData();
            $sql = "SELECT COUNT(tasks.id) as count FROM tasks JOIN users ON users.id = tasks.user_id JOIN todolists ON todolists.id = tasks.todolist_id WHERE users.username = '$username' AND todolists.title = '$listName';";
            $DataBase->sqlSelect($sql);
            $listCount = $DataBase->GetAllData()[0]['count'];
        }

        if(isset($_POST['title']) && isset($_POST['duedate']) && $_POST['title'] != '' && $_POST['duedate'] != '') {
            $toDoListId = NULL;

            $sql = "SELECT title FROM todolists";
            $DataBase->sqlSelect($sql);
            foreach($DataBase->GetAllData($sql) as $toDoListTitle) {
                if($toDoListTitle['title'] == $_POST['todolist']) {
                    $sql = "SELECT id FROM todolists WHERE title = '".$toDoListTitle['title']."'";
                    $DataBase->sqlSelect($sql);
                    $toDoListId = $DataBase->GetAllData()[0]['id'];
                }
            }

            $data['title'] = $_POST['title'];
            $data['description'] = $_POST['description'];
            $data['due_date'] = $_POST['duedate'];
            $data['user_id'] = $userId;

            $data['todolist_id'] = $toDoListId;
            if($isAddTask) {
                $DataBase->sqlInsert('tasks', $data);
                header('Location: '.$this->GetUrl('/Web/Start/navItemName/'.$listName));
                die();
            } elseif($editTaskId != 0) {
                $condition['id'] = $editTaskId;
                $DataBase->sqlUpdate('tasks', $data, $condition);    
                header('Location: '.$this->GetUrl('/Web/Start/navItemName/'.$listName.'/editTask/'.$editTaskId));
                die();  
            }                           
        }
        if($isAddList) {
            if(isset($_POST['title']) && $_POST['title'] != '') {
                $data['title'] = $_POST['title'];
                $data['user_id'] = $userId;
                $DataBase->sqlInsert('todolists', $data);
                header('Location: '.$this->GetUrl('/Web/Start/navItemName/'.$listName));
                die();
            }
        }
        
        if($delTaskId != '0') {
            $condition['id'] = $delTaskId;
            $DataBase->sqlDelete('tasks', $condition);
            header('Location: '.$this->GetUrl('/Web/Start/navItemName/'.$listName));
            die();
        } 

        if($isConfirmDelList) {
            $sql = "SELECT id FROM todolists WHERE user_id = '$userId' AND title = '$listName';";
            $DataBase->sqlSelect($sql);
            $delListId = $DataBase->GetAllData()[0]['id'];

            $sql = "SELECT id FROM tasks WHERE user_id = '$userId' AND todolist_id = '$delListId';";
            $DataBase->sqlSelect($sql);
            $isUpdate = $DataBase->GetAllData();

            if($isUpdate != NULL) {
                $data['todolist_id'] = NULL;
                $updateCondition['todolist_id'] = $delListId;
                    
                $DataBase->sqlUpdate('tasks', $data, $updateCondition);
            }
            
            $deleteCondition['id'] = $delListId;
            $DataBase->sqlDelete('todolists', $deleteCondition);
            $sql = "SELECT title FROM todolists WHERE user_id = '$userId' ORDER BY id DESC LIMIT 1;";
            $DataBase->sqlSelect($sql);
            $lastListName = $DataBase->GetAllData()[0]['title'];

            header('Location: '.$this->GetUrl('/Web/Start/navItemName/'.$lastListName));
            die();
        }

        if($isEditSettings) {
            if(isset($_POST['theme']) && $_POST['theme'] != '') {
                $_SESSION['theme'] = $_POST['theme'];

                $settingsConditions['user_id'] = $userId;
                $settingsData['theme'] = $_POST['theme'];

                $DataBase->sqlUpdate('settings', $settingsData, $settingsConditions);
                header('Location: '.$this->GetUrl('/Web/Start/navItemName/'.$listName.'/editSettings/true'));
                die();
            }
        }

        if ($this->isTemplateExists("header.php")) { include_once($this->IncludePath('header.php')); }
        if ($this->isTemplateExists("start.php")) { include_once($this->IncludePath('start.php')); }
        if ($this->isTemplateExists("footer.php")) {  include_once($this->IncludePath('footer.php'));}
    } 
}

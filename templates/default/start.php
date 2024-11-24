<section class="pageContent d-flex w-100">
<div class="d-flex flex-column flex-shrink-0 p-3" id="navigation">
    <div class="dropdown">
      <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="<?=$this->GetImg("profile.png")?>" alt="" width="32" height="32" class="rounded-circle me-2">
        <strong><?=$username?></strong>
      </a>
      <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser">
        <?php
          if($_SESSION['isLoggedIn']) {
            echo '<li><a class="dropdown-item" href="'.$this->GetUrl('/Web/Start/navItemName/'.$listName.'/editSettings/true').'">Ustawienia</a></li>';
            echo '<li><hr class="dropdown-divider"></li>';
            echo '<li><a class="dropdown-item" href="'.$this->GetUrl('/Web/Start/logOut/true').'">Wyloguj się</a></li>';
          } else {
            echo '<li><a class="dropdown-item" href="'.$this->GetUrl('/Web/Login').'">Zaloguj się</a></li>';
            echo '<li><a class="dropdown-item" href="'.$this->GetUrl('/Web/Registration').'">Zarejestruj się</a></li>';
          }
        ?>
        
      </ul>
    </div>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
      <b>Zadania</b>
      <li class="nav-item">
        <a href="<?=$this->GetUrl('/Web/Start/navItemName/Mój dzień')?>" class="nav-link <?php if($listName == "Mój dzień") echo "active"?> text-white d-flex justify-content-between" aria-current="page">
          <span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-brightness-high" viewBox="0 0 16 16">
              <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708"/>
            </svg>
            Mój dzień
          </span>
          <span><?=$myDayCount[0]['count']?></span>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?=$this->GetUrl('/Web/Start/navItemName/Nadchodzące')?>" class="nav-link <?php if($listName == "Nadchodzące") echo "active"?> text-white d-flex justify-content-between" aria-current="page">
          <span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708"/>
            <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708"/>
          </svg>
            Nadchodzące
          </span>
          <span><?=$upcomingCount[0]['count']?></span>
        </a>
      </li>
      <hr>
      <div class="d-flex justify-content-between align-items-center">
        <b>Listy</b> 
        <div>
          <a id="addList" href="<?php if($username == "") echo $this->GetUrl('/Web/Start/navItemName/'.$listName.'/addList/false'); else echo $this->GetUrl('/Web/Start/navItemName/'.$listName.'/addList/true');?>">+</a>
          <a id="delList" href="<?php if($username == "") echo $this->GetUrl('/Web/Start/navItemName/'.$listName.'/delList/false'); else echo $this->GetUrl('/Web/Start/navItemName/'.$listName.'/delList/true')?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
              <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
              <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
            </svg>
          </a>
        </div>
      </div>
      <?php
        foreach($toDoLists as $toDoList) {
          $sql = "SELECT COUNT(tasks.id) as count from tasks JOIN users ON users.id = tasks.user_id WHERE todolist_id = '".$toDoList['id']."' AND username = '$username';";
          $DataBase->sqlSelect($sql);
          $tasksCount = $DataBase->GetAllData();
          echo '<li class="nav-item">';
          echo '<a href="'.$this->GetUrl('/Web/Start/navItemName/'.$toDoList['title']).'" class="nav-link ';
          if($listName == $toDoList['title']) echo 'active';
          echo ' text-white d-flex justify-content-between">';         
          echo '<span>'.$toDoList['title'].'</span>';
          echo '<span>'.$tasksCount[0]['count'].'</span>';
          echo '</a></li>';
        }
        if($isAddList) {
          echo '<li class="nav-item">';
          echo '<form method="POST" class="d-flex justify-content-beetween">';   
          echo '<input type="text" class="form-control" id="inputTitle" placeholder="Tytuł" name="title">';
          echo '<button type="submit" class="btn">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0"/>
          </svg></button>';
          echo '</form></li>';
        }
        if($isDelList) {
          echo '<div class="d-flex justify-content-between align-items-center">';
          echo '<b id="delListLabel">Czy napewno usunąć listę '.$listName.'?</b>';
          echo '<a id="confirmDelList" href="'.$this->GetUrl('/Web/Start/navItemName/'.$listName.'/confirmDelList/true').'"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0"/>
          </svg></a>';
          echo '</div>';
        }
      ?>    
    </ul>
    
  </div>
  <div id="main">
    
      <?php
        if($listName == "") {
          echo '<div id="list-name-container">';
          if($username == "") {
            echo '<h1>Witaj użytkowniku.</h1>';
          } else {
            echo '<h1>Witaj '.$username.'.</h1>';
          }
          
        } else {
          echo '<div id="list-name-container">';
          echo '<h1>'.$listName.'</h1>';
          echo '<span>'.$listCount.'</span>';
          echo '</div>';
          echo '<hr>';
          echo '<div class="d-grid gap-3">';
          echo '<div class="task-container">';
          echo '<a href="'.$this->GetUrl('/Web/Start/navItemName/'.$listName.'/addTask/true').'">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                  <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                </svg>
                Dodaj zadanie
                </a>';        
        }
        
        echo '</div>';
        foreach($dataList as $data) {
          if($listName != "Lista do zrobienia") {
            echo '<div class="task-container">';
            echo '<a href="'.$this->GetUrl('/Web/Start/navItemName/'.$listName.'/editTask/'.$data['id']).'">'.$data['title'].'</a>';
            echo '</div>';
          } else {
            $sql = "SELECT tasks.title, tasks.priority FROM tasks JOIN todolists ON todolists.id = tasks.todolist_id JOIN users ON users.id = tasks.user_id WHERE todolists.title = '".$data['title']."' AND users.username = '$username';";
            $DataBase->sqlSelect($sql);
            $tasks = $DataBase->GetAllData();
            echo '<div class="task-container">';
            echo '<p>'.$data['title'].'</p>';
            echo '<div class="d-grid">';
            foreach($tasks as $task) {
              echo '<div>';
              echo '<p>'.$task['title'].'</p>';
              echo '</div>';
            }  
            echo '</div>';
            echo '</div>';  
                
          }
        }  
        echo '</div>'; 
        echo '</div>'; 
        if(!$isEditSettings) {
          if($isAddTask || $editTaskId != '0') {
          if(!$_SESSION['isLoggedIn']) {
            echo '<div id="task">';
            echo '<h2>Zaloguj się aby korzystać z tej funckji</h2>';
            echo '</div>';
          } else {
            $taskData['id'] = $taskData['title'] = $taskData['description'] = $taskData['due_date'] = '';
            if($editTaskId != '0') {
              $sql = "SELECT * FROM tasks WHERE id = '$editTaskId'";
              $DataBase->sqlSelect($sql);
              $taskData = $DataBase->GetAllData()[0];
            }
            echo '<div id="task">';
            echo '<h2>Zadanie:</h2>';
            echo '<div class="d-flex justify-content-center">';
            echo '<form method="POST">
                <div class="form-group row">
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="inputTitle" placeholder="Tytuł" name="title" value="'.$taskData['title'].'">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <textarea class="form-control" id="inputDescription" placeholder="Opis" rows="4" name="description">'.$taskData['description'].'</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 d-flex align-items-center">
                        <label for="inputDueDate" class="form-label">Termin</label>
                        <input type="date" class="form-control" id="inputDueDate" name="duedate" value="'.$taskData['due_date'].'">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 d-flex align-items-center">
                        <label for="inputToDoList" class="form-label">Tytuł listy</label>
                        <select class="form-control form-select" id="inputToDoList" name="todolist">';
                        if($toDoLists == NULL) echo '<option value="" selected>Wybierz liste</option>';
              foreach($toDoLists as $toDoList) {
                if($toDoList['id'] == $taskData['todolist_id']) {
                  echo '<option value="'.$toDoList['title'].'" selected>'.$toDoList['title'].'</option>';
                } else {
                  echo '<option value="'.$toDoList['title'].'">'.$toDoList['title'].'</option>';
                }
                
              }
          echo '</div>';
          echo '</div>';
          echo '<div class="form-group row">';
          if(!$isAddTask) {
            echo '<div class="col-sm-4">
                    <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
                  </div>
                  <div class="col-sm-4">
                    <button class="btn btn-danger"><a href="'.$this->GetUrl('/Web/Start/navItemName/'.$listName.'/delTask/'.$editTaskId).'">Usuń zadanie</a></button>
                  </div>';
          } else {
            echo '<div class="col-sm-4">
                    <button type="submit" class="btn btn-primary">Dodaj zadanie</button>
                  </div>';
          }

          echo '</div>';
          echo '</form>';
          echo '</div>';
          echo '</div>';
          }
          }
        } else {
          echo '<div id="settings">';
          echo '<h2>Ustawienia:</h2>';
          echo '<div class="d-flex justify-content-center">';
          echo '<form method="POST">
                <div class="col-sm-12 d-flex align-items-center">
                    <label for="inputTheme" class="form-label">Motyw</label>
                    <select class="form-control form-select" id="inputTheme" name="theme">';
          if($_SESSION['theme'] == 'light') {
            echo '<option value="dark">Ciemny</option>';
            echo '<option value="light" selected>Jasny</option></select></div>';
          } else {
            echo '<option value="dark" selected>Ciemny</option>';
            echo '<option value="light">Jasny</option></select></div>';
          }
          
          echo '<div class="col-sm-4">
                        <button type="submit" class="btn btn-primary">Zapisz</button>
                      </div>';
          echo '</form></div></div>';
        }
      ?>

</section>
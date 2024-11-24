<section class="pageContent w-100 h-100">
    <div class="align-items-center justify-content-center d-grid w-100 h-100">
        <form method="POST">
            <h1 class="text-center">Zarejestruj się</h1>
            <div class="form-group row">
                <div class="col-sm-10">
                    <input type="text" class="form-control <?php if($isUsernameTaken) echo "wrongData"?>" id="inputUsername" placeholder="<?php if($isUsernameTaken) echo "Nazwa użytkownika jest już w użyciu"; else echo "Nazwa użytkownika";?>" name="username">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <input type="email" class="form-control <?php if($isEmailTaken) echo "wrongData"?>" id="inputEmail" placeholder="<?php if($isEmailTaken) echo "Email jest już w użyciu"; else echo "Email";?>" name="email">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputPassword" placeholder="Password" name="password">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Zarejestruj się</button>
                </div>
            </div>
        </form>
    </div>
</section>
<section class="pageContent w-100 h-100">
    <div class="align-items-center justify-content-center d-grid w-100 h-100"> 
        <form method="POST">
            <h1 class="text-center">Zaloguj się</h1>
            <div class="form-group row">
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputUsername" placeholder="Username" name="username">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputPassword" placeholder="Password" name="password">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Zaloguj się</button>
                    <button class="btn btn-secondary"><a href="<?=$this->GetUrl('/Web/Registration')?>">Zarejestruj się</a></button>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <p><?php if($DataList == NULL) { echo "Niewłaściwe dane.";}?></p>
                </div>
            </div>
        </form>
    </div>
</section>
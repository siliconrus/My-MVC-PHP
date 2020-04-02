<main class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>Профиль пользователя</h3></div>

                    <div class="card-body">
                        <? if(isset($_SESSION['profile_update'])) : ?>
                        <div class="alert alert-success" role="alert">
                            <?=$_SESSION['profile_update']?>
                        </div>
                        <?
                        unset($_SESSION['profile_update']);
                        endif;
                        ?>

                        <form id="1" action="/account/profile" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Name</label>
                                        <input type="text" class="form-control" name="login" id="exampleFormControlInput1" value="<? echo $_SESSION['auth_session']['login']; ?>">

                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Email</label>
                                        <input type="email" class="form-control" name="email" id="exampleFormControlInput1" value="<? echo $_SESSION['auth_session']['email']; ?>">
                                        <!--в class="form-control добавить is-invalid"-->
                                        <!--<span class="text text-danger">
                                                Ошибка валидации
                                            </span>-->
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Аватар</label>
                                        <input type="file" class="form-control" name="image" id="exampleFormControlInput1">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <img src="/<? echo $_SESSION['auth_session']['avatars']; ?>" alt="" class="img-fluid">
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" name="prof_edit" class="btn btn-warning">Edit profile</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-12" style="margin-top: 20px;">
                <div class="card">
                    <div class="card-header"><h3>Безопасность</h3></div>

                    <div class="card-body">
                        <? if(isset($_SESSION['pwd_update'])) : ?>
                            <div class="alert alert-success" role="alert">
                                <?=$_SESSION['pwd_update']?>
                            </div>
                            <?
                            unset($_SESSION['pwd_update']);
                        endif;
                        ?>

                        <form action="/account/profiles" method="post">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Current password</label>
                                        <input type="password" name="current" class="form-control" id="exampleFormControlInput1">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">New password</label>
                                        <input type="password" name="password" class="form-control" id="exampleFormControlInput1">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Password confirmation</label>
                                        <input type="password" name="password_confirmation" class="form-control" id="exampleFormControlInput1">
                                    </div>

                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
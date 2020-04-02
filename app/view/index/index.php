                 <div class="card-body">
                    <? if(isset($_SESSION['comment_success'])): ?>
                    <div class="alert alert-success" role="alert">
                        <?=$_SESSION['comment_success']?>
                        <button type="button" class="close" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                  </div>
                    <?
                    unset($_SESSION['comment_success']);
                    endif;
                    ?>
                    <? foreach ($comments as $posts) : ?>
                    <div class="media">
                      <img src="<? echo $posts['avatars'];?>" class="mr-3" alt="..." width="64" height="64">
                      <div class="media-body">
                        <h5 class="mt-0"><? echo htmlspecialchars($posts['login']);?></h5>
                        <span><small><? echo $posts['time'];?></small></span>
                        <p>
                            <? echo htmlspecialchars($posts['comment']);?>
                        </p>
                      </div>
                        <?
                        if(isset($_SESSION['auth_session'])) :
                         if($posts['user_id'] == $_SESSION['auth_session']['id']) : ?>
                            <button type="button" class="close" aria-label="Close">
<!--                                <a href="/main/delete/--><?//=$posts['id']?><!--" style="text-decoration: none;" onclick="return confirm('Вы уверены?')"  title="Удалить комментарий" aria-hidden="true">×</a>-->
                                <div id="printCheck" style="text-decoration: none;"  title="Удалить комментарий" aria-hidden="true">×</div>
                            </button>
                        <? endif;
                        endif;
                        ?>
                    </div>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
                <? if(isset($_SESSION['auth_session'])) : ?>
                    <div class="col-md-12" style="margin-top: 20px;">
                        <div class="card">
                            <div class="card-header"><h3>Оставить комментарий</h3></div>
                            <div class="card-body">
                                <form action="" method="POST">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Сообщение</label>
                                        <textarea name="comment" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                    </div>
                                    <button type="submit" name="do_submit" class="btn btn-success">Отправить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <? else : ?>

                    <div class="col-md-12" style="margin-top: 20px;">
                        <div class="alert alert-success" role="alert"><center><a href="../account/auth">Авторизуйтесь</a>, чтобы добавлять комментарии</center></div>
                        <div class="card">
                            <div class="card-header"><h3>Оставить комментарий</h3></div>
                            <div class="card-body">
                                <form action="" method="POST">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Имя</label>
                                        <input name="username" class="form-control" value="Авторизуйтесь, чтобы что-то написать.." disabled id="exampleFormControlTextarea1" />
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Сообщение</label>
                                        <textarea name="comment" class="form-control" disabled id="exampleFormControlTextarea1" placeholder="Вы не авторизованы.." rows="3"></textarea>
                                    </div>
                                    <button type="submit" name="do_submit" class="btn btn-success" disabled>Отправить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <? endif; ?>
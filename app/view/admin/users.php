<main class="py-4">
    <div class="container">
        <td>
            <a href="../admin/online" class="button8">Онлайн</a>
            <a href="../admin" class="button8">Записи</a>
            <a href="../admin/users" class="button8">Все пользователи</a>
            <a href="../admin/ban" class="button8">Бан-лист</a>
        </td><p>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Аватар</th>
                                <th>Имя</th>
                                <th>Mail</th>
                                <th>IP адрес</th>
                                <th>Действия</th>
                            </tr>
                            </thead>

                            <tbody>
                            <? foreach ($allUsers as $allUser) : ?>
                            <tr>
                                <td><? echo $allUser['id'];?></td>
                                <td>
                                    <img src="../<? echo $allUser['avatars'];?>" alt="" class="img-fluid" width="64" height="64">
                                </td>
                                <td><? echo htmlspecialchars($allUser['login']);?></td>
                                <td><?  echo $allUser['email'];?></td>
                                <td><? echo $allUser['ip'];?></td>
                                <td>
                                    <a href="banUsers/<?=$allUser['id'] ?>/type/1" class="btn btn-successBan">Забанить в чате</a>
                                    <a href="banUsers/<?=$allUser['id'] ?>/type/2" class="btn btn-successBan">Забанить на сайте</a>
                                </td>
                            </tr>
                            </tbody>
                            <? endforeach; ?>
                        </table>
<!--                        <center>-->
<!--                            <a href="" class="btn btn-successBan">Предыдущая страница</a>-->
<!--                            <a href="" class="btn btn-successBan">Следующая страница</a>-->
<!--                        </center>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

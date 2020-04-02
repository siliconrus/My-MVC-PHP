
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
                                <th>Аватар</th>
                                <th>Имя</th>
                                <th>IP адрес</th>
                                <th>Заходил:</th>
                                <th>Действия</th>
                            </tr>
                            </thead>

                            <tbody>
                            <? foreach ($onlineAdminPanel as $onlineAdminPanels) : ?>
                            <tr>
                                <td>
                                    <img src="../<?=$onlineAdminPanels['avatars']?>" alt="" class="img-fluid" width="64" height="64">
                                </td>
                                <td><? echo htmlspecialchars($onlineAdminPanels['login']);?></td>
                                <td><?  echo $onlineAdminPanels['ip'];?></td>
                                <td><? echo date('Y-m-d H:i', $onlineAdminPanels['last_activity']);?></td>
                                <td>
                                    <a href="banUsers/<?=$onlineAdminPanels['id'] ?>/type/1" class="btn btn-successBan">Забанить в чате</a>
                                    <a href="banUsers/<?=$onlineAdminPanels['id'] ?>/type/2" class="btn btn-successBan">Забанить на сайте</a>
                                </td>
                            </tr>
                            </tbody>
                            <? endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


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
                                <th>Дата</th>
                                <th>Комментарий</th>
                                <th>Действия</th>
                            </tr>
                            </thead>

                            <tbody>
                            <? foreach ($allComments as $allComment) : ?>
                            <tr>
                                <td>
                                    <img src="<? echo $allComment['avatars'];?>" alt="" class="img-fluid" width="64" height="64">
                                </td>
                                <td><? echo htmlspecialchars($allComment['login']);?></td>
                                <td><?  echo $allComment['time'];?></td>
                                <td><? echo htmlspecialchars($allComment['comment']);?></td>
                                <td>
                                    <? if($allComment['value'] == 1): ?>
                                    <a href="admin/allowComments/0/id/<? echo $allComment['id'];?>" class="btn btn-success">Разрешить</a>
                                    <? else : ?>
                                    <a href="admin/allowComments/1/id/<? echo $allComment['id'];?>" class="btn btn-warning">Запретить</a>
                                    <? endif; ?>
                                    <a href="admin/deleteComment/<? echo $allComment['id']; ?>" onclick="return confirm('are you sure?')" class="btn btn-danger">Удалить</a>
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

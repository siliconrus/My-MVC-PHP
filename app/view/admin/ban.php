
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
                            <form action='/admin/ban' method='post'>
                                <div class='text-settings'>ID пользователя:&nbsp;
                                    <input type='text' name='userID' value=''></div><br />
                                <div class='text-settings'>IP пользователя:&nbsp;
                                    <input type='text' name='userIP' value=''></div><br />
                                <div class='text-settings'>Причина:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type='text' name='reason' placeholder=' причина обязательна'></div><br />
                                <div class='text-settings'>Тип бана:
                                    <input name='type' type='radio' value='1'>Чат
                                    <input name='type' type='radio' value='2'>Приложение
                                </div><div class='text-settings'>
                                    <br>Забанить до:&nbsp;
                                    <input type='text' READONLY name='dateto' id='dateto' value='<?=date('d-m-Y')?>' size='12'>&nbsp;
                                    <img src='../public/img/panels/admin/img.gif' align='absmiddle'
                                         id='dateto_button' style='cursor: pointer;
                                         border: 0' title='Выбор даты с помощью календаря'>
                                    <script type='text/javascript'>Calendar.setup({ inputField:'dateto',
                                            ifFormat:'%d-%m-%Y', button:'dateto_button',
                                            align:'Br', singleClick:true});
                                    </script>
                                    <br /><br />Время:
                                    <input type='number' size='1' name='timeto1' min='0' max='24' value='<?=date('H')?>'> :
                                    <input type='number' min='0' max='59' name='timeto2' size='1' value='<?=date('i')?>'>
                                    <font color='red'><b>Обязательно 2 цифры (Пример: 00:00)</b></font><br>
                                    <br><input type='checkbox' name='forever'>&nbsp;Забанить навсегда</div><br />

                                <div class='button_blue fl_l'><button type='submit'>Забанить игрока</div><br>
                            </form>
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Аватар</th>
                                <th>Имя</th>
                                <th>Причина</th>
                                <th>Тип</th>
                                <th>Дата окончания</th>
                                <th>Действия</th>
                            </tr>
                            </thead>

                            <tbody>
                            <? foreach ($checkBan as $checkBans) :

                            switch ($checkBans)
                            {
                                case $checkBans['type'] == '1': $whereBan = 'CHAT'; break;
                                case $checkBans['type'] == '2': $whereBan = 'SITE'; break;
                                default: $whereBan = 'NAN';
                            }

                            ?>


                            <tr>
                                <td><? echo $checkBans['user_id'];?></td>
                                <td>
                                    <img src="../<? echo $checkBans['avatars'];?>" alt="" class="img-fluid" width="64" height="64">
                                </td>
                                <td><? echo htmlspecialchars($checkBans['login']);?></td>
                                <td><? echo $checkBans['cause'];?></td>
                                <td><? echo $whereBan;?></td>
                                <td><? echo date('Y-m-d H:i', $checkBans['data_end']);?></td>
                                <td>
                                    <a href="deleteBan/<?=$checkBans['id']?>" class="btn btn-success">Разбанить</a>
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

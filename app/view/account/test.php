
Название заголовка:
<input name="toast-header" type="text" value="Текст заголовка">
Текст сообщения:
<input name="toast-body" type="text" value="Текст сообщения...">
Цвет:
<select class="form-control" name="toast-color">
    <option selected value="#ffffff">#ffffff</option>
    <option value="#17a2b8">#17a2b8</option>
    <option value="#ffc107">#ffc107</option>
    <option value="#dc3545">#dc3545</option>
    <option value="#28a745">#28a745</option>
</select>
<br>
<input name="autohide" type="checkbox"> автоматически скрывать
<br>
Закрывать сообщение через (миллисекунд):
<input name="toast-delay" type="text" value="5000">
<button id="addToast" type="button">Добавить toast</button>

<script>
    document.querySelector('#addToast').addEventListener('click', function () {
        /*
          Параметры функции add:
          header (строка) - название заголовка
          body (строка) - текст сообщения
          color (строка) - цвет в формате #rrggbb
          autohide (булево) - скрывать ли автоматически всплывающее сообщение
          delay (число) - количество миллисекунд после которых сообщение будет автоматически скрыто
        */
        Toast.add({
            header: document.querySelector('[name="toast-header"]').value,
            body: document.querySelector('[name="toast-body"]').value,
            color: document.querySelector('[name="toast-color"] option:checked').value,
            autohide: document.querySelector('[name="autohide"]').checked,
            delay: parseInt(document.querySelector('[name="toast-delay"]').value)
        });
    });
</script>

<?php
foreach ($vars as $val)
{
    var_dump($val);
}

?>

<br />
<?php //echo implode( '--',$vars['hash']);

?>
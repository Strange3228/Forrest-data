<?php include('parts/head.php');?>
<?php include('functions.php');?>
<?php checkIfUserIsLogged(); ?>
<?php $db_connection = new General;?>
<?php $table_data_tickets = $db_connection->getData('lisorubni_kvytky'); ?>

<?php $all_porody=array(
    'sosna' => 'Сосна',
    'jalyna' => 'Ялина',
    'dub' => 'Дуб',
    'bereza' => 'Береза',
    'vilha' => 'Вільха',
    'grab' => 'Граб',
    'jasen' => 'Ясен',
    'klen' => 'Клен',
    'osyka' => 'Осика',
    'lypa' => 'Липа',
    'inshe' => 'Інше',
); ?>

<section class="create_ticket_section">
    <div class="container">
        <h1>Додати Данні</h1>
        <div class="lisnyctwo_inf">
            <div class="lisnyctwo_inf__block">
                <p>Назва:</p>
                <p class="lisnyctwo_inf__name"><?php echo wordsTranslation($_GET['lisnyctwo']) ?></p>
            </div>
            <div class="lisnyctwo_inf__block">
                <p>Типу рубки:</p>
                <p class="lisnyctwo_inf__name"><?php echo wordsTranslation($_GET['rubka']) ?></p>
            </div>
        </div>
        <form action="ajax.php" id="create_ticket_form" class="create_ticket">
            <input type="hidden" value="add_data" name="func_name" class="hidden_value">
            <input type="hidden" value="<?php echo getHighestValue($db_connection, $_GET['rubka'] . '_' . $_GET['lisnyctwo'], 'id') + 1;
                ?>" name="row_id" class="hidden_value">
            <input type="hidden" value="<?php echo $_GET['rubka'] . '_' . $_GET['lisnyctwo']; ?>" name="table_name">
            <div class="create_ticket_data_wrapper">
                <div class="create_ticket_data_single">
                    <div class="create_ticket_data_single__left">
                        <p>Загальна інформація</p>
                    </div>
                    <div class="create_ticket_data_single__right">
                        <div class="create_ticket_input_box">
                            <label for="kvartal">Квартал</label>
                            <input type="text" value="0" name="kvartal">
                        </div>
                        <div class="create_ticket_input_box">
                            <label for="vydil">Виділ</label>
                            <input type="text" value="0" name="vydil">
                        </div>
                        <div class="create_ticket_input_box">
                            <label for="lisorubnyj_kvytok">Лісорубний квиток №</label>
                            <select name="lisorubnyj_kvytok" id="lisorubnyj_kvytok">
                                <?php foreach($table_data_tickets as $row) { ?>
                                    <option value="<?php echo $row['number'] ?>"><?php echo $row['number'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="create_ticket_input_box">
                            <label for="ploshcha">Площа</label>
                            <input type="text" value="0" name="ploshcha">
                        </div>
                        <div class="create_ticket_input_box">
                            <label for="pidhotovchi_roboty">Підготовчі роботи</label>
                            <input type="text" value="0" name="pidhotovchi_roboty">
                        </div>
                        <div class="create_ticket_input_box">
                            <label for="oczystka_lisosiky">Очистка лісосіки</label>
                            <input type="text" value="0" name="oczystka_lisosiky">
                        </div>
                    </div>
                </div>
                <?php foreach($all_porody as $k => $v){ ?>
                    <div class="create_ticket_data_single">
                        <div class="create_ticket_data_single__left">
                            <p><?php echo $v; ?></p>
                        </div>
                        <div class="create_ticket_data_single__right">
                            <div class="create_ticket_input_box">
                                <label for="<?php echo $k; ?>_a">A</label>
                                <input type="text" value="0" name="<?php echo $k; ?>_a">
                            </div>
                            <div class="create_ticket_input_box">
                                <label for="<?php echo $k; ?>_b">B</label>
                                <input type="text" value="0" name="<?php echo $k; ?>_b">
                            </div>
                            <div class="create_ticket_input_box">
                                <label for="<?php echo $k; ?>_c">C</label>
                                <input type="text" value="0" name="<?php echo $k; ?>_c">
                            </div>
                            <div class="create_ticket_input_box">
                                <label for="<?php echo $k; ?>_d">D</label>
                                <input type="text" value="0" name="<?php echo $k; ?>_d">
                            </div>
                            <div class="create_ticket_input_box">
                                <label for="<?php echo $k; ?>_pv">ПВ</label>
                                <input type="text" value="0" name="<?php echo $k; ?>_pv">
                            </div>
                            <div class="create_ticket_input_box">
                                <label for="<?php echo $k; ?>_np">НП</label>
                                <input type="text" value="0" name="<?php echo $k; ?>_np">
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="create_ticket_data_single">
                    <div class="create_ticket_data_single__left">
                        <p>Хворост</p>
                    </div>
                    <div class="create_ticket_data_single__right">
                        <div class="create_ticket_input_box">
                            <label for="chvorost_1">Іс</label>
                            <input type="text" value="0" name="chvorost_1">
                        </div>
                        <div class="create_ticket_input_box">
                            <label for="chvorost_1">ІIс</label>
                            <input type="text" value="0" name="chvorost_2">
                        </div>
                        <div class="create_ticket_input_box">
                            <label for="chvorost_1">ІIIс</label>
                            <input type="text" value="0" name="chvorost_3">
                        </div>
                    </div>
                </div>
            </div>
            <div class="create_ticket__btns">
                <button class="create_ticket__submit" type="submit">Підтвердити</button>
            </div>
        </form>
    </div>
</section>


<?php include('parts/foot.php');?>
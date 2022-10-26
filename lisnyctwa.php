<?php include('parts/head.php');?>
<?php include('functions.php');?>
<?php checkIfUserIsLogged(); ?>
<?php $db_connection = new General;?>


<section class="page_titles">
  <div class="container">
    <h1 class="page__title">Тип Рубки: <?php echo wordsTranslation($_GET['rubka']); ?></h1>
  </div>
</section>

<section class="archive_lisnyctwa">
    <div class="container">
        <div class="box">
            <div class="search_wrapp">
                <input type="text" id="archive_lisnyctwa_search_name" class="search_lisnyctwa" placeholder="Розпочніть писати назву...">
            </div>
            <?php
                $tables = $db_connection->getTableNames($_GET['rubka']);
                foreach($tables as $table){
                    list($table_rubka, $table_lisnyctwo) = explode("_", $table['TABLE_NAME']);
                ?>
                <div class="archive_lisnyctwa_item">
                    <?php
                        $total = array(
                            'bereza' => 0,
                            'chvorost' => 0,
                            'dub' => 0,
                            'grab' => 0,
                            'inshe' => 0,
                            'jalyna' => 0,
                            'jasen' => 0,
                            'klen' => 0,
                            'lypa' => 0,
                            'oczystka_lisosiky' => 0,
                            'osyka' => 0,
                            'pidhotovchi_roboty' => 0,
                            'realizowano_liquidu' => 0,
                            'sosna' => 0,
                            'vilha' => 0
                        );
                        $total_ploshcha = 0;
                        $table_data = $db_connection->getData($_GET['rubka'] . '_' . $table_lisnyctwo);
                        foreach ($table_data as $row){
                            $total_ploshcha = $row['ploshcha'] + $total_ploshcha;
                            foreach($row as $item_key => $item_value){
                                foreach($total as $typ => $value) {
                                    if (strpos($item_key, $typ) !== false) {
                                        $total[$typ] = $value + $item_value;
                                    }
                                }
                            }
                        }
                    ?>
                    <p class="archive_lisnyctwa_item__title"><?php echo wordsTranslation($table_lisnyctwo); ?></p>
                    <p class="archive_lisnyctwa_item__subtitle">Загальні данні на данний момент</p>
                    <div class="archive_lisnyctwa_item__data">

                        <div class="archive_lisnyctwa_item__data--left">
                            <div class="archive_lisnyctwa_item__details_list">
                                <div class="archive_lisnyctwa_item__details_list_item">
                                    <p class="archive_lisnyctwa_item__total_list_item--name">Технологічна карта</p>
                                    <p class="archive_lisnyctwa_item__total_list_item--value">Петров А А</p>
                                </div>
                                <div class="archive_lisnyctwa_item__details_list_item">
                                    <p class="archive_lisnyctwa_item__total_list_item--name">Площа  Га</p>
                                    <p class="archive_lisnyctwa_item__total_list_item--value"><?php echo $total_ploshcha; ?></p>
                                </div>
                                <div class="archive_lisnyctwa_item__details_list_item">
                                    <p class="archive_lisnyctwa_item__total_list_item--name">Фактично заготовлено</p>
                                    <p class="archive_lisnyctwa_item__total_list_item--value"><?php echo totalBySortyment($db_connection, $_GET['rubka'], $table_lisnyctwo)['total']; ?></p>
                                </div>
                                <div class="archive_lisnyctwa_item__details_list_item">
                                    <p class="archive_lisnyctwa_item__total_list_item--name">Відхилення</p>
                                    <p class="archive_lisnyctwa_item__total_list_item--value">43 kbm</p>
                                </div>
                                <div class="archive_lisnyctwa_item__details_list_item">
                                    <p class="archive_lisnyctwa_item__total_list_item--name">Дозвіл</p>
                                    <p class="archive_lisnyctwa_item__total_list_item--value">43 kbm</p>
                                </div>
                            </div>
                        </div>

                        <div class="archive_lisnyctwa_item__data--right archive_lisnyctwa_item__data--total">
                            <p>Всього</p>
                            <div class="archive_lisnyctwa_item__total_list">
                                <?php foreach($total as $key => $value) { ?>
                                    <div class="archive_lisnyctwa_item__total_list_item">
                                        <p class="archive_lisnyctwa_item__total_list_item--name"><?php echo wordsTranslation($key); ?></p>
                                        <p class="archive_lisnyctwa_item__total_list_item--value"><?php echo $value; ?></p>
                                    </div>
                                <?php }; ?>
                            </div>
                        </div>
                    </div>
                    <div class="archive_lisnyctwa_item__btns">
                        <a href="dodajInfo.php?rubka=<?php echo $_GET['rubka']; ?>&lisnyctwo=<?php echo $table_lisnyctwo; ?>" class="archive_lisnyctwa_item__btns-edit">Додати данні</a>
                        <?php if(!$db_connection->checkIfTableIsEmpty($_GET['rubka'].'_'.$table_lisnyctwo)){ ?>
                            <a href="lisnyctwo.php?rubka=<?php echo $_GET['rubka']; ?>&lisnyctwo=<?php echo $table_lisnyctwo; ?>" class="archive_lisnyctwa_item__btns-view">Детальніше</a>
                        <?php } ?>
                    </div>
                </div>
            <?php
                }
            ?>
        </div>
    </div>
</section>

<?php include('parts/foot.php');?>
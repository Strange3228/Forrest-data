<?php include('parts/head.php');?>
<?php include('functions.php');?>
<?php checkIfUserIsLogged(); ?>
<?php $db_connection = new General; ?>
<?php $rubky = $db_connection->getRubky($_GET['rubka'] . '_' . $_GET['lisnyctwo']); ?>
<?php $table_data = $db_connection->getData($_GET['rubka'] . '_' . $_GET['lisnyctwo']); ?>
<?php $wordsWhichHasntTotals = ['sosna_volume','jalyna_volume','dub_volume','bereza_volume','vilha_volume','grab_volume','jasen_volume','klen_volume','osyka_volume','lypa_volume','inshe_volume','serednii_volume']; ?>

<section class="hidden_block" id="rubky">
    <?php foreach($rubky as $rubka){ ?>
        <div class="rubka">
            <p class="rubka_kv"><?php echo $rubka['kvartal']; ?></p>
            <p class="rubka_vy"><?php echo $rubka['vydil']; ?></p>
        </div>
    <?php } ?>
    
</section>
<section class="page_titles">
  <div class="container">
    <h1 class="page__title">Тип Рубки: <?php echo wordsTranslation($_GET['rubka']); ?></h1>
    <h3 class="page__subtitle">Лісництво: <?php echo wordsTranslation($_GET['lisnyctwo']); ?></h3>
    <p class="page__subsubtitle">Режим детального перегляду</p>
  </div>
</section>

<section class="single_edit">
    <div class="container">
        <?php if(!$db_connection->checkIfTableIsEmpty($_GET['rubka'].'_'.$_GET['lisnyctwo'])){ ?>
        <div class="accordeons">
            <div class="table_filters" id="filters">
                <p>Фільтруй по: </p>
                <select name="kvartals" class="filter_kvartals">
                    <option value="">Квартал...</option>
                    <?php $kvartalsArr = [];
                    foreach($rubky as $rubka){ if(!in_array($rubka['kvartal'], $kvartalsArr)) {
                        $kvartalsArr[] = $rubka['kvartal']; ?>
                        <option value="<?php echo $rubka['kvartal'] ?>"><?php echo $rubka['kvartal'] ?></option>
                    <?php }; } ?>
                </select>
                <select name="vydils" class="filter_vydils hidden">
                    <option value="">Виділ...</option>
                </select>
            </div>
            
            <!---------------------------- PORODY DEREVA ----------------------->
            <div class="accordeon">
                <div class="accordeon__main">
                    <p class="">Всього заготовлено</p>
                    <img src="./img/acc_arr.svg" alt="">
                </div>
                <div class="accordeon_content">
                    <div class="accordeon__table" id="view_full_table">
                        <?php
                            $allowedCoreTypes = allowedCoreDataNames();
                        ?>
                        <div class="table_wrapper">
                        <table class="data_table">
                            <thead>
                            <tr class="table_titles">
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                                <th colspan="11">Об'єм хлиста</th>
                                <th colspan="2"></th>
                                <?php foreach($table_data as $row) {
                                    $previousWord = '';
                                    foreach($row as $item_key => $item_value){
                                        if(isset($allowedCoreTypes[strtok($item_key, '_')])) {
                                            if($item_key != 'kvartal' && $item_key != 'vydil'  && $item_key != 'id'){
                                                if(strtok($item_key, '_') != $previousWord && $item_key != 'realizowano_liquidu' && $item_key != 'oczystka_lisosiky' && $item_key != 'pidhotovchi_roboty' && $item_key != 'ploshcha' && !in_array($item_key, $wordsWhichHasntTotals)){
                                                    $previousWord = strtok($item_key, '_');?>
                                                        <?php if(strtok($item_key, '_') != 'treliuvania') { ?>
                                                            <?php if(strpos($item_key,'chvorost') === 0) { ?>
                                                                <th colspan="4"><?php echo phraseTranslation(strtok($item_key, '_')); ?></th>
                                                            <?php } else { ?>
                                                                <th colspan="7"><?php echo phraseTranslation(strtok($item_key, '_')); ?></th>
                                                            <?php } ?>
                                                        <?php } ?>
                                                <?php } 
                                            };
                                        }    
                                    };
                                    break;
                                }; ?>
                                <th colspan="2"></th>
                            </tr>
                              <tr>
                                <th>Квартал</th>
                                <th>Виділ</th>
                                <?php foreach($table_data as $row) {
                                    $previousWord = '';
                                    foreach($row as $item_key => $item_value){
                                        if(isset($allowedCoreTypes[strtok($item_key, '_')])) {
                                            if($item_key != 'kvartal' && $item_key != 'vydil'  && $item_key != 'id'){
                                                if(strtok($item_key, '_') != $previousWord && $item_key != 'realizowano_liquidu' && $item_key != 'oczystka_lisosiky' && $item_key != 'pidhotovchi_roboty' && $item_key != 'ploshcha' && !in_array($item_key, $wordsWhichHasntTotals)){
                                                    $previousWord = strtok($item_key, '_');?>
                                                        <?php if(strtok($item_key, '_') != 'treliuvania') { ?>
                                                            <th class="type_total_column">Всього</th>
                                                        <?php } ?>
                                                    <th><?php echo phraseTranslation(substr($item_key,strpos($item_key, "_") + 1)); ?></th>
                                                <?php } else { ?>
                                                    <?php if (in_array(strtok($item_key, '_'), $allowedCoreTypes)) { ?>
                                                        <?php if(strtok($item_key, '_') != 'realizowano' && strtok($item_key, '_') != 'oczystka' && strtok($item_key, '_') != 'pidhotovchi' && strtok($item_key, '_') != 'ploshcha' && substr($item_key,strpos($item_key, "_") + 1) != 'volume') { ?>
                                                            <th><?php echo wordsTranslation(substr($item_key,strpos($item_key, "_") + 1)); ?></th>
                                                        <?php } else { ?>
                                                            <th><?php echo phraseTranslation($item_key); ?></th>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <th><?php echo phraseTranslation($item_key); ?></th>
                                                    <?php } ?>
                                                <?php }; 
                                            };
                                        }    
                                    };
                                    break;
                                }; ?>
                              </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $rows_total = totalSinglePorodaInLine($db_connection, $_GET['rubka'], $_GET['lisnyctwo']);
                                ?>
                                <?php foreach($rubky as $rubka){ ?>
                                    <tr class="total_row row-data" data-kwartal=<?php echo $rubka['kvartal']; ?> data-vydil=<?php echo $rubka['vydil']; ?>>
                                        <td><?php echo $rubka['kvartal'] ?></td>
                                        <td><?php echo $rubka['vydil'] ?></td>
                                    </tr>
                                    <?php
                                        $rubka_data = (object)[
                                            'kvartal' => $rubka['kvartal'] . ' AND ',
                                            'vydil' => $rubka['vydil']
                                        ];
                                        $table_data_current = $db_connection->getDataByColumns($_GET['rubka'] . '_' . $_GET['lisnyctwo'],$rubka_data);
                                    ?>
                                    <?php foreach($table_data_current as $row) { $row_id = $row['id']; $previousWord = ''; ?>
                                        <tr class="row-data row-data_js" data-kwartal=<?php echo $row['kvartal']; ?> data-vydil=<?php echo $row['vydil']; ?>>
                                            <td class="single_kvartal_number empty_cell"></td>
                                            <td class="single_vydil_number empty_cell"></td>
                                            <?php foreach($row as $item_key => $item_value){
                                                if(isset($allowedCoreTypes[strtok($item_key, '_')])) {
                                                if(strtok($item_key, '_') != $previousWord && $item_key != 'realizowano_liquidu' && $item_key != 'oczystka_lisosiky' && $item_key != 'pidhotovchi_roboty' && $item_key != 'ploshcha' && $item_key != 'kvartal' && $item_key != 'vydil' && $item_key != 'id' && !in_array($item_key, $wordsWhichHasntTotals)){ 
                                                    $previousWord = strtok($item_key, '_'); ?>
                                                    <?php if(strtok($item_key, '_') != 'treliuvania') { ?>
                                                    <td class="row_items_total"><?php echo $rows_total[$row_id][$previousWord]; ?></td>
                                                    <?php } ?>
                                                    <td><?php echo $item_value; ?></td>
                                                <?php } elseif($item_key != 'kvartal' && $item_key != 'vydil' && $item_key != 'id') { ?>
                                                    <td><?php echo $item_value; ?></td>
                                                <?php }
                                                }
                                            };?> 
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>

            <!----------------CHVOROST------------>
            <div class="accordeon">
                <div class="accordeon__main">
                    <p class="">Заготовлено хворосту</p>
                    <img src="./img/acc_arr.svg" alt="">
                </div>
                <div class="accordeon_content">
                    <div class="accordeon__table" id="view_full_table">
                    <div class="table_wrapper">
                    <table class="data_table">
                            <thead>
                              <tr>
                                <th>Квартал</th>
                                <th>Виділ</th>
                                <th>Хворост Ic</th>
                                <th>Хворост IIc</th>
                                <th>Хворост IIIc</th>
                                <th>Всього</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php foreach($rubky as $rubka){ ?>
                                    <tr class="total_row row-data" data-kwartal=<?php echo $rubka['kvartal']; ?> data-vydil=<?php echo $rubka['vydil']; ?>>
                                        <td><?php echo $rubka['kvartal'] ?></td>
                                        <td><?php echo $rubka['vydil'] ?></td>
                                    </tr>
                                    <?php
                                        $rubka_data = (object)[
                                            'kvartal' => $rubka['kvartal'] . ' AND ',
                                            'vydil' => $rubka['vydil']
                                        ];
                                        $table_data_current = $db_connection->getDataByColumns($_GET['rubka'] . '_' . $_GET['lisnyctwo'],$rubka_data);
                                    ?>
                                    <?php foreach($table_data_current as $row) { $row_id = $row['id']; $previousWord = ''; ?>
                                    <tr class="row-data row-data_js" data-kwartal=<?php echo $row['kvartal']; ?> data-vydil=<?php echo $row['vydil']; ?>>
                                        <td></td>
                                        <td></td>
                                        <td><?php echo $row['chvorost_1c']; ?></td>
                                        <td><?php echo $row['chvorost_2c']; ?></td>
                                        <td><?php echo $row['chvorost_3c']; ?></td>
                                        <td>
                                            <?php
                                            $total_chvorost_in_row = $row['chvorost_1c'] + $row['chvorost_2c'] + $row['chvorost_3c'];
                                            echo $total_chvorost_in_row;
                                            ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>

            <!---------------------Всього по сортименту---------------------->
            <div class="accordeon">
                <div class="accordeon__main">
                    <p class="">Всього по сортименту</p>
                    <img src="./img/acc_arr.svg" alt="">
                </div>
                <div class="accordeon_content">
                    <div class="accordeon__table" id="view_full_table">
                        <div class="table_wrapper">
                        <table class="data_table">
                            <thead>
                              <tr>
                                <th>Квартал</th>
                                <th>Виділ</th>
                                <th class="">Всього</th>
                                <th class="dilova_column">Ділова</th>
                                <th>A</th>
                                <th>B</th>
                                <th>C</th>
                                <th>D</th>
                                <th>ПВ</th>
                                <th>НП</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $totalSortyments = totalBySortyment($db_connection, $_GET['rubka'], $_GET['lisnyctwo']);
                                    $totalBySortymentInRow = totalBySortymentInRow($db_connection, $_GET['rubka'], $_GET['lisnyctwo']);
                                ?>
                                <?php foreach($rubky as $rubka){ ?>
                                    <tr class="total_row row-data" data-kwartal=<?php echo $rubka['kvartal']; ?> data-vydil=<?php echo $rubka['vydil']; ?>>
                                        <td><?php echo $rubka['kvartal']; ?></td>
                                        <td><?php echo $rubka['vydil']; ?></td>
                                    </tr>
                                    <?php
                                        $rubka_data = (object)[
                                            'kvartal' => $rubka['kvartal'] . ' AND ',
                                            'vydil' => $rubka['vydil']
                                        ];
                                        $table_data_current = $db_connection->getDataByColumns($_GET['rubka'] . '_' . $_GET['lisnyctwo'],$rubka_data);
                                    ?>
                                    <?php foreach($table_data_current as $row) { $row_id = $row['id'];  $singleRowTotals = $totalBySortymentInRow[$row_id]; ?>
                                        <tr class="row-data row-data_js" data-kwartal=<?php echo $row['kvartal']; ?> data-vydil=<?php echo $row['vydil']; ?>>
                                            <td></td>
                                            <td></td>
                                            <td class=""><?php echo $singleRowTotals['total']; ?></td>
                                            <td class="dilova_column"><?php echo $singleRowTotals['dilova']; ?></td>
                                            <td><?php echo $singleRowTotals['a']; ?></td>
                                            <td><?php echo $singleRowTotals['b']; ?></td>
                                            <td><?php echo $singleRowTotals['c']; ?></td>
                                            <td><?php echo $singleRowTotals['d']; ?></td>
                                            <td><?php echo $singleRowTotals['pv']; ?></td>
                                            <td><?php echo $singleRowTotals['np']; ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>

            <!----------------------ЗАЛИШОК---------------------------------->
            <div class="accordeon">
                <div class="accordeon__main">
                    <p class="">ЗАЛИШОК КУБОМАСИ ВІДНОСНО ВІДВОДУ КБМ / %</p>
                    <img src="./img/acc_arr.svg" alt="">
                </div>
                <div class="accordeon_content">
                    <div class="accordeon__table ostatky_table" id="view_full_table">
                        <?php
                            foreach($rubky as $rubka){
                                $kvytokData = getKvytokData($db_connection,$_GET['lisnyctwo'], $rubka['kvartal'], $rubka['vydil']);
                                if(!empty($kvytokData)){
                                    $dataByKvytokNumber = getDataByKvytokNumber($db_connection, $_GET['rubka'] . '_' . $_GET['lisnyctwo'], $rubka['kvartal'], $rubka['vydil']);
                                    $filteredDataTotals = getTotalPorodyAfterFilterKvytok($dataByKvytokNumber);
                                    $differences = []; ?>
                                    <div class="row-data" data-kwartal=<?php echo $rubka['kvartal']; ?> data-vydil=<?php echo $rubka['vydil']; ?>>
                                        <p class="numer_kvytka">Лісорубний Квиток для Квартал <?php echo $rubka['kvartal'] ?>, Виділ <?php echo $rubka['vydil'] ?></p>
                                        <div class="table_wrapp">
                                        <table class="ostatky_table">
                                        <thead>
                                          <tr>
                                            <th>Сосна</th>
                                            <th>B т.ч. діл</th>
                                            <th>Ялина</th>
                                            <th>B т.ч. діл</th>
                                            <th>Дуб</th>
                                            <th>B т.ч. діл</th>
                                            <th>Береза</th>
                                            <th>B т.ч. діл</th>
                                            <th>Вільха</th>
                                            <th>B т.ч. діл</th>
                                            <th>Граб</th>
                                            <th>B т.ч. діл</th>
                                            <th>Ясен</th>
                                            <th>B т.ч. діл</th>
                                            <th>Клен</th>
                                            <th>B т.ч. діл</th>
                                            <th>Осика</th>
                                            <th>B т.ч. діл</th>
                                            <th>Липа</th>
                                            <th>B т.ч. діл</th>
                                            <th>Інші</th>
                                            <th>B т.ч. діл</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="ostatky_table--totals">
                                            <td>
                                                <?php $difference=$filteredDataTotals['all']['sosna'] - $kvytokData[0]['sosna']; echo $difference; ?>
                                            </td>
                                            <td>
                                                <?php $difference=$filteredDataTotals['dilova']['sosna'] - $kvytokData[0]['sosna_dilova']; echo $difference;?>
                                            </td>
                                            <td>
                                                <?php $difference=$filteredDataTotals['all']['jalyna'] - $kvytokData[0]['jalyna']; echo $difference;?>
                                            </td>
                                            <td>
                                                <?php $difference=$filteredDataTotals['dilova']['jalyna'] - $kvytokData[0]['jalyna_dilova']; echo $difference;?>
                                            </td>
                                            <td>
                                                <?php $difference=$filteredDataTotals['all']['dub'] - $kvytokData[0]['dub']; echo $difference;?>
                                            </td>
                                            <td>
                                                <?php $difference=$filteredDataTotals['dilova']['dub'] - $kvytokData[0]['dub_dilova']; echo $difference;?>
                                            </td>
                                            <td>
                                                <?php $difference=$filteredDataTotals['all']['bereza'] - $kvytokData[0]['bereza']; echo $difference;?>
                                            </td>
                                            <td>
                                                <?php $difference=$filteredDataTotals['dilova']['bereza'] - $kvytokData[0]['bereza_dilova']; echo $difference;?>
                                            </td>
                                            <td>
                                                <?php $difference=$filteredDataTotals['all']['vilha'] - $kvytokData[0]['vilha']; echo $difference;?>
                                            </td>
                                            <td>
                                                <?php $difference=$filteredDataTotals['dilova']['vilha'] - $kvytokData[0]['vilha_dilova']; echo $difference;?>
                                            </td>
                                            <td>
                                                <?php $difference=$filteredDataTotals['all']['grab'] - $kvytokData[0]['grab']; echo $difference;?>
                                            </td>
                                            <td>
                                                <?php $difference=$filteredDataTotals['dilova']['grab'] - $kvytokData[0]['grab_dilova']; echo $difference;?>
                                            </td>
                                            <td>
                                                <?php $difference=$filteredDataTotals['all']['jasen'] - $kvytokData[0]['jasen']; echo $difference;?>
                                            </td>
                                            <td>
                                                <?php $difference=$filteredDataTotals['dilova']['jasen'] - $kvytokData[0]['jasen_dilova']; echo $difference;?>
                                            </td>
                                            <td>
                                                <?php $difference=$filteredDataTotals['all']['klen'] - $kvytokData[0]['klen']; echo $difference;?>
                                            </td>
                                            <td>
                                                <?php $difference=$filteredDataTotals['dilova']['klen'] - $kvytokData[0]['klen_dilova']; echo $difference;?>
                                            </td>
                                            <td>
                                                <?php $difference=$filteredDataTotals['all']['osyka'] - $kvytokData[0]['osyka']; echo $difference;?>
                                            </td>
                                            <td>
                                                <?php $difference=$filteredDataTotals['dilova']['osyka'] - $kvytokData[0]['osyka_dilova']; echo $difference;?>
                                            </td>
                                            <td>
                                                <?php $difference=$filteredDataTotals['all']['lypa'] - $kvytokData[0]['lypa']; echo $difference;?>
                                            </td>
                                            <td>
                                                <?php $difference=$filteredDataTotals['dilova']['lypa'] - $kvytokData[0]['lypa_dilova']; echo $difference;?>
                                            </td>
                                            <td>
                                                <?php $difference=$filteredDataTotals['all']['inshe'] - $kvytokData[0]['inshe']; echo $difference;?>
                                            </td>
                                            <td>
                                                <?php $difference=$filteredDataTotals['dilova']['inshe'] - $kvytokData[0]['inshe_dilova']; echo $difference;?>
                                            </td>
                                            </tr>
                                            <tr class="ostatky_table--percentage">
                                                <td>
                                                    <?php echo round((($filteredDataTotals['all']['sosna'] - $kvytokData[0]['sosna'])/($kvytokData[0]['sosna']+0.00001))*100,2).'%'; ?>
                                                </td>
                                                <td>
                                                    <?php echo round((($filteredDataTotals['dilova']['sosna'] - $kvytokData[0]['sosna_dilova'])/($kvytokData[0]['sosna_dilova']+0.00001))*100,2).'%';?>
                                                </td>
                                                <td>
                                                    <?php echo round((($filteredDataTotals['all']['jalyna'] - $kvytokData[0]['jalyna'])/($kvytokData[0]['jalyna']+0.00001))*100,2).'%';?>
                                                </td>
                                                <td>
                                                    <?php echo round((($filteredDataTotals['dilova']['jalyna'] - $kvytokData[0]['jalyna_dilova'])/($kvytokData[0]['jalyna_dilova']+0.00001))*100,2).'%'?>
                                                </td>
                                                <td>
                                                    <?php echo round((($filteredDataTotals['all']['dub'] - $kvytokData[0]['dub'])/($kvytokData[0]['dub']+0.00001))*100,2).'%';?>
                                                </td>
                                                <td>
                                                    <?php echo round((($filteredDataTotals['dilova']['dub'] - $kvytokData[0]['dub_dilova'])/($kvytokData[0]['dub_dilova']+0.00001))*100,2).'%';?>
                                                </td>
                                                <td>
                                                    <?php echo round((($filteredDataTotals['all']['bereza'] - $kvytokData[0]['bereza'])/($kvytokData[0]['bereza']+0.00001))*100,2).'%';?>
                                                </td>
                                                <td>
                                                    <?php echo round((($filteredDataTotals['dilova']['bereza'] - $kvytokData[0]['bereza_dilova'])/($kvytokData[0]['bereza_dilova']+0.00001))*100,2).'%';?>
                                                </td>
                                                <td>
                                                    <?php echo round((($filteredDataTotals['all']['vilha'] - $kvytokData[0]['vilha'])/($kvytokData[0]['vilha']+0.00001))*100,2).'%';?>
                                                </td>
                                                <td>
                                                    <?php echo round((($filteredDataTotals['dilova']['vilha'] - $kvytokData[0]['vilha_dilova'])/($kvytokData[0]['vilha_dilova']+0.00001))*100,2).'%';?>
                                                </td>
                                                <td>
                                                    <?php echo round((($filteredDataTotals['all']['grab'] - $kvytokData[0]['grab'])/($kvytokData[0]['grab']+0.00001))*100,2).'%';?>
                                                </td>
                                                <td>
                                                    <?php echo round((($filteredDataTotals['dilova']['grab'] - $kvytokData[0]['grab_dilova'])/($kvytokData[0]['grab_dilova']+0.00001))*100,2).'%';?>
                                                </td>
                                                <td>
                                                    <?php echo round((($filteredDataTotals['all']['jasen'] - $kvytokData[0]['jasen'])/($kvytokData[0]['jasen']+0.00001))*100,2).'%';?>
                                                </td>
                                                <td>
                                                    <?php echo round((($filteredDataTotals['dilova']['jasen'] - $kvytokData[0]['jasen_dilova'])/($kvytokData[0]['jasen_dilova']+0.00001))*100,2).'%';?>
                                                </td>
                                                <td>
                                                    <?php echo round((($filteredDataTotals['all']['klen'] - $kvytokData[0]['klen'])/($kvytokData[0]['klen']+0.00001))*100,2).'%';?>
                                                </td>
                                                <td>
                                                    <?php echo round((($filteredDataTotals['dilova']['klen'] - $kvytokData[0]['klen_dilova'])/($kvytokData[0]['klen_dilova']+0.00001))*100,2).'%';?>
                                                </td>
                                                <td>
                                                    <?php echo round((($filteredDataTotals['all']['osyka'] - $kvytokData[0]['osyka'])/($kvytokData[0]['osyka']+0.00001))*100,2).'%';?>
                                                </td>
                                                <td>
                                                    <?php echo round((($filteredDataTotals['dilova']['osyka'] - $kvytokData[0]['osyka_dilova'])/($kvytokData[0]['osyka_dilova']+0.00001))*100,2).'%';?>
                                                </td>
                                                <td>
                                                    <?php echo round((($filteredDataTotals['all']['lypa'] - $kvytokData[0]['lypa'])/($kvytokData[0]['lypa']+0.00001))*100,2).'%';?>
                                                </td>
                                                <td>
                                                    <?php echo round((($filteredDataTotals['dilova']['lypa'] - $kvytokData[0]['lypa_dilova'])/($kvytokData[0]['lypa_dilova']+0.00001))*100,2).'%';?>
                                                </td>
                                                <td>
                                                    <?php echo round((($filteredDataTotals['all']['inshe'] - $kvytokData[0]['inshe'])/($kvytokData[0]['inshe']+0.00001))*100,2).'%';?>
                                                </td>
                                                <td>
                                                    <?php echo round((($filteredDataTotals['dilova']['inshe'] - $kvytokData[0]['inshe_dilova'])/($kvytokData[0]['inshe_dilova']+0.00001))*100,2).'%';?>
                                                </td>
                                            </tr>
                                        </tbody>
                                        </table>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="kvytok_not_found row-data" data-kwartal=<?php echo 0; ?> data-vydil=<?php echo 0; ?>>
                                        <p class="">Для Квартал <?php echo $rubka['kvartal'] ?>, Виділ <?php echo $rubka['vydil'] ?> не було знайдено квитка</p>
                                        <a href="create-ticket.php?lisnyctwo=<?php echo $_GET['lisnyctwo'] ?>&kvartal=<?php echo $rubka['kvartal'] ?>&vydil=<?php echo $rubka['vydil'] ?>">Створити</a>
                                    </div>
                                <?php } ?>
                            <?php }
                        ?>
                    </div>
                </div>
            </div>

            <div class="accordeon">
                <div class="accordeon__main">
                    <p class="">Залишок хворосту</p>
                    <img src="./img/acc_arr.svg" alt="">
                </div>
                <div class="accordeon_content">
                    <div class="accordeon__table ostatky_table" id="view_full_table">
                    <?php
                            foreach($rubky as $rubka){
                                $kvytokData = getKvytokData($db_connection,$_GET['lisnyctwo'], $rubka['kvartal'], $rubka['vydil']);
                                $totalPorody = TotalEveryType($db_connection, $_GET['rubka'], $_GET['lisnyctwo']);
                                $columns_total = totalInColumn($db_connection, $totalPorody, null, $_GET['rubka'], $_GET['lisnyctwo']);
                                $chvorost1 = $columns_total['chvorost_1c'];
                                $chvorost2 = $columns_total['chvorost_2c'];
                                $chvorost3 = $columns_total['chvorost_3c'];
                                $chvorost_total = $columns_total['chvorostsectiontotal'];
                                if(!empty($kvytokData)){
                                    $dataByKvytokNumber = getDataByKvytokNumber($db_connection, $_GET['rubka'] . '_' . $_GET['lisnyctwo'], $rubka['kvartal'], $rubka['vydil']);
                                    $filteredDataTotals = getTotalPorodyAfterFilterKvytok($dataByKvytokNumber);
                                    $differences = []; ?>
                                    <div class="row-data" data-kwartal=<?php echo $rubka['kvartal']; ?> data-vydil=<?php echo $rubka['vydil']; ?>>
                                        <p class="numer_kvytka">Лісорубний Квиток для Квартал <?php echo $rubka['kvartal'] ?>, Виділ <?php echo $rubka['vydil'] ?></p>
                                        <div class="table_wrapp">
                                        <table class="ostatky_table">
                                        <thead>
                                          <tr>
                                            <th>Хворост Ic</th>
                                            <th>Хворост IIc</th>
                                            <th>Хворост IIIc</th>
                                            <th>Всього</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="ostatky_table--totals">
                                                <td>
                                                    <?php $difference=$chvorost1 - $kvytokData[0]['chvorost_1c']; echo $difference; ?>
                                                </td>
                                                <td>
                                                    <?php $difference=$chvorost2 - $kvytokData[0]['chvorost_2c']; echo $difference;?>
                                                </td>
                                                <td>
                                                    <?php $difference=$chvorost3 - $kvytokData[0]['chvorost_3c']; echo $difference;?>
                                                </td>
                                                <td>
                                                    <?php $difference=$chvorost_total - $kvytokData[0]['total_chvorost']; echo $difference;?>
                                                </td>
                                            </tr>
                                            <tr class="ostatky_table--percentage">
                                                <td>
                                                    <?php echo round((($chvorost1 - $kvytokData[0]['chvorost_1c'])/($kvytokData[0]['chvorost_1c']+0.00001))*100,2).'%'; ?>
                                                </td>
                                                <td>
                                                    <?php echo round((($chvorost2 - $kvytokData[0]['chvorost_2c'])/($kvytokData[0]['chvorost_2c']+0.00001))*100,2).'%';?>
                                                </td>
                                                <td>
                                                    <?php echo round((($chvorost3 - $kvytokData[0]['chvorost_3c'])/($kvytokData[0]['chvorost_3c']+0.00001))*100,2).'%';?>
                                                </td>
                                                <td>
                                                    <?php echo round((($chvorost_total - $kvytokData[0]['total_chvorost'])/($kvytokData[0]['total_chvorost']+0.00001))*100,2).'%'?>
                                                </td>
                                            </tr>
                                        </tbody>
                                        </table>
                                        </div>
                                    </div>
                                <?php } else {  ?>
                                    <div class="kvytok_not_found row-data" data-kwartal=<?php echo 0; ?> data-vydil=<?php echo 0; ?>>
                                        <p class="">Для Квартал <?php echo $rubka['kvartal'] ?>, Виділ <?php echo $rubka['vydil'] ?> не було знайдено квитка</p>
                                        <a href="create-ticket.php?lisnyctwo=<?php echo $_GET['lisnyctwo'] ?>&kvartal=<?php echo $rubka['kvartal'] ?>&vydil=<?php echo $rubka['vydil'] ?>">Створити</a>
                                    </div>
                                <?php }; ?>
                            <?php }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php } else { ?>
            <div class="table_is_empty_notification">
                <p>Ця таблиця Пуста. Будь ласка додайте данні</p>
                <a href="dodajInfo.php?rubka=<?php echo $_GET['rubka']; ?>&lisnyctwo=<?php echo $_GET['lisnyctwo']; ?>" class="archive_lisnyctwa_item__btns-edit">Додати данні</a>
            </div>
        <?php } ?>
    </div>
</section>

<?php include('parts/foot.php');?>
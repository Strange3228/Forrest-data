<?php include('parts/head.php');?>
<?php include('functions.php');?>
<?php checkIfUserIsLogged(); ?>
<?php $db_connection = new General; ?>
<?php $rubky = $db_connection->getRubky($_GET['rubka'] . '_' . $_GET['lisnyctwo']);
console_log($rubky) ?>
<?php $table_data = $db_connection->getData($_GET['rubka'] . '_' . $_GET['lisnyctwo']); ?>

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
                        <table>
                            <thead>
                              <tr>
                                <th>Квартал</th>
                                <th>Виділ</th>
                                <?php foreach($table_data as $row) {
                                    $previousWord = '';
                                    foreach($row as $item_key => $item_value){
                                        if(isset($allowedCoreTypes[strtok($item_key, '_')])) {
                                            if($item_key != 'kvartal' && $item_key != 'vydil'  && $item_key != 'id'){
                                                if(strtok($item_key, '_') != $previousWord && $item_key != 'realizowano_liquidu' && $item_key != 'oczystka_lisosiky' && $item_key != 'pidhotovchi_roboty' && $item_key != 'ploshcha'){
                                                    $previousWord = strtok($item_key, '_');?>
                                                        <?php if(strtok($item_key, '_') != 'treliuvania') { ?>
                                                            <th class="type_total_column"><?php echo phraseTranslation(strtok($item_key, '_')) . ' Всього'; ?></th>
                                                        <?php } ?>
                                                    <th><?php echo phraseTranslation($item_key); ?></th>
                                                <?php } else { ?>
                                                <th><?php echo phraseTranslation($item_key); ?></th>
                                            <?php }; };
                                        }    
                                    };
                                    break;
                                }; ?>
                              </tr>
                            </thead>
                            <tbody>
                              <tr class="total_row">
                                <td colspan="2">Всього</td>
                                <?php
                                $totalPorody = TotalEveryType($db_connection, $_GET['rubka'], $_GET['lisnyctwo']);
                                $columns_total = totalInColumn($db_connection, $totalPorody, null, $_GET['rubka'], $_GET['lisnyctwo']);
                                foreach($columns_total as $key => $value) { ?>
                                    <td class="<?php if(strpos($key, 'sectiontotal')) {echo 'section_total'; } ?>"><?php echo $value; ?></td>
                                <?php }
                                ?>
                              </tr>
                              <?php
                                $rows_total = totalSinglePorodaInLine($db_connection, $_GET['rubka'], $_GET['lisnyctwo']);
                              ?>
                              <?php foreach($table_data as $row) { $row_id = $row['id']; $previousWord = ''; ?>
                                <tr class="row-data" data-kwartal=<?php echo $row['kvartal']; ?> data-vydil=<?php echo $row['vydil']; ?>>
                                    <td class="single_kvartal_number"><?php echo $row['kvartal']; ?></td>
                                    <td class="single_vydil_number"><?php echo $row['vydil']; ?></td>
                                    <?php foreach($row as $item_key => $item_value){
                                        if(isset($allowedCoreTypes[strtok($item_key, '_')])) {
                                        if(strtok($item_key, '_') != $previousWord && $item_key != 'realizowano_liquidu' && $item_key != 'oczystka_lisosiky' && $item_key != 'pidhotovchi_roboty' && $item_key != 'ploshcha' && $item_key != 'kvartal' && $item_key != 'vydil' && $item_key != 'id'){ 
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
                                <?php }; ?>
                            </tbody>
                        </table>
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
                    <table>
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
                              <tr class="total_row">
                                <td colspan="2">Всього</td>
                                <?php
                                    $totalPorody = TotalEveryType($db_connection, $_GET['rubka'], $_GET['lisnyctwo']);
                                    $columns_total = totalInColumn($db_connection, $totalPorody, null, $_GET['rubka'], $_GET['lisnyctwo']);
                                    $chvorost1 = $columns_total['chvorost_1c'];
                                    $chvorost2 = $columns_total['chvorost_2c'];
                                    $chvorost3 = $columns_total['chvorost_3c'];
                                    $chvorost_total = $columns_total['chvorostsectiontotal'];
                                ?>
                                <td><?php echo $columns_total['chvorost_1c']; ?></td>
                                <td><?php echo $columns_total['chvorost_2c']; ?></td>
                                <td><?php echo $columns_total['chvorost_3c']; ?></td>
                                <td><?php echo $columns_total['chvorostsectiontotal']; ?></td>
                              </tr>
                              <?php foreach($table_data as $row) { $row_id = $row['id']; $previousWord = ''; ?>
                                <tr class="row-data" data-kwartal=<?php echo $row['kvartal']; ?> data-vydil=<?php echo $row['vydil']; ?>>
                                    <td><?php echo $row['kvartal']; ?></td>
                                    <td><?php echo $row['vydil']; ?></td>
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
                                <?php }; ?>
                            </tbody>
                        </table>
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
                        <table style="width:100%; table-layout:fixed">
                            <thead>
                              <tr>
                                <th>Квартал</th>
                                <th>Виділ</th>
                                <th class="total_row">Всього</th>
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
                              <tr class="total_row">
                                <?php
                                    $totalSortyments = totalBySortyment($db_connection, $_GET['rubka'], $_GET['lisnyctwo']);
                                ?>
                                <td colspan="2">Всього</td>
                                <td class="total_row"><?php echo $totalSortyments['total']; ?></td>
                                <td class="dilova_column"><?php echo $totalSortyments['dilova']; ?></td>
                                <td><?php echo $totalSortyments['a']; ?></td>
                                <td><?php echo $totalSortyments['b']; ?></td>
                                <td><?php echo $totalSortyments['c']; ?></td>
                                <td><?php echo $totalSortyments['d']; ?></td>
                                <td><?php echo $totalSortyments['pv']; ?></td>
                                <td><?php echo $totalSortyments['np']; ?></td>
                              </tr>
                              <?php $totalBySortymentInRow = totalBySortymentInRow($db_connection, $_GET['rubka'], $_GET['lisnyctwo']); ?>
                              <?php foreach($table_data as $row) { $row_id = $row['id'];  $singleRowTotals = $totalBySortymentInRow[$row_id]; ?>
                                <tr class="row-data" data-kwartal=<?php echo $row['kvartal']; ?> data-vydil=<?php echo $row['vydil']; ?>>
                                    <td><?php echo $row['kvartal']; ?></td>
                                    <td><?php echo $row['vydil']; ?></td>
                                    <td class="total_row"><?php echo $singleRowTotals['total']; ?></td>
                                    <td class="dilova_column"><?php echo $singleRowTotals['dilova']; ?></td>
                                    <td><?php echo $singleRowTotals['a']; ?></td>
                                    <td><?php echo $singleRowTotals['b']; ?></td>
                                    <td><?php echo $singleRowTotals['c']; ?></td>
                                    <td><?php echo $singleRowTotals['d']; ?></td>
                                    <td><?php echo $singleRowTotals['pv']; ?></td>
                                    <td><?php echo $singleRowTotals['np']; ?></td>
                                </tr>
                                <?php }; ?>
                            </tbody>
                        </table>
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
                    <div class="accordeon__table" id="view_full_table">
                        <?php
                            $kvytky_numbers = getKvytkyForLisnyctwo($db_connection, $_GET['rubka'] . '_' . $_GET['lisnyctwo']);
                            foreach($kvytky_numbers as $single_kvytok){
                                $kvytokData = getKvytokData($db_connection, $single_kvytok);
                                $dataByKvytokNumber = getDataByKvytokNumber($db_connection, $_GET['rubka'] . '_' . $_GET['lisnyctwo'], $single_kvytok);
                                $filteredDataTotals = getTotalPorodyAfterFilterKvytok($dataByKvytokNumber);
                                $differences = []; ?>
                                <p class="numer_kvytka">Номер Лісорубного Квитка: №<?php echo $single_kvytok; ?></p>
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
                    <div class="accordeon__table" id="view_full_table">
                    <?php
                            $kvytky_numbers = getKvytkyForLisnyctwo($db_connection, $_GET['rubka'] . '_' . $_GET['lisnyctwo']);
                            foreach($kvytky_numbers as $single_kvytok){
                                $kvytokData = getKvytokData($db_connection, $single_kvytok);
                                $dataByKvytokNumber = getDataByKvytokNumber($db_connection, $_GET['rubka'] . '_' . $_GET['lisnyctwo'], $single_kvytok);
                                $filteredDataTotals = getTotalPorodyAfterFilterKvytok($dataByKvytokNumber);
                                $differences = []; ?>
                                <p class="numer_kvytka">Номер Лісорубного Квитка: №<?php echo $single_kvytok; ?></p>
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
                            <?php }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('parts/foot.php');?>
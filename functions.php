<?php 

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
/*DB CLASS */
class General {

	public $dbs;
    public $baseUrl;
    public $userIp;

    public function __construct() {
        $this->dbs = new PDO('mysql:dbname=forrest_data;host=localhost', 'root', 'phpmyadmin');
        $this->dbs->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->baseUrl = 'http://localhost/forrest_data/';
        $this->userIp = $this->getUserIpAddr();
    }

    private function getUserIpAddr(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        return $_SERVER['REMOTE_ADDR'];
    }

    public function recordExists($column,$column_name,$param) {
        $sql = "SELECT SQL_CALC_FOUND_ROWS id FROM $column WHERE `$column_name`='$param'";
        $sth = $this->dbs->prepare($sql);
        $sth->execute();
        $result = $this->dbs->prepare("SELECT FOUND_ROWS()");
        $result->execute();
        if ($result->fetchColumn() > 0) {
            return true;
        }
        return false;
    }

    public function getData($column,$param = null,$limit = 0,$join = null,$and = null,$offset = 0) {
        $sql = "SELECT * FROM `$column`";
        if (!is_null($join)) {
            $sql = "SELECT `$column`.*";
            foreach ($join as $k => $v) {
                $sql .= ", `$k`.name AS $v";
                $leftJoin .= " LEFT JOIN $k ON (`$k`.id=`$column`.".$k."_id)";
            }
            $sql .= " FROM `$column` $leftJoin";
        }
        $where = ' WHERE';
        if (!is_null($param)) {
            $sql .= " WHERE `$column`.id=:id";
            $where = 'AND';
        }
        if (!is_null($and)) {
            foreach ($and as $andKey => $andVal) {
                $sql .= " $where `$column`.$andKey=:$andKey";
                $where = 'AND';
            }
        }
        if ($offset != 0) {
            $sql .= " LIMIT :off, :lim";
        }
        $sth = $this->dbs->prepare($sql);
        if (!is_null($param)) $sth->bindParam(':id', $param);
        if (!is_null($and)) {
            foreach ($and as $andKey => $andVal) {
                $sth->bindParam(':'.$andKey, $andVal);
            }
        }
        if ($offset != 0) {
            if (is_null($limit)) $limit = 1;
            $sth->bindValue(':off', $offset, PDO::PARAM_INT);
            $sth->bindValue(':lim', $limit, PDO::PARAM_INT);
        }
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $results = $sth->fetchAll();
        if ($limit == 1) {
            return $results[0];
        }
        return $results;
    }

    public function insertData($column,$data) {
        foreach ($data as $k => $v) {
            $a .= (!empty($a)) ? ', '.$k : $k;
            $b .= (!empty($b)) ? ', :'.$k : ':'.$k;
        }
        $sth = $this->dbs->prepare("INSERT INTO $column ($a) VALUES ($b)");
        if ($sth->execute($data)) {
            return true;
        }
        return false;
    }

    public function updateData($column,$data,$param) {
        foreach ($data as $k => $v) {
            $a .= (!empty($a)) ? ', `'.$k.'`=:'.$k : '`'.$k.'`=:'.$k;
        }
        $sth = $this->dbs->prepare("UPDATE $column SET $a WHERE id=$param");
        if ($sth->execute($data)) {
            return true;
        }
        return false;
    }

    public function prepareUrl($url) {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
              $url = "http://" . $url;
        }
        return $url;
    }

    public function shorter($text,$chars_limit=250) {
        if (strlen($text) > $chars_limit)
        {
            $new_text = substr($text, 0, $chars_limit);
            $new_text = trim($new_text);
            return $new_text . "...";
        }
        return $text;
    }
    
    public function deleteRow($column, $column_name, $param){
        $sql = "DELETE FROM $column WHERE `$column_name`='$param'";
        $sth = $this->dbs->prepare($sql);
        $sth->execute();
        /*if ($sth->execute()) {
            return true;
        }
        return false;*/
    }

    public function getTableNames($str){
        $sql = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE '%$str%'";
        $sth = $this->dbs->prepare($sql);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $results = $sth->fetchAll();
        return $results;
    }
    
    public function getRubky($table_name){
        $sql = "SELECT `kvartal`, `vydil` FROM `$table_name` WHERE 1";
        $sth = $this->dbs->prepare($sql);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $results = $sth->fetchAll();
        return array_unique($results, SORT_REGULAR);
    }
}

function checkIfUserIsLogged() {
    if (!isset($_SESSION['user_name'])) {
        header("Location: login-page.php");
    } else {
        return true;
    }
}

function wordsTranslation( $word ){
    switch ($word) {
        case 'bereza':
            return 'Береза';
        case 'grab':
            return 'Граб';
        case 'jasen':
            return 'Ясен';
        case 'oczystka_lisosiky':
            return 'Очистка лісосіки';
        case 'realizowano_liquidu':
            return 'Реалізовано ліквіду';
        case 'chvorost':
            return 'Хворост';
        case 'inshe':
            return 'Інше';
        case 'klen':
            return 'Клен';
        case 'osyka':
            return 'Осика';
        case 'sosna':
            return 'Сосна';
        case 'dub':
            return 'Дуб';
        case 'jalyna':
            return 'Ялина';
        case 'lypa':
            return 'Липа';
        case 'pidhotovchi_roboty':
            return 'Підготовчі роботи';
        case 'vilha':
            return 'Вільха';
        case 'ploshcha':
            return 'Площа';
        case 'np':
            return 'НП';
        case 'pv':
            return 'ПВ';
        case 'treliuvania':
            return 'Трелювання';
        case '1c':
            return 'Ic';
        case '2c':
            return 'IIc';
        case '3c':
            return 'IIIc';
        case 'myhelskie':
            return 'Михельське';
        case 'osvitlenia':
            return 'Освітлення';
        case 'proridzuvania':
            return 'Проріджування';
        case 'golovnekorystuvania':
            return 'Головне користування';
        case 'inshibezlisgosp':
            return 'інші рубки не повязані з веденням лісового господарства';
        case 'inshizlisgosp':
            return 'Інші рубки повязані з веденням лісового господарства';
        case 'prochidna':
            return 'Прохідна';
        case 'rozchyshcheniaelektroperedach':
            return 'Розчищення лінії електропередач';
        case 'rozhyraniadorogy':
            return 'Розширення дороги';
        case 'rozrubkakvartalnychlinij':
            return 'Розрубка квартальних ліній';
        case 'sucilnasanitarna':
            return 'Суцільна санітарна';
        case 'vybirkovasanitarna':
            return 'Вибіркова санітарна';
        case 'lutarskie':
            return 'Лютарське';
        case 'bilohirskie':
            return 'Білогірське';
        case 'gurshchanskie':
            return 'Гурщанське';
        case 'klynovetskie':
            return 'Клиновецьке';
        case 'kunivskie':
            return 'Кунівське';
        case 'pluznianskie':
            return 'Плужнянське';
        case 'pokoshchivskie':
            return 'Покощівське';
        default:
            return $word;
    }
    return $word;
}

function phraseTranslation( $phrase ){
    $translated = wordsTranslation($phrase);
    if($translated != $phrase){
        return $translated;
    } else {
        $translatedString = '';
        $separated = explode('_', $phrase);
        foreach($separated as $word){
            $word = wordsTranslation($word) . ' ';
            $translatedString .= $word;
        }
        return $translatedString;
    }
}

function allowedCoreDataNames(){
    $allowedCoreDataNames = array(
        'bereza' => 0,
        'chvorost' => 0,
        'dub' => 0,
        'grab' => 0,
        'inshe' => 0,
        'jalyna' => 0,
        'jasen' => 0,
        'klen' => 0,
        'lypa' => 0,
        'oczystka' => 0,
        'osyka' => 0,
        'pidhotovchi' => 0,
        'realizowano' => 0,
        'sosna' => 0,
        'vilha' => 0,
        'treliuvania' => 0,
        'ploshcha' => 0,
        'vydil' => 0,
        'kvartal' => 0
    );
    return($allowedCoreDataNames);
}

$db_connection = new General;
/*Total porody*/
function TotalEveryType($db_connection, $rubka_arg, $lisnyctwo_arg){
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
        'vilha' => 0,
    );
    $table_data = $db_connection->getData($rubka_arg . '_' . $lisnyctwo_arg);
    foreach ($table_data as $row){
        foreach($row as $item_key => $item_value){
            foreach($total as $typ => $value) {
                if (strpos($item_key, $typ) !== false) {
                    $total[$typ] = $value + $item_value;
                }
            }
        }
    }
    return($total);
}

function TotalChvorost($db_connection, $rubka_arg, $lisnyctwo_arg){
    $total = array(
        'chvorost' => 0
    );
    $table_data = $db_connection->getData($rubka_arg . '_' . $lisnyctwo_arg);
    foreach ($table_data as $row){
        foreach($row as $item_key => $item_value){
            foreach($total as $typ => $value) {
                if (strpos($item_key, $typ) !== false) {
                    $total[$typ] = $value + $item_value;
                }
            }
        }
    }
    return($total);
}

/**TOTAL IN COLUMN */
function totalInColumn($db_connection, $total, $all_porody = null, $rubka_arg, $lisnyctwo_arg){

    $allCoreNamePorody = array(
        'bereza' => 0,
        'chvorost' => 0,
        'dub' => 0,
        'grab' => 0,
        'inshe' => 0,
        'jalyna' => 0,
        'jasen' => 0,
        'klen' => 0,
        'lypa' => 0,
        'osyka' => 0,
        'sosna' => 0,
        'vilha' => 0
    );

    $all_porody = isset($all_porody) ? $all_porody : $allCoreNamePorody;
    $table_data = $db_connection->getData($rubka_arg . '_' . $lisnyctwo_arg);
    $columns_total = [];
    foreach ($table_data as $row){ $row_id = $row['id']; $previousWord = '';
        foreach($row as $item_key => $item_value){
            if(strtok($item_key, '_') != $previousWord && $item_key != 'kvartal' && $item_key != 'kvytok_number' && $item_key != 'vydil' && $item_key != 'id' && isset($all_porody[strtok($item_key, '_')])){
                $previousWord = strtok($item_key, '_');
                $columns_total[$previousWord . "sectiontotal"] = $total[$previousWord];
                if(isset($columns_total[$item_key])){
                    $columns_total[$item_key] = $columns_total[$item_key] + $item_value;
                } else {
                    $columns_total[$item_key] = $item_value;
                }
            } elseif($item_key != 'kvartal' && $item_key != 'vydil' && $item_key != 'id' && $item_key != 'kvytok_number') {
                if(isset($columns_total[$item_key])){
                    $columns_total[$item_key] = $columns_total[$item_key] + $item_value;
                } else {
                    $columns_total[$item_key] = $item_value;
                }
            }

        }
    };
    return($columns_total);
}

/**TOTAL PORODY IN ROW */
function totalSinglePorodaInLine($db_connection, $rubka_arg, $lisnyctwo_arg){
    $table_data = $db_connection->getData($rubka_arg . '_' . $lisnyctwo_arg);

    $rows_total = [];

    foreach ($table_data as $row){
        $single_row_totals = [];
        $row_id = $row['id'];
        $column_name = '';
        foreach($row as $item_key => $item_value){
            $item_key_cutted = strtok($item_key, '_');
            if($first_column_name = ''){
                $column_name = $item_key_cutted;
                $single_row_totals[$column_name] = $item_value;
            } else {
                if($column_name == $item_key_cutted){
                    $single_row_totals[$column_name] = $single_row_totals[$column_name] + $item_value;
                } else {
                    $column_name = $item_key_cutted;
                    $single_row_totals[$column_name] = $item_value;
                }
            }
            $rows_total[$row_id] = $single_row_totals;
        }
    }
    return($rows_total);
}

function totalBySortymentInRow($db_connection, $rubka_arg, $lisnyctwo_arg){
    $table_data = $db_connection->getData($rubka_arg . '_' . $lisnyctwo_arg);

    $rows_total_sortyments = [];

    foreach ($table_data as $row){
        $single_row_totals_sortyments = [];
        $row_id = $row['id'];
        $sortyments = array(
            'total' => 0,
            'dilova' => 0,
            'a' => 0,
            'b' => 0,
            'c' => 0,
            'd' => 0,
            'pv' => 0,
            'np' => 0
        );
        foreach($row as $item_key => $item_value){
            $strArray = explode('_',$item_key);
            $item_key_sortyment = isset($strArray[1]) ? $strArray[1] : '';
            if(isset($sortyments[$item_key_sortyment])){
                $single_row_totals_sortyments[$item_key_sortyment] = isset($single_row_totals_sortyments[$item_key_sortyment]) ? $single_row_totals_sortyments[$item_key_sortyment] + $item_value : $item_value;
                $single_row_totals_sortyments['total'] = isset($single_row_totals_sortyments['total']) ? $single_row_totals_sortyments['total'] + $item_value : $item_value;
                if($item_key_sortyment == 'a' || $item_key_sortyment == 'b' || $item_key_sortyment == 'c' || $item_key_sortyment == 'd'){
                    $single_row_totals_sortyments['dilova'] = isset($single_row_totals_sortyments['dilova']) ? $single_row_totals_sortyments['dilova'] + $item_value : $item_value;
                }
            }
            $rows_total_sortyments[$row_id] = $single_row_totals_sortyments;
        }
    }
    return ($rows_total_sortyments);
}

function totalBySortyment($db_connection, $rubka_arg, $lisnyctwo_arg) {
    $table_data = $db_connection->getData($rubka_arg . '_' . $lisnyctwo_arg);
    $total = array(
        'total' => 0,
        'dilova' => 0,
        'a' => 0,
        'b' => 0,
        'c' => 0,
        'd' => 0,
        'pv' => 0,
        'np' => 0
    );
    $totalInRows = totalBySortymentInRow($db_connection, $rubka_arg, $lisnyctwo_arg);
    foreach($totalInRows as $row){
        foreach($row as $item_key => $item_value){
            $value = $total[$item_key] + $item_value;
            $total[$item_key] = round($value, 4);
        }
    }
    $total['total'] = $total['dilova'] + $total['pv'] + $total['np'];
    console_log($total);
    return($total);
}

function getKvytkyForLisnyctwo($db_connection, $table_name){
    $table_data = $db_connection->getData($table_name);
    $kvytky_numbers = array();
    foreach($table_data as $row){
        if(!in_array($row['kvytok_number'], $kvytky_numbers)){
            $kvytky_numbers[] = $row['kvytok_number'];
        }
    }
    return $kvytky_numbers;
}

function getKvytokData($db_connection, $kvytok_number){
    $sql = "SELECT * FROM `lisorubni_kvytky` WHERE `number`=$kvytok_number";
    $sth = $db_connection->dbs->prepare($sql);
    $sth->execute();
    $sth->setFetchMode(PDO::FETCH_ASSOC);
    $results = $sth->fetchAll();

    return $results;
}

function getDataByKvytokNumber($db_connection,$table_name,$kvytok_number){
    $sql = "SELECT * FROM `$table_name` WHERE `kvytok_number`=$kvytok_number";
    $sth = $db_connection->dbs->prepare($sql);
    $sth->execute();
    $sth->setFetchMode(PDO::FETCH_ASSOC);
    $results = $sth->fetchAll();

    return $results;
}

/**CALCULATE TOTAL FOR PORODY I DILOVA AFTER FILTRATION BY KVYTOK NUMBER */
function getTotalPorodyAfterFilterKvytok($all_array){
    $total=0;
    $result=[];
    $porody = array(
        'bereza' => 0,
        'chvorost' => 0,
        'dub' => 0,
        'grab' => 0,
        'inshe' => 0,
        'jalyna' => 0,
        'jasen' => 0,
        'klen' => 0,
        'lypa' => 0,
        'osyka' => 0,
        'sosna' => 0,
        'vilha' => 0
    );
    $porodyDilova = array(
        'bereza' => 0,
        'chvorost' => 0,
        'dub' => 0,
        'grab' => 0,
        'inshe' => 0,
        'jalyna' => 0,
        'jasen' => 0,
        'klen' => 0,
        'lypa' => 0,
        'osyka' => 0,
        'sosna' => 0,
        'vilha' => 0
    );
    foreach($all_array as $row){
        $row_id = $row['id'];
        foreach($row as $key => $value){
            if(isset($porody[strtok($key, '_')])){
                $porody[strtok($key, '_')] = isset($porody[strtok($key, '_')]) ? $porody[strtok($key, '_')] + $value : $value;
                $strArray = explode('_',$key);
                $key_sortyment = isset($strArray[1]) ? $strArray[1] : '';
                if($key_sortyment=='a' || $key_sortyment=='b' || $key_sortyment=='c' || $key_sortyment=='d'){
                    $porodyDilova[strtok($key, '_')] = isset($porodyDilova[strtok($key, '_')]) ? $porodyDilova[strtok($key, '_')] + $value : $value;
                }
            }
        }
    }
    $result = array(
        'all' => $porody,
        'dilova' => $porodyDilova,
    );
    return ($result);
}

function getHighestValue($db_connection,$table_name,$column_name){
    $sql = "SELECT `$column_name` FROM `$table_name`";
    $sth = $db_connection->dbs->prepare($sql);
    $sth->execute();
    $sth->setFetchMode(PDO::FETCH_ASSOC);
    $results = $sth->fetchAll();
    $all_values = [];
    foreach($results as $row){
        $all_values[] = $row[$column_name];
    }
    if(!$all_values){
        return 1;
    } else {
        return max($all_values);
    }
};
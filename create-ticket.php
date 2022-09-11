<?php include('parts/head.php');?>
<?php include('functions.php');?>
<?php checkIfUserIsLogged(); ?>
<?php $db_connection = new General;?>


<section class="create_ticket_section">
    <div class="container">
        <h1>Створити Лісорубний Квиток</h1>
        <form action="create_ticket_function.php" class="create_ticket">
            <div class="create_ticket_form_block create_ticket_form_block--ticket_number">
                <p>Номер Лісорубного Квитка</p>
                <input name="ticket_number" type="number" value="3">
            </div>
            <div class="create_ticket_data_wrapper">
                <div class="create_ticket_data_single">
                    <div class="create_ticket_data_single__left">
                        <p>Сосна</p>
                    </div>
                    <div class="create_ticket_data_single__right">
                        <div class="create_ticket_input_box">
                            <label for="sosna">Сосна</label>
                            <input type="number" value="0" name="sosna">
                        </div>
                        <div class="create_ticket_input_box">
                            <label for="sosna_dilova">Сосна Ділова</label>
                            <input type="number" value="0" name="sosna_dilova">
                        </div>
                    </div>
                </div>
                <div class="create_ticket_data_single">
                    <div class="create_ticket_data_single__left">
                        <p>Ялина</p>
                    </div>
                    <div class="create_ticket_data_single__right">
                        <div class="create_ticket_input_box">
                            <label for="jalyna">Ялина</label>
                            <input type="number" value="0" name="jalyna">
                        </div>
                        <div class="create_ticket_input_box">
                            <label for="jalyna_dilova">Ялина ділова</label>
                            <input type="number" value="0" name="jalyna_dilova">
                        </div>
                    </div>
                </div>
                <div class="create_ticket_data_single">
                    <div class="create_ticket_data_single__left">
                        <p>Дуб</p>
                    </div>
                    <div class="create_ticket_data_single__right">
                        <div class="create_ticket_input_box">
                            <label for="dub">Дуб</label>
                            <input type="number" value="0" name="dub">
                        </div>
                        <div class="create_ticket_input_box">
                            <label for="dub_dilova">Дуб ділова</label>
                            <input type="number" value="0" name="dub_dilova">
                        </div>
                    </div>
                </div>
                <div class="create_ticket_data_single">
                    <div class="create_ticket_data_single__left">
                        <p>Береза</p>
                    </div>
                    <div class="create_ticket_data_single__right">
                        <div class="create_ticket_input_box">
                            <label for="bereza">Береза</label>
                            <input type="number" value="0" name="bereza">
                        </div>
                        <div class="create_ticket_input_box">
                            <label for="bereza_dilova">Береза ділова</label>
                            <input type="number" value="0" name="bereza_dilova">
                        </div>
                    </div>
                </div>
                <div class="create_ticket_data_single">
                    <div class="create_ticket_data_single__left">
                        <p>Вільха</p>
                    </div>
                    <div class="create_ticket_data_single__right">
                        <div class="create_ticket_input_box">
                            <label for="vilha">Вільха</label>
                            <input type="number" value="0" name="vilha">
                        </div>
                        <div class="create_ticket_input_box">
                            <label for="vilha_dilova">Вільха ділова</label>
                            <input type="number" value="0" name="vilha_dilova">
                        </div>
                    </div>
                </div>
                <div class="create_ticket_data_single">
                    <div class="create_ticket_data_single__left">
                        <p>Граб</p>
                    </div>
                    <div class="create_ticket_data_single__right">
                        <div class="create_ticket_input_box">
                            <label for="grab">Граб</label>
                            <input type="number" value="0" name="grab">
                        </div>
                        <div class="create_ticket_input_box">
                            <label for="grab_dilova">Граб ділова</label>
                            <input type="number" value="0" name="grab_dilova">
                        </div>
                    </div>
                </div>
                <div class="create_ticket_data_single">
                    <div class="create_ticket_data_single__left">
                        <p>Ясен</p>
                    </div>
                    <div class="create_ticket_data_single__right">
                        <div class="create_ticket_input_box">
                            <label for="jasen">Ясен</label>
                            <input type="number" value="0" name="jasen">
                        </div>
                        <div class="create_ticket_input_box">
                            <label for="jasen_dilova">Ясен ділова</label>
                            <input type="number" value="0" name="jasen_dilova">
                        </div>
                    </div>
                </div>
                <div class="create_ticket_data_single">
                    <div class="create_ticket_data_single__left">
                        <p>Клен</p>
                    </div>
                    <div class="create_ticket_data_single__right">
                        <div class="create_ticket_input_box">
                            <label for="klen">Клен</label>
                            <input type="number" value="0" name="klen">
                        </div>
                        <div class="create_ticket_input_box">
                            <label for="klen_dilova">Клен ділова</label>
                            <input type="number" value="0" name="klen_dilova">
                        </div>
                    </div>
                </div>
                <div class="create_ticket_data_single">
                    <div class="create_ticket_data_single__left">
                        <p>Осика</p>
                    </div>
                    <div class="create_ticket_data_single__right">
                        <div class="create_ticket_input_box">
                            <label for="osyka">Осика</label>
                            <input type="number" value="0" name="osyka">
                        </div>
                        <div class="create_ticket_input_box">
                            <label for="osyka_dilova">Осика ділова</label>
                            <input type="number" value="0" name="osyka_dilova">
                        </div>
                    </div>
                </div>
                <div class="create_ticket_data_single">
                    <div class="create_ticket_data_single__left">
                        <p>Липа</p>
                    </div>
                    <div class="create_ticket_data_single__right">
                        <div class="create_ticket_input_box">
                            <label for="lypa">Липа</label>
                            <input type="number" value="0" name="lypa">
                        </div>
                        <div class="create_ticket_input_box">
                            <label for="lypa_dilova">Липа ділова</label>
                            <input type="number" value="0" name="lypa_dilova">
                        </div>
                    </div>
                </div>
                <div class="create_ticket_data_single">
                    <div class="create_ticket_data_single__left">
                        <p>Інше</p>
                    </div>
                    <div class="create_ticket_data_single__right">
                        <div class="create_ticket_input_box">
                            <label for="inshe">Інше</label>
                            <input type="number" value="0" name="inshe">
                        </div>
                        <div class="create_ticket_input_box">
                            <label for="inshe_dilova">Інше ділова</label>
                            <input type="number" value="0" name="inshe_dilova">
                        </div>
                    </div>
                </div>
                <div class="create_ticket_data_single">
                    <div class="create_ticket_data_single__left">
                        <p>Хворост</p>
                    </div>
                    <div class="create_ticket_data_single__right">
                        <div class="create_ticket_input_box flex-quoter">
                            <label for="chvorost_1c">Хворост 1C</label>
                            <input type="number" value="0" name="chvorost_1c">
                        </div>
                        <div class="create_ticket_input_box flex-quoter">
                            <label for="chvorost_2c">Хворост 2C</label>
                            <input type="number" value="0" name="chvorost_2c">
                        </div>
                        <div class="create_ticket_input_box flex-quoter">
                            <label for="chvorost_3c">Хворост 3C</label>
                            <input type="number" value="0" name="chvorost_3c">
                        </div>
                        <div class="create_ticket_input_box flex-quoter">
                            <label for="total_chvorost">Хворост Всього</label>
                            <input type="number" value="0" name="total_chvorost">
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
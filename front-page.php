<?php include('parts/head.php');?>
<?php include('functions.php');?>
<?php checkIfUserIsLogged(); ?>

<section class="page_titles">
  <div class="container">
    <h1 class="page__title">Тип Рубки</h1>
  </div>
</section>

<section id="type_rubka">
  <div class="container">
    <div class="cards">
      <a class="card" href="lisnyctwa.php?rubka=golovnekorystuvania">
        <div class="card_title">
          Головне Користування
        </div>
      </a>
      <a class="card" href="lisnyctwa.php?rubka=osvitlenia">
        <div class="card_title">
          Освітлення
        </div>
      </a>
      <a class="card" href="lisnyctwa.php?rubka=proridzuvania">
        <div class="card_title">
          Проріджування
        </div>
      </a>
      <a class="card" href="lisnyctwa.php?rubka=prochidna">
        <div class="card_title">
          Прохідна рубка
        </div>
      </a>
      <a class="card" href="lisnyctwa.php?rubka=vybirkovasanitarna">
        <div class="card_title">
          Вибіркова санітарна рубка
        </div>
      </a>
      <a class="card" href="lisnyctwa.php?rubka=sucilnasanitarna">
        <div class="card_title">
          Суцільна санітарна рубка
        </div>
      </a>
      <a class="card" href="lisnyctwa.php?rubka=rozrubkakvartalnychlinij">
        <div class="card_title">
          Розрубка квартальних ліній
        </div>
      </a>
      <a class="card" href="lisnyctwa.php?rubka=rozhyraniadorogy">
        <div class="card_title">
          Розширення дороги
        </div>
      </a>
      <a class="card" href="lisnyctwa.php?rubka=rozchyshcheniaelektroperedach">
        <div class="card_title">
          Розчищення лінії електропередач
        </div>
      </a>
      <a class="card" href="lisnyctwa.php?rubka=inshizlisgosp">
        <div class="card_title">
          Інші рубки повязані з веденням лісового господарства
        </div>
      </a>
      <a class="card" href="lisnyctwa.php?rubka=inshibezlisgosp">
        <div class="card_title">
          Інші рубки не повязані з веденням лісового господарства
        </div>
      </a>
    </div>
  </div>
</section>
<!--
<section id="problem_datas">
  <div class="container">
    <div class="box">
      <p class="box_title">Проблемні данні</p>
      <div class="table_wrapp">
        <table id="problem_datas_table">

        </table>
      </div>
    </div>
  </div>
</section>
-->
<?php include('parts/foot.php');?>
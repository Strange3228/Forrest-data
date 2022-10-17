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
    <div class="default__items">
      <div class="default_item">
        <a href="lisnyctwa.php?rubka=golovnekorystuvania">Головне Користування</a>
      </div>
      <div class="default_item">
        <a href="lisnyctwa.php?rubka=osvitlenia">Освітлення</a>
      </div>
      <div class="default_item">
        <a href="lisnyctwa.php?rubka=proridzuvania">Проріджування</a>
      </div>
      <div class="default_item">
        <a href="lisnyctwa.php?rubka=prochidna">Прохідна рубка</a>
      </div>
      <div class="default_item">
        <a href="lisnyctwa.php?rubka=vybirkovasanitarna">Вибіркова санітарна рубка</a>
      </div>
      <div class="default_item">
        <a href="lisnyctwa.php?rubka=sucilnasanitarna">Суцільна санітарна рубка</a>
      </div>
      <div class="default_item">
        <a href="lisnyctwa.php?rubka=rozrubkakvartalnychlinij">Розрубка квартальних ліній</a>
      </div>
      <div class="default_item">
        <a href="lisnyctwa.php?rubka=rozhyraniadorogy">Розширення дороги</a>
      </div>
      <div class="default_item">
        <a href="lisnyctwa.php?rubka=rozchyshcheniaelektroperedach">Розчищення лінії електропередач</a>
      </div>
      <div class="default_item">
        <a href="lisnyctwa.php?rubka=inshizlisgosp">Інші рубки повязані з веденням лісового господарства</a>
      </div>
      <div class="default_item">
        <a href="lisnyctwa.php?rubka=inshibezlisgosp">Інші рубки не повязані з веденням лісового господарства</a>
      </div>
    </div>
  </div>
</section>

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
<?php include('parts/foot.php');?>
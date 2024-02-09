<?php
session_start();
require "handlers/functions.php";

$edit_user_id = $_GET['id'];
check_edit_info($edit_user_id);
$user = get_user_by_id($edit_user_id);
?>
<?php require "template/header.php"; ?>
<main id="js-page-content" role="main" class="page-content mt-3">
  <div class="subheader">
    <h1 class="subheader-title">
      <i class='subheader-icon fal fa-lock'></i> Безопасность
    </h1>

  </div>
  <div class="row">
    <div class="col-xl-6">
        <?php display_flash_message('danger') ?>
        <?php display_flash_message('success') ?>
    </div>
  </div>
  <form action="handlers/security.php" method="post">
    <input type="hidden" name="userId" value="<?php echo $user['id'] ?>">
    <div class="row">
      <div class="col-xl-6">
        <div id="panel-1" class="panel">
          <div class="panel-container">
            <div class="panel-hdr">
              <h2>Обновление эл. адреса и пароля</h2>
            </div>
            <div class="panel-content">
              <!-- email -->
              <div class="form-group">
                <label class="form-label" for="simpleinput">Email</label>
                <input name="email" type="text" id="simpleinput" class="form-control"
                       value="<?php echo $user['email'] ?>">
              </div>

              <!-- password -->
              <div class="form-group">
                <label class="form-label" for="simpleinput">Пароль</label>
                <input name="password" type="password" id="simpleinput" class="form-control">
              </div>

              <!-- password confirmation-->
              <div class="form-group">
                <label class="form-label" for="simpleinput">Подтверждение пароля</label>
                <input type="password" id="simpleinput" class="form-control">
              </div>


              <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                <button class="btn btn-warning">Изменить</button>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </form>
</main>

<script src="js/vendors.bundle.js"></script>
<script src="js/app.bundle.js"></script>
<script>

  $(document).ready(function () {

    $('input[type=radio][name=contactview]').change(function () {
      if (this.value == 'grid') {
        $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-g');
        $('#js-contacts .col-xl-12').removeClassPrefix('col-xl-').addClass('col-xl-4');
        $('#js-contacts .js-expand-btn').addClass('d-none');
        $('#js-contacts .card-body + .card-body').addClass('show');

      } else if (this.value == 'table') {
        $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-1');
        $('#js-contacts .col-xl-4').removeClassPrefix('col-xl-').addClass('col-xl-12');
        $('#js-contacts .js-expand-btn').removeClass('d-none');
        $('#js-contacts .card-body + .card-body').removeClass('show');
      }

    });

    //initialize filter
    initApp.listFilter($('#js-contacts'), $('#js-filter-contacts'));
  });

</script>
</body>
</html>
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
      <i class='subheader-icon fal fa-image'></i> Загрузить аватар
    </h1>

  </div>
  <form action="handlers/media.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="userId" value="<?php echo $user['id']?>">
    <div class="row">
      <div class="col-xl-6">
        <div id="panel-1" class="panel">
          <div class="panel-container">
            <div class="panel-hdr">
              <h2>Текущий аватар</h2>
            </div>
            <div class="panel-content">
              <div class="form-group">
                  <?php if (isset($user['image'])): ?>
                    <img src="<?php echo $user['image'] ?>" alt="" class="img-responsive" width="200">
                  <?php else: ?>
                    <img src="uploads/avatars/laravel.png" alt="" class="img-responsive" width="200">f
                  <?php endif; ?>
              </div>

              <div class="form-group">
                <label class="form-label" for="example-fileinput">Выберите аватар</label>
                <input name="image" type="file" id="example-fileinput" class="form-control-file">
              </div>


              <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                <button type="submit" class="btn btn-warning">Загрузить</button>
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
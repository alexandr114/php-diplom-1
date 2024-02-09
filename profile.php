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
      <i class='subheader-icon fal fa-user'></i> <?php echo $user['username'] ?>
    </h1>
  </div>
  <div class="row">
    <div class="col-lg-6 col-xl-6 m-auto">
        <?php display_flash_message('danger') ?>
        <?php display_flash_message('success') ?>
      <!-- profile summary -->
      <div class="card mb-g rounded-top">
        <div class="row no-gutters row-grid">
          <div class="col-12">
            <div class="d-flex flex-column align-items-center justify-content-center p-4">
              <span class="status status-<?php echo get_status_class($user) ?>">
                <img src="<?php echo $user['image'] ?>" class="rounded-circle shadow-2 img-thumbnail" alt="">
              </span>

              <h5 class="mb-0 fw-700 text-center mt-3">
                  <?php echo $user['username'] ?>
                <small class="text-muted mb-0"><?php echo $user['job'] ?></small>
              </h5>
              <div class="mt-4 text-center demo">
                  <?php if ($user['vk']): ?>
                    <a href="<?php echo $user['vk'] ?>" class="mr-2 fs-xxl" style="color:#4680C2">
                      <i class="fab fa-vk"></i>
                    </a>
                  <?php endif; ?>
                  <?php if ($user['telegram']): ?>
                    <a href="<?php echo $user['telegram'] ?>" class="mr-2 fs-xxl" style="color:#38A1F3">
                      <i class="fab fa-telegram"></i>
                    </a>
                  <?php endif; ?>
                  <?php if ($user['instagram']): ?>
                    <a href="<?php echo $user['instagram'] ?>" class="mr-2 fs-xxl" style="color:#E1306C">
                      <i class="fab fa-instagram"></i>
                    </a>
                  <?php endif; ?>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="p-3 text-center">
              <a href="tel:<?php echo $user['phone'] ?>" class="mt-1 d-block fs-sm fw-400 text-dark">
                <i class="fas fa-mobile-alt text-muted mr-2"></i> <?php echo $user['phone'] ?></a>
              <a href="mailto:<?php echo $user['email'] ?>" class="mt-1 d-block fs-sm fw-400 text-dark">
                <i class="fas fa-mouse-pointer text-muted mr-2"></i> <?php echo $user['email'] ?></a>
              <address class="fs-sm fw-400 mt-4 text-muted">
                <i class="fas fa-map-pin mr-2"></i> <?php echo $user['address'] ?>
              </address>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
</body>

<script src="js/vendors.bundle.js"></script>
<script src="js/app.bundle.js"></script>
<script>

  $(document).ready(function () {

  });

</script>
</html>
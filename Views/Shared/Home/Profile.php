<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Trang thông tin cá nhân</h1>
<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>Tạo báo cáo</a>
</div>

<!-- Content Row -->
<div class="container mt-4">
  <div class="row">
    <!-- Phần Avatar -->
    <div class="col-md-4 text-center">
      <div class="avatar-container">
        <img id="avatar-preview" src="path/to/current/avatar.jpg" alt="Avatar" class="rounded-circle img-thumbnail" style="width: 150px; height: 150px;">
        <form action="index.php?controller=home&action=upload" class="dropzone mt-3" id="avatar-dropzone" style="border: none;">
          <div class="dz-message">
            <button type="button" class="btn btn-primary btn-sm">Cập nhật Avatar</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Phần Form Sửa Thông Tin -->
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
          <h5 class="mb-0">Chỉnh Sửa Thông Tin Cá Nhân</h5>
        </div>
        <div class="card-body">
          <form id="update-person-form" action="index.php?controller=person&action=update" method="post">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="fullName">Họ và Tên:</label>
                <input type="text" class="form-control" id="fullName" value="Họ và tên">
              </div>
              <div class="form-group col-md-6">
                <label for="gender">Giới tính:</label>
                <select class="form-control" id="gender" name="gender">
                  <option value="Male" <?php echo (isset($gender) && $gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                  <option value="Female" <?php echo (isset($gender) && $gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                  <option value="Other" <?php echo (isset($gender) && $gender == 'Other') ? 'selected' : ''; ?>>Other</option>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="cccd">CCCD:</label>
                <input type="text" class="form-control" id="cccd" value="000000000000">
              </div>
              <div class="form-group col-md-6">
                <label for="birth">Ngày sinh:</label>
                <input type="date" class="form-control" id="birth" value="1900-01-01">
              </div>
            </div>
            <div class="form-group">
              <label for="phoneNumber">Số điện thoại:</label>
              <input type="text" class="form-control" id="phoneNumber" value="0000000000">
            </div>
            <div class="form-group">
              <label for="address">Địa chỉ:</label>
              <input type="text" class="form-control" id="address" value="0000000000">
            </div>
            <div class="form-group">
              <label for="email">Địa chỉ email:</label>
              <input type="email" class="form-control" id="email" value="Địa chỉ email">
            </div>
            <button type="submit" class="btn btn-success btn-block" >Lưu Thay Đổi</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>



<?php
    $script = '<script src="assets/js/demo/get-profile.js"></script> <script src="assets/js/demo/dropzone.js"></script> <script src="assets/js/demo/update-person.js"></script>'
?>
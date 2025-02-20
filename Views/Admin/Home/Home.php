<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Trang chủ</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>Tạo báo cáo</a>
</div>

<!-- Content Row -->
<div class="row justify-content-center">
    <!-- Total Leader -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Tổng số lãnh đạo phòng đào tạo</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalLeader"></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas bi-briefcase fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Manager -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Tổng số lãnh đạo khoa</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalManager"></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas bi-briefcase fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Specialist -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tổng số chuyên viên đào tạo</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalSpecialist"></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas bi-briefcase fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 2: 2 ô -->
<div class="row justify-content-center">
    <!-- Total Teacher -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tổng số giáo viên</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalTeacher"></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Student -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tổng số sinh viên</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalStudent"></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Số lượng sinh viên qua từng năm</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Tổng quan số lượng</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    <span class="mr-2">
                        <i class="fas fa-circle text-info"></i> Tổng số lớp
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-primary"></i> Tổng số giáo viên
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-success"></i> Tổng số sinh viên
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
    $script = '  <!-- Page level plugins -->
    <script src="assets/vendor/chart.js/Chart.min.js"></script>
  
    <!-- Page level custom scripts -->
    <script src="assets/js/demo/dashboard-admin.js"></script>'
?>
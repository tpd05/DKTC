$(document).ready(function() {
    // Gửi yêu cầu AJAX để lấy dữ liệu cá nhân
    $.ajax({
        url: 'index.php?controller=home&action=get_profile', // Thay thế bằng URL API thực tế
        type: 'GET',
        success: function(result) {
            try {
                var data = JSON.parse(result); // Chuyển đổi JSON

                console.log("Dữ liệu từ API:", data); // Debug

                // Kiểm tra nếu API trả về dữ liệu hợp lệ
                if (data && typeof data === 'object') {
                    // Cập nhật ảnh avatar (nếu có)
                    if (data.avatar && data.avatar.trim() !== "") {
                        $('#avatar-preview').attr('src', data.avatar);
                    }

                    // Cập nhật thông tin cá nhân (nếu có)
                    $('#fullName').val(data.fullName || "");
                    $('#gender').val(data.gender || "");
                    $('#birth').val(data.birth || "2000-01-01"); // Giá trị mặc định
                    $('#cccd').val(data.cccd || "");
                    $('#phoneNumber').val(data.phoneNumber || "");
                    $('#address').val(data.address || "");
                    $('#email').val(data.email || "");
                } else {
                    console.error("Không có dữ liệu hợp lệ từ API.");
                }
            } catch (error) {
                console.error("Lỗi khi parse JSON:", error);
            }
        },
        error: function(xhr, status, error) {
            console.error("Lỗi AJAX:", status, error);
            Swal.fire({
                title: 'Lỗi!',
                text: 'Không thể lấy thông tin cá nhân. Vui lòng thử lại.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
});

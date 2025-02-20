$(document).ready(function() {
    // Thay đổi URL API theo API của bạn
    $.ajax({
        url: 'index.php?controller=home&action=get_profile', // Thay thế bằng URL API thực tế
        type: 'GET',
        success: function(result) {
            data = JSON.parse(result)
            console.log(data)
            // Kiểm tra xem API có trả về dữ liệu hay không
            if (data) {
                // Cập nhật ảnh avatar
                if (data.avatar && data.avatar !== "") {
                    $('#avatar-preview').attr('src', data.avatar);
                }
                // Cập nhật thông tin cá nhân
                $('#name').val(data.name);
                $('#birth').val(data.birth);
                $('#cccd').val(data.cccd);
                $('#phoneNumber').val(data.phoneNumber);
                $('#placeOfBirth').val(data.placeOfbirth);
                $('#normalAddress').val(data.normalAddress);
                $('#currentAddress').val(data.currentAddress);
            } else {
                console.error("Không có dữ liệu từ API");
            }
        },
        error: function() {
            alert("Có lỗi xảy ra khi lấy dữ liệu từ API.");
        }
    });
});
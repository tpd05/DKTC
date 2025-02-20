$(document).ready(function() {
    $('#update-person-form').on('submit', function(event) {
        event.preventDefault(); // Ngăn chặn hành động mặc định của nút submit

        // Thu thập dữ liệu từ form
        var formData = {
            fullName: $('#fullName').val().trim(),
            gender: $('#gender').val().trim(),
            birth: $('#birth').val(),
            cccd: $('#cccd').val().trim(),
            phoneNumber: $('#phoneNumber').val().trim(),
            address: $('#address').val().trim(),
            email: $('#email').val().trim(),
            avatar: $('#avatar-preview').attr('src') || $('#avatarPreview').data('old-src') // Giữ ảnh cũ nếu không thay đổi
        };

        // Kiểm tra dữ liệu trước khi gửi
        if (!formData.fullName || !formData.email) {
            Swal.fire({
                title: 'Lỗi!',
                text: 'Họ và Tên và Email không được để trống.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Kiểm tra ngày sinh hợp lệ (YYYY-MM-DD)
        if (!/^\d{4}-\d{2}-\d{2}$/.test(formData.birth) || formData.birth === "0000-00-00") {
            Swal.fire({
                title: 'Lỗi!',
                text: 'Ngày sinh không hợp lệ.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Kiểm tra định dạng email hợp lệ
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
            Swal.fire({
                title: 'Lỗi!',
                text: 'Email không đúng định dạng.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Hiển thị trạng thái loading
        let submitBtn = $('button[type="submit"]');
        submitBtn.prop('disabled', true).text('Đang cập nhật...');

        // Gửi yêu cầu AJAX
        $.ajax({
            url: 'index.php?controller=person&action=update',
            type: 'POST',
            data: formData,
            dataType: 'json', // Server sẽ trả về JSON
            success: function(response) {
                console.log('Phản hồi từ server:', response); // In ra console để kiểm tra

                if (response.success) {
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Thông tin đã được cập nhật thành công.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload(); // Làm mới trang để cập nhật dữ liệu mới
                    });
                } else {
                    Swal.fire({
                        title: 'Lỗi!',
                        text: response.message || 'Có lỗi xảy ra.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Lỗi AJAX:', status, error);
                console.error('Phản hồi từ server:', xhr.responseText);

                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Có lỗi xảy ra khi gửi dữ liệu. Kiểm tra console để biết thêm chi tiết.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            },
            complete: function() {
                submitBtn.prop('disabled', false).text('Lưu Thay Đổi'); // Bật lại nút sau khi xử lý xong
            }
        });
    });
});

$(document).ready(function() {
    $('#updateTeacherForm').submit(function(event) {
        event.preventDefault();

        // Lấy dữ liệu từ form
        var formData = {
            teacherID: $('#teacherID').val(),
            name: $('#name').val(),
            birth: $('#birth').val(),
            cccd: $('#cccd').val(),
            phoneNumber: $('#phoneNumber').val(),
            placeOfBirth: $('#placeOfBirth').val(),
            normalAddress: $('#normalAddress').val(),
            currentAddress: $('#currentAddress').val(),
            department: $('#department').val(),
            title: $('#title').val()
        };

        console.log(formData);

        // Gửi dữ liệu đến API
        $.ajax({
            url: 'index.php?controller=teacher&action=update',
            type: 'POST',
            data: formData,
            success: function(data) {
                console.log(data);
                const response = JSON.parse(data);
                if (response.success) {
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Thông tin giảng viên đã được cập nhật thành công.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'btn-success'
                        }
                    });
                    // Redirect hoặc xử lý sau khi cập nhật thành công
                } else {
                    Swal.fire({
                        title: 'Lỗi!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'btn-danger'
                        }
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Có lỗi xảy ra khi gửi dữ liệu.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn-danger'
                    }
                });
            }
        });
    });
});

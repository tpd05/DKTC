$(document).ready(function() {
    $('#registerClassForm').submit(function(event) {
        event.preventDefault();

        // Lấy dữ liệu từ form
        var formData = {
            subjectID: $('#subjectID').val(),
            className: $('#className').val(),
            quantity: $('#quantity').val()
        };

        // Gửi dữ liệu đến API
        $.ajax({
            url: 'index.php?controller=class&action=register_class',
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log(response)
                const result = JSON.parse(response);

                if (result.success) {
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Đăng ký lớp học thành công.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'btn-success'
                        }
                    }).then(() => {
                        // Redirect hoặc xử lý sau khi đăng ký thành công
                        window.location.href = 'index.php?controller=class&action=register_list';
                    });
                } else {
                    Swal.fire({
                        title: 'Lỗi!',
                        text: result.message,
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

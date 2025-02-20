$(document).ready(function() {
    $('#updateSubjectForm').submit(function(event) {
        event.preventDefault();

        // Lấy dữ liệu từ form
        var formData = {
            subjectID: $('#subjectID').val(),
            subjectName: $('#subjectName').val(),
            credits: $('#credits').val(),
        };

        console.log(formData);

        // Gửi dữ liệu đến API
        $.ajax({
            url: 'index.php?controller=subject&action=update',
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log(response);
                const data = JSON.parse(response);
                if (data.success) {
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Thông tin môn học đã được cập nhật thành công.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'btn-success'
                        }
                    }).then(() => {
                        // Tùy chọn: chuyển hướng hoặc làm mới trang
                        window.location.href = 'index.php?controller=subject&action=index';
                    });
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


$(document).ready(function() {
    $('#updateClassForm').on('submit', function(e) {
        e.preventDefault(); // Ngăn form không gửi theo cách thông thường

        // Lấy dữ liệu từ form
        var formData = {
            classID: $('#classID').val(),
            className: $('#className').val(),
            subjectID: $('#subjectID').val(),
            teacherID: $('#teacherID').val(),
            quatity: $('#quatity').val(),
            status: $('#status').val(),
        };
        console.log("OK")

        // Gửi dữ liệu qua AJAX
        $.ajax({
            url: 'index.php?controller=class&action=update', // URL của controller xử lý update
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log(response)
                // Xử lý phản hồi từ server
                var result = JSON.parse(response);
                if(result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: 'Thông tin lớp học đã được cập nhật.',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'index.php?controller=class&action=index';
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: 'Đã xảy ra lỗi khi cập nhật lớp học. Vui lòng thử lại.',
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: 'Không thể kết nối đến server. Vui lòng thử lại sau.',
                });
            }
        });
    });
});

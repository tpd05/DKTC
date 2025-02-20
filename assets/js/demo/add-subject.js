$(document).ready(function() {
    $('#addSubjectForm').on('submit', function(event) {
        event.preventDefault();
        
        // Thu thập dữ liệu từ form
        var formData = {
            subjectName: $('#subjectName').val(),
            credits: $('#credits').val()
        };
        console.log(formData);

        // Gửi yêu cầu POST
        $.ajax({
            url: 'index.php?controller=subject&action=create',
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log(response);
                
                // Xử lý phản hồi từ server
                var data = JSON.parse(response);
                if (data.success) {
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Môn học đã được thêm thành công.',
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

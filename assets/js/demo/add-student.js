$(document).ready(function() {
    $('#addStudentForm').on('submit', function(event) {
        event.preventDefault();
        // Gather form data
        var formData = {
            studentID: $('#studentID').val(),
            name: $('#name').val(),
            birth: $('#birth').val(),
            cccd: $('#cccd').val(),
            phoneNumber: $('#phoneNumber').val(),
            placeOfBirth: $('#placeOfBirth').val(),
            normalAddress: $('#normalAddress').val(),
            currentAddress: $('#currentAddress').val(),
            course: $('#course').val()
        };
        console.log(formData)
        // Send POST request
        $.ajax({
            url: 'index.php?controller=student&action=create',
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log(response)
                // Xử lý phản hồi từ server
                var data = JSON.parse(response);
                if (data.success) {
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Thông tin đã được cập nhật thành công.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'btn-success'
                        }
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
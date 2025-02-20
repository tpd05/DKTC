$(document).ready(function() {
    $('.btn-danger').on('click', function(event) {
        event.preventDefault();
        var teacherID = $(this).attr('href').split('id=')[1];
        

        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa?',
            text: 'Bạn sẽ không thể khôi phục lại dữ liệu này!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `index.php?controller=teacher&action=delete&id=${teacherID}`,
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        var data = JSON.parse(response);
                        if (data.success) {
                            Swal.fire({
                                title: 'Đã xóa!',
                                text: 'Dữ liệu đã được xóa thành công.',
                                icon: 'success',
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'btn-success'
                                }
                            }).then(() => {
                                window.location.href = 'index.php?controller=teacher&action=index';
                            });
                        } else {
                            Swal.fire({
                                title: 'Lỗi!',
                                text: 'Đã xảy ra lỗi khi xóa dữ liệu.',
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
            }
        });
    });
});

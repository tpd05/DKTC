$(document).ready(function() {
    // Bắt sự kiện click trên các nút "Xóa" với class là deleteClass
    $('.deleteClass').on('click', function(e) {
        e.preventDefault(); // Ngăn chặn hành động mặc định của thẻ <a>

        var classID = $(this).data('id'); // Lấy ID lớp học từ thuộc tính data-id
        console.log(classID)

        // Hiển thị xác nhận với SweetAlert2
        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: 'Bạn có chắc chắn muốn xóa lớp học này? Hành động này không thể hoàn tác!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                // Gửi yêu cầu xóa qua AJAX
                $.ajax({
                    url: 'index.php?controller=class&action=delete', // URL đến controller xử lý xóa
                    type: 'POST',
                    data: { classID: classID }, // Gửi ID lớp học cần xóa
                    success: function(response) {
                        console.log(response)
                        var result = JSON.parse(response);
                        if (result.success) {
                            Swal.fire(
                                'Đã xóa!',
                                'Lớp học đã được xóa thành công.',
                                'success'
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload(); // Tải lại trang để cập nhật danh sách lớp học
                                }
                            });
                        } else {
                            Swal.fire(
                                'Lỗi!',
                                'Đã xảy ra lỗi khi xóa lớp học. Vui lòng thử lại.',
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Lỗi!',
                            'Không thể kết nối đến server. Vui lòng thử lại sau.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});

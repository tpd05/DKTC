$(document).ready(function() {
    // Bắt sự kiện click trên các nút "Đăng ký"
    $('.registerClass').on('click', function(e) {
        e.preventDefault(); // Ngăn chặn hành động mặc định của thẻ <a>

        var classID = $(this).data('id'); // Lấy ID lớp học từ thuộc tính data-id

        // Xác nhận trước khi đăng ký
        Swal.fire({
            title: 'Xác nhận đăng ký',
            text: 'Bạn có chắc chắn muốn đăng ký lớp học này?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đăng ký',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                // Gửi yêu cầu đăng ký qua AJAX
                $.ajax({
                    url: 'index.php?controller=class&action=register', // URL đến controller xử lý đăng ký
                    type: 'POST',
                    data: { 
                        classID: classID // Gửi ID lớp học cần đăng ký
                    },
                    success: function(response) {
                        console.log(response)
                        var result = JSON.parse(response);
                        if (result.success) {
                            Swal.fire(
                                'Thành công!',
                                'Bạn đã đăng ký lớp học thành công.',
                                'success'
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload(); // Tải lại trang để cập nhật trạng thái lớp học
                                }
                            });
                        } else {
                            Swal.fire(
                                'Lỗi!',
                                result.message || 'Có lỗi xảy ra khi đăng ký lớp học. Vui lòng thử lại.',
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

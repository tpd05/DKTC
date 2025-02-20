$(document).ready(function() {
    // Xử lý duyệt lớp học
    $('.approveClass').click(function(e) {
        e.preventDefault(); // Ngăn chặn hành động mặc định của liên kết

        var classID = $(this).data('class-id');
        var url = $(this).attr('href');

        Swal.fire({
            title: 'Xác nhận',
            text: "Bạn có chắc chắn muốn duyệt lớp học này?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Duyệt',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        const result = JSON.parse(response);

                        if (result.success) {
                            Swal.fire({
                                title: 'Thành công!',
                                text: 'Lớp học đã được duyệt thành công.',
                                icon: 'success',
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'btn-success'
                                }
                            }).then(() => {
                                // Cập nhật trang hoặc phần tử sau khi duyệt thành công
                                location.reload(); // Tải lại trang
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
            }
        });
    });

    // Xử lý từ chối lớp học
    $('.rejectClass').click(function(e) {
        e.preventDefault(); // Ngăn chặn hành động mặc định của liên kết

        var classID = $(this).data('class-id');
        var url = $(this).attr('href');

        Swal.fire({
            title: 'Xác nhận',
            text: "Bạn có chắc chắn muốn từ chối lớp học này?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Từ chối',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        const result = JSON.parse(response);

                        if (result.success) {
                            Swal.fire({
                                title: 'Thành công!',
                                text: 'Lớp học đã được từ chối thành công.',
                                icon: 'success',
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'btn-success'
                                }
                            }).then(() => {
                                // Cập nhật trang hoặc phần tử sau khi từ chối thành công
                                location.reload(); // Tải lại trang
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
            }
        });
    });
});

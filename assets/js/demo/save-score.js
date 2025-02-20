$(document).ready(function() {
    // Tự động tính toán điểm tổng kết khi các trường điểm được thay đổi
    $('input.attendance-score, input.exam-score, input.final-score').on('input', function() {
        var row = $(this).closest('tr');
        var attendance = parseFloat(row.find('input.attendance-score').val()) || 0;
        var exam = parseFloat(row.find('input.exam-score').val()) || 0;
        var final = attendance*0.3+exam*0.7
        row.find('input.final-score').val(final.toFixed(2));
    });

    // Cập nhật điểm qua AJAX khi nhấn nút Lưu
    $('.btn-save').click(function() {
        var scoreID = $(this).data('score-id');
        var row = $(this).closest('tr');
        var attendance = row.find('input.attendance-score').val();
        var exam = row.find('input.exam-score').val();
        var final = row.find('input.final-score').val();

        $.ajax({
            url: 'index.php?controller=score&action=update',
            type: 'POST',
            data: {
                scoreID: scoreID,
                attendanceScore: attendance,
                examScore: exam,
                finalScore: final
            },
            success: function(response) {
                console.log(response)
                alert('Cập nhật điểm thành công!');
            },
            error: function() {
                alert('Có lỗi xảy ra khi cập nhật điểm.');
            }
        });
    });
});
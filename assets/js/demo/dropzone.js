Dropzone.options.avatarDropzone = {
    success: function(file, response) {
      // Cập nhật src của img avatar với đường dẫn mới
      // Tải lại thành phần ảnh
      window.location.reload();
    },
    error: function(file, response) {
      alert("Có lỗi xảy ra khi tải lên ảnh.");
    }
  };
  
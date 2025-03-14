<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        $allowed_types = ["text/plain"]; 
        $upload_dir = "uploads/";

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_tmp = $_FILES["file"]["tmp_name"];
        $file_name = basename($_FILES["file"]["name"]);
        $file_type = mime_content_type($file_tmp);
        $file_path = $upload_dir . $file_name;

        // Chỉ kiểm tra Content-Type
        if (!in_array($file_type, $allowed_types)) {
            die("❌ Chỉ chấp nhận file có Content-Type: text/plain.");
        }

        if (move_uploaded_file($file_tmp, $file_path)) {
            $content = file_get_contents($file_path);
            $char_count = mb_strlen($content, 'UTF-8');

            echo "✅ File đã tải lên thành công! <br>";
            echo "📄 Tên file: $file_name <br>";
            echo "🔢 Số ký tự trong file: $char_count <br>";
            echo "<a href='index.php'>🔙 Upload file khác</a>";
        } else {
            echo "❌ Lỗi khi tải file.";
        }
    } else {
        echo "❌ Vui lòng chọn file để upload.";
    }
} else {
    header("Location: index.php");
    exit;
}
?>

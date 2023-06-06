<?php
// 데이터베이스 연결 정보
$host = 'localhost'; // 데이터베이스 호스트
$username = 'jungmin'; // 데이터베이스 사용자명
$password = '1234'; // 데이터베이스 암호
$dbname = 'website'; // 데이터베이스 이름

// 데이터베이스 연결
$conn = new mysqli($host, $username, $password, $dbname);

// 연결 오류 확인
if ($conn->connect_error) {
    die("데이터베이스 연결 실패: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 양식에서 제출된 이메일 가져오기
    $email = $_POST['email'];

    // 중복된 이메일이 있는지 확인
    $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
    $checkEmailResult = $conn->query($checkEmailQuery);

    if ($checkEmailResult->num_rows > 0) {
        // 중복된 이메일이 존재하는 경우
        echo "duplicate";
    } else {
        // 이메일이 중복되지 않는 경우
        echo "available";
    }
}

// 데이터베이스 연결 닫기
$conn->close();
?>

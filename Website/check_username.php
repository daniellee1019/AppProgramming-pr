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
    // 양식에서 제출된 사용자명 가져오기
    $username = $_POST['username'];

    // 중복된 사용자명이 있는지 확인
    $checkUsernameQuery = "SELECT * FROM users WHERE username = '$username'";
    $checkUsernameResult = $conn->query($checkUsernameQuery);

    if ($checkUsernameResult->num_rows > 0) {
        // 중복된 사용자명이 존재하는 경우
        echo "duplicate";
    } else {
        // 사용자명이 중복되지 않는 경우
        echo "available";
    }
}

// 데이터베이스 연결 닫기
$conn->close();
?>

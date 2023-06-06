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

// POST 데이터 가져오기
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$userID = $_POST['userID'];

// 이메일 중복 확인
$checkEmailQuery = "SELECT * FROM users WHERE email = '$email' AND id != $userID";
$checkEmailResult = $conn->query($checkEmailQuery);

if ($checkEmailResult->num_rows > 0) {
    // 중복된 이메일이 있는 경우
    echo "중복되는 이메일입니다.";
} else {
    // 이메일 중복이 없는 경우 사용자 정보 업데이트
    $updateQuery = "UPDATE users SET username = '$username', email = '$email', password = '$password' WHERE id = $userID";

    if ($conn->query($updateQuery) === TRUE) {
        echo "회원정보가 성공적으로 업데이트되었습니다.";
    } else {
        echo "회원정보 업데이트에 실패했습니다: " . $conn->error;
    }
}

// 데이터베이스 연결 닫기
$conn->close();
?>


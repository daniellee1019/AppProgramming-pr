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

// 로그인 양식이 제출되었을 때 처리
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 양식에서 제출된 데이터 가져오기
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 데이터 유효성 검사 (필요한 로직 추가)
    if (empty($username) || empty($password)) {
        // 필수 필드가 비어있는 경우 오류 처리
        echo "유효하지 않은 사용자명 또는 비밀번호입니다.";
    } else {
        // 사용자명과 비밀번호를 확인하는 SQL 쿼리 작성
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // 로그인 성공
            echo "success";
        } else {
            // 로그인 실패
            echo "유효하지 않은 사용자명 또는 비밀번호입니다.";
        }
    }
}

// 데이터베이스 연결 닫기
$conn->close();
?>

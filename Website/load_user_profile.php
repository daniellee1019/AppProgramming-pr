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

// 최근 로그인한 사용자의 프로필 정보를 가져오는 SQL 쿼리 작성
$sql = "SELECT username, email FROM users ORDER BY created_at DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 결과에서 사용자 프로필 정보를 가져옴
    $row = $result->fetch_assoc();

    // 사용자 프로필 정보를 배열로 가공
    $userProfile = array(
        'username' => $row['username'],
        'email' => $row['email']
    );

    // JSON 형식으로 사용자 프로필 정보 반환
    header('Content-Type: application/json');
    echo json_encode($userProfile);
} else {
    // 사용자 프로필 정보를 찾을 수 없음
    echo "사용자 프로필 정보를 찾을 수 없습니다.";
}

// 데이터베이스 연결 닫기
$conn->close();
?>

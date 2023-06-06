<?php
// MySQL 데이터베이스 연결 설정
$servername = "localhost";  // 데이터베이스 서버 주소
$username = "jungmin";  // 데이터베이스 사용자 이름
$password = "1234";  // 데이터베이스 비밀번호
$dbname = "website";  // 데이터베이스 이름

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
  die("데이터베이스 연결 실패: " . $conn->connect_error);
}

// POST 요청 처리
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $message = $_POST["message"];

  // 메시지를 DB에 삽입
  $sql = "INSERT INTO chats (message) VALUES ('$message')";
  if ($conn->query($sql) === FALSE) {
    echo "메시지 삽입 실패: " . $conn->error;
  }
}

// DB에서 채팅 내용 가져오기
$sql = "SELECT * FROM chats ORDER BY timestamp ASC";
$result = $conn->query($sql);

// 가져온 내용을 HTML 형식으로 출력
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $message = $row["message"];
    $timestamp = $row["timestamp"];
    echo "<p>$timestamp: $message</p>";
  }
} else {
  echo "<p>채팅 내용이 없습니다.</p>";
}

// 데이터베이스 연결 종료
$conn->close();
?>

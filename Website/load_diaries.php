<?php
// 데이터베이스 연결 설정
$servername = "localhost";
$username = "jungmin";
$password = "1234";
$dbname = "website";

// 데이터베이스에서 일기 목록 불러오기
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 가장 최근에 입력한 일기의 번호 가져오기
$sql = "SELECT id FROM diaries ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);
$latestDiaryNumber = 1; // 기본적으로 1로 초기화

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $latestDiaryNumber = $row["id"]; // 가장 최근 일기 번호를 가져옴
}

// 일기 목록 출력
if ($latestDiaryNumber > 0) {
    $dayCount = $latestDiaryNumber;
    $result = $conn->query("SELECT * FROM diaries ORDER BY id DESC");
    while ($row = $result->fetch_assoc()) {
        echo "<p>Day-" . $dayCount . ": " . $row["content"] . "</p>";
        $dayCount--;
    }
} else {
    echo "No diaries found.";
}

$conn->close();
?>

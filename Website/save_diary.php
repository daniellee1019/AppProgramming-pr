<?php
// 데이터베이스 연결 설정
$servername = "localhost";
$username = "jungmin";
$password = "1234";
$dbname = "website";

// 일기 내용 받아오기
$content = $_POST['content'];

// 데이터베이스에 일기 저장
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO diaries (content) VALUES ('$content')";
if ($conn->query($sql) === TRUE) {
    echo "Diary saved successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

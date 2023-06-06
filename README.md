# AppProgramming-pr
마이펫다이어리 웹앱 개발을 위한 베이스
구조도.

1. StartHome.html
1-1) StartHome.css

2. Loginpage.html
2-1) Loginpage.css
2-2) login.php

3. Signup.html
3-1) Signup.css
3-2) Signup.js
3-3) signup.php
3-4) check_username.php
3-5) check_email.php

4. mainpage.html
4-1) mainpage.css
4-2) save_diary.php
4-3) load_diaries.php

5. chat.html
5-1) chat.css
5-2) chat.php
5-3) get_messages.php

6. images
6-1) Wave.svg
6-2) welsh01.png
6-3) welsh01rm.png

7. dbname - website
7-1) users
7-2) diaries
7-3) chats

html - 5개
css - 5개
js - 1개
php - 8개
image - 3개

총 22개의 파일이 있으며, 총 3개의 DB table을 사용한 웹 서버입니다.

A. 초기 화면 StarHome에 대해 설명

메인 로고가 있고 로그인 버튼으로 Loginpage.html로 넘어가는 기능이 있습니다.
전체적으로 body의 background-image에 Wave.svg 파일을 이용하여 키프레임 에니메이션 효과를 부여하여 10s infinite alternate linear 이 코드를 적용시켜 이 애니메이션을 10초동안 지속되며, 무한히 반복되게 만들었습니다.

B. 로그인 화면 Loginpage에 대해 설명

여기에는 기능적인 측면 두 가지가 있습니다.

첫 번째는 DB table users에 저장된 데이터를 읽어와 테이블 안에 있는 사용자만 로그인이 가능하게 만들었습니다. 주요 스크립트로는 

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

이러한 조건문을 만들어 사용자 명과 비밀번호를 검증하여 로그인을 처리하게 하였습니다.

C. 회원가입 화면 Signup에 대해 설명

여기에는 폼형식으로 만들어 action으로 signup.php 사용하였고 ajax를 사용하여 php로 DB에 접근하여 저장된 사용자명과 이메일을 입력하게 된다면 중복됐다는 경고 메세지가 발생합니다. 관련 스크립트는

$.ajax({
            type: 'POST',
            url: 'check_username.php',
            data: { username: username },
            success: function(response) {
              if (response === 'duplicate') {
                $('#username-feedback').text('중복된 사용자명입니다. 다른 사용자명을 입력해주세요.').removeClass('success').addClass('error');
              } else if (response === 'available') {
                $('#username-feedback').text('사용 가능한 사용자명입니다.').removeClass('error').addClass('success');
              } else {
                $('#username-feedback').text('');
              }
            }
          });

AJAX를 사용하여 서버로 요청을 보내고, 서버에서 받은 응답에 따라 사용자에게 제공하는 부분입니다. 이를 통해 사용자명 중복 확인결과를 동적으로 표시할 수 있습니다.

그리고 이메일 입력 시 example@example.com 이런 형식으로 입력해야지만 회원가입이 되게 만들었고, 이는 js 스크립트로 html에 연결하여 사용하였습니다. 해당 스크립트에서 주요 부분은

const validateEmail = () => {
    const email = emailInput.value;
    const emailRegex = /\S+@\S+\.\S+/;
    if (emailRegex.test(email)) {
        // 이메일 주소가 올바른 형식일 경우
        emailInput.classList.remove("invalid");
        spinner.style.display = 'none';

        return true;
      } else {
        if (email === '') {
          // 이메일 입력값이 없을 경우
          spinner.style.display = 'none';

        } else {
          // 이메일 주소가 올바르지 않은 형식일 경우
          emailInput.classList.add("invalid");
          spinner.style.display = "block";

        }
      }
    };
정규식을 이용하였는데, 이메일 주소가 필수적으로 @ 기호를 포함하고 . 을 포함해야 한다는 조건을 검사하게 하여 이메일 주소의 유효성을 판단하였습니다.

그리고 패스워드의 강도를 확인하기 위한 함수도 만들었습니다. 관련 함수는 

const getIndicator = (password, strengthValue) => {
  for (let index = 0; index < password.length; index++) {
    let char = password.charCodeAt(index);
    if (!strengthValue.upper && char >= 65 && char <= 90) {
      strengthValue.upper = true;
    } else if (!strengthValue.numbers && char >= 48 && char <= 57) {
      strengthValue.numbers = true;
    } else if (!strengthValue.lower && char >= 97 && char <= 122) {
      strengthValue.lower = true;
    }
  }

이 함수를 이용하여 대문자, 숫자, 소문자를 포함하는지에 따라 해당 강도를 변화하게 만들었습니다.

D. 메인 화면 mainpage에 대해 설명

이 화면에는 총 3개의 섹션이 있으며 첫 번째 섹션은 일기장이고, 두 번째 섹션은 마이페이지, 세 번째 섹션은 로그아웃과 자유게시판으로 이동할 수 있는 버튼이 있습니다.

a) 첫 번째 화면에서의 기능으로는
<textarea class="diary-textarea" placeholder="Write your diary here..."></textarea>
<button class="diary-button">Submit</button>

이렇게 textarea에 입력하고 button으로 제출을 하는 형식으로 만들었으며 이는 diaries 테이블에 저장되며 이를 다시 읽어와 화면에 실시간으로 뿌려주는 기능을 합니다. 관련 스크립트로는

function saveDiary(content) {
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'save_diary.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          loadDiaries(); // 일기 목록 다시 불러오기
        }
      };
      xhr.send('content=' + encodeURIComponent(content));
    }

    function loadDiaries() {
      var xhr = new XMLHttpRequest();
      xhr.open('GET', 'load_diaries.php', true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          var diaryList = document.querySelector('#diary-list');
          diaryList.innerHTML = xhr.responseText;
        }
      };
      xhr.send();
    }

이것이며, XMLHttpRequest 객체를 생성하여 변수에 할당합니다. 이 객체를 사용하여 서버와 통신합니다. POST 방식으로 해당 php 에 요청을 보냅니다. 여기서 true는 비동기 방식을 의미합니다. 받아올 때는 GET형식으로 해당 php에 요청을보내 사용자에게 데이터를 제공합니다.

b) 두 번째 화면에서의 기능으로는
마이페이지 기능이며 사용자의 정보를 저장해 놓는 섹션입니다. 별 기능이 없어 넘어가도록 하겠습니다.

c) 마지막으로 세 번째 기능으로는
<button class="settings-button" onclick="goToChat()">자유게시판으로 가기😀 </button>
<button class="settings-button" onclick="sayGoodbye()">로그아웃</button>
두 개의 버튼으로 자유게시판과 로그아웃 이동할 수 있게 하였고, 해당 스크립트로는

function goToChat() {
      window.location.href = "chat.html";
    }
  
    function sayGoodbye() {
      alert("다음에 또 봐요!");
      window.location.href = "StartHome.html";
    }
이것이며, 간단히 윈도우의 로케이션을 해당 html로 이동하게 만들었습니다.

E. 자유게시판 chats에 대한 설명

여기에는 사용자들이 실시간으로 채팅을 주고 받을 수 있게 하였습니다. 해당 로직으로는

// 전송 버튼 클릭 시 메시지를 서버로 전송하는 함수
      function sendMessage() {
        var messageInput = document.getElementById("message-input");
        var message = messageInput.value;
  
        if (message !== "") {
          // XMLHttpRequest 객체를 사용하여 PHP 파일에 POST 요청 전송
          var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
              // 채팅 메시지를 전송한 후 새로운 메시지를 가져와서 화면에 추가
              updateChat();
            }
          };
          xhttp.open("POST", "chat.php", true);
          xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xhttp.send("message=" + message);
  
          // 입력 필드 초기화
          messageInput.value = "";
        }
      }
  
      // 채팅 메시지를 가져와서 화면에 업데이트하는 함수
      function updateChat() {
        var chatMessages = document.getElementById("chat-messages");
  
        // XMLHttpRequest 객체를 사용하여 PHP 파일에 GET 요청 전송
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState === 4 && this.status === 200) {
            // 새로운 채팅 메시지를 가져와서 chat-messages 요소에 추가
            chatMessages.innerHTML = this.responseText;
          }
        };
        xhttp.open("GET", "get_messages.php", true);
        xhttp.send();
      }
  

마찬가지로 XML을 이용하여 객체를 생성해 서버와 통신하였고, 해당 php에 요청하여 입력 내용을 DB에 저장하고 입력된 데이터를 가져와 실시간으로 화면에 뿌려주는 역할을 하게 만들었습니다. 또한 

// 전송 버튼 클릭 시 sendMessage 함수 호출
var sendButton = document.getElementById("send-button");
sendButton.addEventListener("click", sendMessage);

// 1초마다 채팅 메시지 업데이트
setInterval(updateChat, 1000);

이 코드를 이용해 전송 버튼 클릭 이벤트와 주기적인 채팅 메시지를 업데이트 갱신하여 새로운 메시지를 표시하게 만들었습니다.

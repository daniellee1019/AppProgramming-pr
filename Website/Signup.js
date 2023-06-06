const bars = document.querySelector("#bars"),
  strengthDiv = document.querySelector("#strength"),
  passwordInput = document.querySelector("#password"),
  emailInput = document.querySelector("input[type='email']");
  checkmark = '<span class="checkmark">&#10004;</span>';

const strength = {
  1: "weak",
  2: "medium",
  3: "strong",
};

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

  let strengthIndicator = 0;

  for (let metric in strengthValue) {
    if (strengthValue[metric] === true) {
      strengthIndicator++;
    }
  }

  return strength[strengthIndicator] ?? "";
};

const getStrength = (password) => {
  let strengthValue = {
    upper: false,
    numbers: false,
    lower: false,
  };

  return getIndicator(password, strengthValue);
};

const handleChange = () => {
  let { value: password } = passwordInput;

  console.log(password);

  const strengthText = getStrength(password);

  bars.classList = "";

  if (strengthText) {
    strengthDiv.innerText = `${strengthText} Password`;
    bars.classList.add(strengthText);
  } else {
    strengthDiv.innerText = "";
  }
};
document.querySelector('button[type="button"]').addEventListener('click', function() {
    // 이메일 유효성 검사 추가
    if (validateEmail()) {
      // 유효한 이메일일 경우 체크 표시로 변경
      check.insertAdjacentHTML("afterend", checkmark);
    }
  });
  

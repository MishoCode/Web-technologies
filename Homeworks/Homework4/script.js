function submit() {
  const registration = document.querySelector("form");
  registration.addEventListener("submit", register);
}

submit();

async function register(event) {
  event.preventDefault();
  hideErrors();

  const username = document.getElementById("username").value;
  const name = document.getElementById("name").value;
  const familyName = document.getElementById("family-name").value;
  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;
  const postalCode = document.getElementById("postal-code").value;

  if (hasValidFields(username, name, familyName, email, password, postalCode)) {
    const response = await fetch("https://jsonplaceholder.typicode.com/users", {
      method: "GET",
    });

    const responseJson = await response.json();

    const usernames = responseJson.map((user) => user.username);
    if (usernames.includes(username)) {
      const formError = document.getElementById("form-error");
      formError.classList.remove("hide");
    } else {
      const successMessage = document.getElementById("success");
      successMessage.classList.remove("hide");
    }
  }
}

function hideErrors() {
  const errors = [
    "username-error",
    "name-error",
    "family-name-error",
    "email-error",
    "password-error",
    "postal-code-error",
    "form-error",
  ];

  errors.forEach((e) => {
    const element = document.getElementById(e);
    element.classList.add("hide");
  });

  const successMessage = document.getElementById("success");
  successMessage.classList.add("hide");
}

function hasValidFields(
  username,
  name,
  familyName,
  email,
  password,
  postalCode
) {
  return (
    validateUsername(username) &
    validateName(name) &
    validateFamilyName(familyName) &
    validateEmail(email) &
    validatePassword(password) &
    validatePostalCode(postalCode)
  );
}

function validateUsername(username) {
  if (username && username.length >= 3 && username.length <= 10) {
    return true;
  }

  const usernameError = document.getElementById("username-error");
  usernameError.classList.remove("hide");
  return false;
}

function validateName(name) {
  if (name && name.length >= 1 && name.length <= 50) {
    return true;
  }

  const nameError = document.getElementById("name-error");
  nameError.classList.remove("hide");
  return false;
}

function validateFamilyName(familyName) {
  if (familyName && familyName.length >= 1 && familyName.length <= 50) {
    return true;
  }

  const familyNameError = document.getElementById("family-name-error");
  familyNameError.classList.remove("hide");
  return false;
}

function validateEmail(email) {
  const emailRegex =
    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

  if (email && emailRegex.test(email)) {
    return true;
  }

  const emailError = document.getElementById("email-error");
  emailError.classList.remove("hide");
  return false;
}

function validatePassword(password) {
  if (
    password &&
    password.length >= 6 &&
    password.length <= 10 &&
    containsRequiredSymbols(password)
  ) {
    return true;
  }

  const passwordError = document.getElementById("password-error");
  passwordError.classList.remove("hide");
  return false;
}

function containsRequiredSymbols(password) {
  let hasUppercase = false;
  let hasLowercase = false;
  let hasNumber = false;

  password.split("").forEach((letter) => {
    if (letter == letter.toUpperCase()) {
      hasUppercase = true;
    } else if (letter == letter.toLowerCase()) {
      hasLowercase = true;
    }
    if (Number(letter) != NaN) {
      hasNumber = true;
    }
  });

  return hasUppercase && hasLowercase && hasNumber;
}

function validatePostalCode(postalCode) {
  const postalCodeRegex = /^[0-9]{5}-[0-9]{4}$|^[0-9]{4}$/;

  if (!postalCode) {
    return true;
  }

  if (postalCodeRegex.test(postalCode)) {
    return true;
  }

  const postalCodeError = document.getElementById("postal-code-error");
  postalCodeError.classList.remove("hide");
  return false;
}

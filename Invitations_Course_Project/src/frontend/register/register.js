(() => {
  const form = document.querySelector(".registration");
  const inputs = document.querySelectorAll(".input");
  const formError = document.getElementById("form-error");

  form.addEventListener("submit", (event) => {
    event.preventDefault();

    formError.classList.remove("error");

    formError.innerHTML = null;

    let data = {};
    inputs.forEach((i) => {
      data[i.name] = i.value;
    });

    saveUser(data)
      .then(() => {
        window.location.replace("../login/login.html");
      })
      .catch((error) => {
        formError.classList.add("error");
        formError.classList.remove("hide");
        const message = error;
        formError.innerText = message;
      });
  });
})();

async function saveUser(data) {
  const response = await fetch("../../backend/endpoints/register.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  });

  const responseJson = await response.json();
  if (responseJson["success"] === false) {
    throw new Error(responseJson["error"]);
  }
}

const input = document.querySelector(".theme-switcher input");
input.addEventListener("change", (e) => {
  if (e.target.checked) {
    document.body.setAttribute("data-theme", "dark");
  } else {
    document.body.setAttribute("data-theme", "light");
  }
});

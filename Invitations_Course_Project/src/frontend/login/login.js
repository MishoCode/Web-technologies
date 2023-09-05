(() => {
  const loginForm = document.querySelector(".login");
  const input = document.querySelectorAll(".input");
  const formError = document.getElementById("form-error");

  loginForm.addEventListener("submit", (event) => {
    event.preventDefault();

    formError.classList.remove("error");
    formError.innerHTML = null;

    const user = {};
    input.forEach((i) => {
      user[i.name] = i.value;
    });

    loadUser(user)
      .then(() => {
        window.location.replace("../dashboard/dashboard.html");
        localStorage.setItem("isLoggedIn", true);
      })
      .catch((error) => {
        formError.classList.add("error");
        formError.classList.remove("hide");
        const message = error;
        formError.innerText = message;
      });
  });
})();

async function loadUser(user) {
  const settings = {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(user),
  };
  const url = "../../backend/endpoints/login.php";

  const responseJson = await fetch(url, settings).then((response) =>
    response.json()
  );

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

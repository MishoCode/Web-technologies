(() => {
  setPossibleDates();

  const logoutButton = document.querySelector(".logout");
  logoutButton.addEventListener("click", (event) => {
    event.preventDefault();

    const url = "../../backend/endpoints/logout.php";
    const settings = { method: "GET" };

    fetch(url, settings).then(window.location.replace("../login/login.html"));
    localStorage.setItem("isLoggedIn", false);
  });

  const form = document.querySelector(".create-invitation");
  const inputs = document.querySelectorAll(".input");
  const formError = document.getElementById("form-error");

  form.addEventListener("submit", (event) => {
    event.preventDefault();

    formError.classList.remove("error");

    formError.innerHTML = null;

    const formData = new FormData();

    formData.append(inputs[0].name, inputs[0].value);
    formData.append(inputs[1].name, inputs[1].value);

    formData.append(inputs[2].name, inputs[2].value);
    formData.append(inputs[3].name, inputs[3].value);
    formData.append(inputs[4].name, inputs[4].files[0]);

    createInvitation(formData)
      .then(() => {
        window.location.replace("../dashboard/dashboard.html");
      })
      .catch((error) => {
        formError.classList.add("error");
        formError.classList.remove("hide");
        const message = error;
        formError.innerText = message;
      });
  });
})();

async function createInvitation(data) {
  const response = await fetch(
    "../../backend/endpoints/create-invitation.php",
    {
      method: "POST",
      body: data,
    }
  );

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

function setPossibleDates() {
  const date = document.querySelector('input[name="date"]');
  let startDate = new Date();
  let oneYearLater = new Date();
  startDate.setDate(startDate.getDate() + 1);
  oneYearLater.setDate(startDate.getDate() + 365);

  startDate = startDate.toISOString().slice(0, 10);
  oneYearLater = oneYearLater.toISOString().slice(0, 10);

  date.setAttribute("min", startDate);
  date.setAttribute("max", oneYearLater);
}

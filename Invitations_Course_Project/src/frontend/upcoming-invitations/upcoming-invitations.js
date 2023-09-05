(async () => {
  const settings = { method: "GET" };
  const url = "../../backend/endpoints/dashboard.php";

  const user = await fetch(url, settings);
  const userJson = await user.json();

  if (userJson["success"]) {
    loadUser(userJson);
  } else {
    throw new Error(responseJson["error"]);
  }

  const logoutButton = document.querySelector(".logout");

  logoutButton.addEventListener("submit", (event) => {
    event.preventDefault();

    const url = "../../backend/endpoints/logout.php";
    fetch(url, settings).then(window.location.replace("../login/login.html"));
    localStorage.setItem("isLoggedIn", false);
  });

  const invitations = document.getElementById("invitations");
  const result = await getInvitations();
  if (result["body"].length === 0) {
    const emptyBodyMessage = document.createElement("p");
    emptyBodyMessage.innerHTML = "No invitations yet.";
    invitations.appendChild(emptyBodyMessage);
    return;
  }

  result["body"].forEach(async (element) => {
    const div = document.createElement("div");
    const defaultInvitation = document.createElement("section");
    if (element["filename"] !== "NULL") {
      const image = document.createElement("img");
      image.setAttribute("src", "data:image/jpg;base64," + element["filename"]);

      div.appendChild(image);
      div.setAttribute("class", "invitation");

      invitations.appendChild(div);
    } else {
      defaultInvitation.setAttribute("class", "default-invitation");

      const content = document.createElement("section");
      content.setAttribute("class", "content");

      const invitationMessage = document.createElement("h2");
      invitationMessage.innerHTML =
        "Заповядайте на презентацията на " +
        element["presenter"]["firstName"] +
        " " +
        element["presenter"]["lastName"] +
        "!";

      const title = document.createElement("p");
      title.innerHTML = "Title: " + element["title"];

      const place = document.createElement("p");
      place.innerHTML = "Place: " + element["place"];

      const start = document.createElement("p");
      start.innerHTML = "Start: " + element["date"] + "   " + element["time"];

      const end = document.createElement("p");
      end.innerHTML = "End: " + element["date"] + "   " + element["endTime"];

      content.appendChild(invitationMessage);
      content.appendChild(title);
      content.appendChild(place);
      content.appendChild(start);
      content.appendChild(end);

      defaultInvitation.appendChild(content);

      invitations.appendChild(defaultInvitation);
    }
  });
})();

const loadUser = (data) => {
  if (data.success) {
    const logout = document.querySelector(".logout");
    const hello = document.createElement("h3");
    hello.innerHTML = "Hello, " + data.name;
    logout.insertBefore(hello, logout.firstChild);
  } else {
    console.log(data.error);
    window.location.replace("../login/login.html");
  }
};

async function getInvitations() {
  const settings = { method: "GET" };
  const url = "../../backend/endpoints/get-upcoming-invitations.php";

  return await fetch(url, settings)
    .then((response) => response.json())
    .catch((error) => console.log(error));
}

const input = document.querySelector(".theme-switcher input");
input.addEventListener("change", (e) => {
  if (e.target.checked) {
    document.body.setAttribute("data-theme", "dark");
  } else {
    document.body.setAttribute("data-theme", "light");
  }
});
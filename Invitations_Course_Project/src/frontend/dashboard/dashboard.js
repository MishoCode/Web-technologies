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
    const button = document.createElement("button");
    const likeMessage = document.createElement("p");
    likeMessage.classList.add("hide");
    likeMessage.classList.add("like-message");
    likeMessage.innerHTML = "You have just liked this post.";
    button.addEventListener("click", async () => {
      createLike(element["id"]);
      button.disabled = true;
      likeMessage.classList.remove("hide");
    });
    button.innerHTML = "Like";

    const allLikesCount = await getAllLikesForInvitation(element["id"]);
    const all = document.createElement("p");
    all.setAttribute("class", "all-likes");
    if (allLikesCount === 0) {
      all.classList.add("hide");
    } else {
      all.classList.remove("hide");

      if (allLikesCount === 1) {
        all.innerHTML = "1 user liked this";
      } else {
        all.innerHTML = allLikesCount + " users liked this";
      }
    }

    const likesSection = document.createElement("section");
    likesSection.setAttribute("class", "likes-section");
    likesSection.appendChild(button);
    likesSection.appendChild(all);

    if (element["filename"] !== "NULL") {
      const image = document.createElement("img");
      image.setAttribute("src", "data:image/jpg;base64," + element["filename"]);

      div.appendChild(image);
      div.appendChild(likesSection);
      div.setAttribute("class", "invitation");
      div.appendChild(likeMessage);

      invitations.appendChild(div);

      const isLiked = await isLikedByCurrentUser(userJson["fn"], element["id"]);
      if (isLiked) {
        div.getElementsByTagName("button")[0].disabled = true;
        const likeNotification = document.createElement("p");
        likeNotification.classList.add("like-message");
        likeNotification.innerHTML = "You liked this post.";
        div.appendChild(likeNotification);
      }
    } else {
      defaultInvitation.setAttribute("class", "default-invitation");

      const content = document.createElement("section");
      content.setAttribute("class", "content");

      const invitationMessage = document.createElement("h2");
      invitationMessage.innerHTML =
        "You are invited to the presentation of " +
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
      defaultInvitation.appendChild(likesSection);
      defaultInvitation.appendChild(likeMessage);

      invitations.appendChild(defaultInvitation);
      const isLiked = await isLikedByCurrentUser(userJson["fn"], element["id"]);
      if (isLiked) {
        defaultInvitation.getElementsByTagName("button")[0].disabled = true;
        const likeNotification = document.createElement("p");
        likeNotification.classList.add("like-message");
        likeNotification.innerHTML = "You liked this post.";
        defaultInvitation.appendChild(likeNotification);
      }
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
  const url = "../../backend/endpoints/get-invitations.php";

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

async function createLike(invitationId) {
  let data = {};
  data["invitationId"] = invitationId;

  const response = await fetch("../../backend/endpoints/create-like.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  });

  const result = await response.json();
  return result;
}

async function isLikedByCurrentUser(currentUser, invitationId) {
  const response = await getAllLikes();
  const allLikes = response["body"];
  for (let i = 0; i < allLikes.length; i++) {
    if (
      allLikes[i]["invitation"]["id"] === invitationId &&
      allLikes[i]["user"]["fn"] === currentUser
    ) {
      return true;
    }
  }

  return false;
}

async function getAllLikes() {
  const settings = { method: "GET" };
  const url = "../../backend/endpoints/get-all-likes.php";

  return await fetch(url, settings)
    .then((response) => response.json())
    .catch((error) => console.log(error));
}

async function getAllLikesForInvitation(invitationId) {
  const response = await getAllLikes();
  const allLikes = response["body"];
  let counter = 0;
  for (let i = 0; i < allLikes.length; i++) {
    if (allLikes[i]["invitation"]["id"] === invitationId) {
      counter++;
    }
  }

  return counter;
}

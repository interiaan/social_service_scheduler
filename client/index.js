const logout = function () {
    fetch ("server/logout.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
    }).then (logoutResponse => {
        if (!logoutResponse.ok) {
            throw new Error("Invalid Server Response. Session is active yet.");
        }

        return logoutResponse.json();
    }).then(logoutData => {
        console.log("Log out response: ", logoutData);
        // TODO: Manage log out modals
        location.reload();
    }).catch(error => {
        console.error("We couldn't finished the request: ", error);
    });
}

const login = function () {
    window.location.href = "login.html";
}

const urlApi = "server/index.php";

fetch (urlApi, {
    method: "POST",
    headers: {
        "Content-Type": "application/json"
    },
}).then (sessionResponse => {
    if (!sessionResponse.ok) {
        throw new Error("Invalid Server Response");
    }

    return sessionResponse.json();
}).then(responseData => {
    console.log("Session Response: ", responseData);

    if (responseData.status === "success") {
        const userSettings = document.getElementById("user-settings");
        const logoutBtn = document.createElement("button");

        logoutBtn.innerText = "Log out";
        logoutBtn.onclick = logout;

        userSettings.appendChild(logoutBtn);
    } else if (responseData.status === "error") {
        const userSettings = document.getElementById("user-settings");
        const loginBtn = document.createElement("button");

        loginBtn.innerText = "Login";
        loginBtn.onclick = login;

        userSettings.appendChild(loginBtn);
    }
}).catch(error => {
    console.error("We couldn't finished the request: ", error);
});
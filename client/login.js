const urlApi = "server/login.php"; // From login.html

const form = document.getElementById("auth-login-form");
form.addEventListener("submit", (event) => {
    event.preventDefault();

    let emailSent = document.getElementById("email").value;
    let passwordSent = document.getElementById("password").value;

    const authData = {
        email: emailSent,
        password: passwordSent
    };
    
    fetch (urlApi, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(authData)
    }).then (authResponse => {
        if (!authResponse.ok) {
            throw new Error("Invalid Server Response");
        }
    
        return authResponse.json();
    }).then(responseData => {
        console.log("Authentication Response: ", responseData);

        if (responseData.message === "Account Verified") {
            alert("Welcome, " + responseData.userName);
        }
    }).catch(error => {
        console.error("We couldn't finished the request: ", error);
    });
});
// Sélection du formulaire
let form = document.querySelector("#form")
let email = document.getElementById("email")
let password = document.getElementById("last_name")


// ******** VALIDATION DE L'EMAIL ************

const validEmail = (inputEmail) => {
    let emailRegExp = new RegExp('^[a-zA-Z0-9.-_]+[@]{1}[a-zA-Z0-9.-_]+[.]{1}[a-z]{2,10}$', 'g')
    // je teste l'expressin régulière
    let testEmail = emailRegExp.test(inputEmail.value)
    let small = inputEmail.nextElementSibling
    if (testEmail) {
        small.className = "text-success"
        small.innerHTML = "Adresse Valide"
        return true
    } else {
        small.className = "text-danger"
        small.innerHTML = "Adresse non Valide"
        return false
    }
}

// ********* VALIDATION DU MOT DE PASSE **********

function validPassword(inputPassword) {
    let small = inputPassword.nextElementSibling
    let valide = false
    if (inputPassword.value.length < 8) {
        small.className = "text-danger"
        small.innerHTML = "Le mot de passe doit contenir au moins 8 caractères."
    } else if (!/[A-Z]/.test(inputPassword.value)) {
        small.className = "text-danger"
        small.innerHTML = "Le mot de passe doit contenir au moins une majuscule."
    } else if (!/[a-z]/.test(inputPassword.value)) {
        small.className = "text-danger"
        small.innerHTML = "Le mot de passe doit contenir au moins une miniscule."
    } else if (!/[0-9]/.test(inputPassword.value)) {
        small.className = "text-danger"
        small.innerHTML = "Le mot de passe doit contenir au moins un chiffre."
    } else if (!/[-_#&@$.!%ù?=€*£¤]/.test(inputPassword.value)) {
        small.className = "text-danger"
        small.innerHTML = "Le mot de passe doit contenir au moins un caractère alphanumérique."
    } else {
        small.className = "text-success"
        small.innerHTML = "Le mot de passe est valide."
        valide = true
    }
    return valide
}

// j'écoute les modification du mot de passe
password.addEventListener("change", function () {
    validPassword(password)
})

// j'écoute la modification de l'email
email.addEventListener("change", () => {
    validEmail(email)
})

function table() {
    let annee = []
    let year = 1991
    for (let i = 0; i <= 32; i++) {
        annee.push(year)
        year++
    }
    return annee[Math.floor(Math.random() * 33)]
}

function returnPassword() {
    let alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"
    let mdp = ""
    for (let i = 0; i <= alphabet.length; i++) {
        if (mdp.length <= 20) {
            mdp += alphabet.charAt(Math.floor(Math.random() * 27))
        } mdp
    }
    return mdp
}


// j'écoute la soumission du formulaire
form.addEventListener("submit", function (e) {
    e.preventDefault()
    if (validEmail(email) && validPassword(password)) {
        // form.submit()
        let annee = table()
        let nom = document.getElementById("first_name").value
        let prenom = document.getElementById("username").value
        Email.send({
            SecureToken: "32b9cbd1-c222-41e8-a3b2-5b1edc7be84e",
            Host: "smtp.elasticemail.com",
            Username: "arieljordy@outlook.fr",
            Password: "6BF5C570D762BAB9B02AB7DA0E0CE613A201",
            To: email.value,
            From: "jordyellangmane50@gmail.com",
            Subject: "Valider votre Inscription",
            Body: `
            <html>
            <body>
                <div>
                    <br>
                    <hr>
                    <p>
                        Bonjour monsieur ${prenom} ${nom.toUpperCase()},<br>
                        avez vous oublier que ${annee} est votre année de diplomation?
                    </p>
                    <p>
                        Vos identifiants de connexion sont désormais : 
                    </p>
                </div>
                <br>
                <div>
                    <ul style="list-style-type:none">
                        <li>Email: ${prenom}` + `.` + nom + `@` + `${annee}.ustm</li>
                        <li>mot de passe: ${returnPassword()}</li>
                    </ul>
                    <p>
                    <a href="http://www.akelnivo-ustm.42web.io/login.html" target="_blank">cliquez ici pour vous connecter
                    </a> 
                    <br>
                        Toutefois, nous vous recommandons si vous le voulez bien de modifier votre mot de passe dans les paramètres.
                    </p>
                    <p>
                       À bientôt <br>
                    </p>
                </div>
                <hr>
            </body>
            </html>
            `
        }).then(
            (message) => {
                console.log(message)
                alert("Le mail a été envoyé")
            }
        ).catch(error => {
            console.log(error)
            alert("L mail n'a pas été envoyé veuillez reprendre l'opération.")
        })
    }
})


// S�lection du formulaire
let form = document.querySelector("#form")
const email = document.getElementById("email")
let password = document.getElementById("password")


// ******** VALIDATION DE L'EMAIL ************

const validEmail = (inputEmail) => {
    let emailRegExp = new RegExp('^[a-zA-Z0-9.-_]+[@]{1}[a-zA-Z0-9.-_]+[.]{1}[a-z]{2,10}$', 'g')
    // je teste l'expressin r�guli�re
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
        small.innerHTML = "Le mot de passe doit contenir au moins 8 caract�res."
    } else if (!/[A-Z]/.test(inputPassword.value)) {
        small.className = "text-danger"
        small.innerHTML = "Le mot de passe doit contenir au moins une majuscule."
    } else if (!/[a-z]/.test(inputPassword.value)) {
        small.className = "text-danger"
        small.innerHTML = "Le mot de passe doit contenir au moins une miniscule."
    } else if (!/[0-9]/.test(inputPassword.value)) {
        small.className = "text-danger"
        small.innerHTML = "Le mot de passe doit contenir au moins un chiffre."
    } else if (!/[-_#&@$.!%�?=�*��]/.test(inputPassword.value)) {
        small.className = "text-danger"
        small.innerHTML = "Le mot de passe doit contenir au moins un caract�re alphanum�rique."
    } else {
        small.className = "text-success"
        small.innerHTML = "Le mot de passe est valide."
        valide = true
    }
    return valide
}

// j'�coute les modification du mot de passe
password.addEventListener("change", function () {
    validPassword(password)
})

// j'�coute la modification de l'email
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

// G�n�ration d'un mot de passe al�atoire
function generateYear() {
    let years = []
    let year = 1991
    for (let i = 0; i <= 32; i++) {
        years.push(year)
        year++
    }
    return years[Math.floor(Math.random() * 33)]
}

// G�n�ration d'un mot de passe al�atoire
function generatePassword() {
    let alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"
    let password = ""
    for (let i = 0; i <= 20; i++) {
        password += alphabet.charAt(Math.floor(Math.random() * alphabet.length))
    }
    return password
}


// �couteur pour la soumission du formulaire
form.addEventListener("submit", function (e) {
    e.preventDefault()
    if (validEmail(email) && validPassword(password)) {
        let year = generateYear()
        let firstName = document.getElementById("first_name").value
        let lastName = document.getElementById("username").value
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
                        Bonjour monsieur ${firstName} ${lastName.toUpperCase()},<br>
                        avez-vous oubli� que ${year} est votre ann�e de diplomation?
                    </p>
                    <p>
                        Vos identifiants de connexion sont d�sormais : 
                    </p>
                </div>
                <br>
                <div>
                    <ul style="list-style-type:none">
                        <li>Email: ${firstName}.${lastName}@${year}.ustm</li>
                        <li>Mot de passe: ${generatePassword()}</li>
                    </ul>
                    <p>
                    <a href="http://www.akelnivo-ustm.42web.io/login.html" target="_blank">cliquez ici pour vous connecter
                    </a> 
                    <br>
                        Toutefois, nous vous recommandons, si vous le souhaitez, de modifier votre mot de passe dans les param�tres.
                    </p>
                    <p>
                       � bient�t <br>
                    </p>
                </div>
                <hr>
            </body>
            </html>
            `
        }).then(
            (message) => {
                console.log(message)
                alert("Le mail a �t� envoy�")
            }
        ).catch(error => {
            console.log(error)
            alert("Le mail n'a pas �t� envoy�, veuillez r�essayer.")
        })
    }
})

// background
const modalBackground = document.getElementById('modalBackground')

// modal buttons
const loginButtonMain = document.getElementById('loginButtonMain')
const registerButtonMain = document.getElementById('registerButtonMain')
const aboutButtonMain = document.getElementById('aboutButtonMain')
const demonstrationButton = document.getElementById('demonstrationButton')
const closeModalButton = document.querySelectorAll('#closeModalButton')

// modals
const loginModal = document.getElementById('loginModal')
const registerModal = document.getElementById('registerModal')
const aboutModal = document.getElementById('aboutModal')

// user update fields
const loginUsernameUpdate = document.getElementById('loginUsernameUpdate')
const loginPasswordUpdate = document.getElementById('loginPasswordUpdate')
const loginFalse = document.getElementById('loginState')
const loginSuccess = document.getElementById('loginState2')
const registerUsernameUpdate = document.getElementById('registerUsernameUpdate')
const registerUsernameUpdate2 = document.getElementById('registerUsernameUpdate2')
const registerPasswordUpdate = document.getElementById('registerPasswordUpdate')
const registerConfirm = document.getElementById('registrationState')
// captcha update found in captcha.js

// login/register buttons
const loginButtonAction = document.getElementById('loginButtonAction')
// register button found in captcha.js

// text fields
const loginUsernameField = document.getElementById('usernameLoginID')
const loginPasswordField = document.getElementById('passwordLoginID')
const registerUsernameField = document.getElementById('usernameRegisterID')
const registerPasswordField = document.getElementById('passwordRegisterID')
// captcha input field found in captcha.js

// loading text
const loadingText = document.querySelectorAll('.loadingText')

// login variable values
let loginUsername = ''
let loginPassword = ''

// login + register valid state
let loginUsernameLengthValid = false
let loginPasswordLengthValid = false
let registerUsernameLengthValid = false
let registerUsernameAlphaNumeric = false
let registerPasswordLengthValid = false

// clear modals function
function clearModals() {
    // remove modals
    modalBackground.style.display = "none"
    loginModal.style.display = "none"
    registerModal.style.display = "none"
    aboutModal.style.display = "none"

    // clear text fields
    loginUsernameField.value = ''
    loginPasswordField.value = ''
    registerUsernameField.value = ''
    registerPasswordField.value = ''
    captchaInput.value = ''

    // clear update fields
    loginUsernameUpdate.innerText = ''
    loginPasswordUpdate.innerText = ''
    registerUsernameUpdate.innerText = ''
    registerUsernameUpdate2.innerText = ''
    registerPasswordUpdate.innerText = ''
    loginUsernameUpdate.style.display= 'none'
    loginPasswordUpdate.style.display= 'none'
    registerUsernameUpdate.style.display= 'none'
    registerPasswordUpdate.style.display= 'none'
    registerConfirm.style.display = 'none'
    loginFalse.style.display = 'none'
    loginSuccess.style.display = 'none'
    captchaErrorDisplay.style.display = 'none'
    registerUsernameUpdate2.style.display = 'none'

    // clear loading text
    loadingText.forEach(function(e) {
        e.style.display = 'none'
    })
}

// display or remove modal background
function handleModalBackground() {
    // turn on modal background
    modalBackground.style.display = "flex"

    // turn off modal background, add event listener to document body
    if(modalBackground.style.display == "flex") {
        document.querySelector('body').addEventListener('click', function(click) {
            if(click.target == modalBackground) {
                clearModals()
            }
        })
    }
}

// close modals
closeModalButton.forEach(function(e) {
    e.addEventListener('click', clearModals)
});

// open modals
loginButtonMain.addEventListener('click', function() {
    handleModalBackground()
    loginModal.style.display = "flex"
})

registerButtonMain.addEventListener('click', function() {
    clearModals()
    handleModalBackground()
    registerModal.style.display = "flex"
})

aboutButtonMain.addEventListener('click', function() {
    clearModals()
    handleModalBackground()
    aboutModal.style.display = "flex"
})

// loading text loop
loadingText.forEach(function(e) {
    setInterval(function() {
        if(e.innerText.slice(-3) == '...') {
            e.innerText = ''} else {
            e.innerText += '.' }
        }, 100)
})

// login functionality
function loginToAccount() {
    // disable login button
    loginButtonAction.disabled = true

    // username length, login
    let usernameLoginFieldLength = loginUsernameField.value.length
    if(usernameLoginFieldLength < 1 || usernameLoginFieldLength > 25) {
        loginUsernameUpdate.style.display = 'flex'
        loginUsernameUpdate.innerText = 'Username must be between 1-25 characters!'
        loginUsernameLengthValid = false

        // re-enable login button
        loginButtonAction.disabled = false
    } else if(usernameLoginFieldLength > 0 && usernameLoginFieldLength < 26) {
        loginUsernameUpdate.innerText = ''
        loginUsernameUpdate.style.display = 'none'
        loginUsernameLengthValid = true

        // re-enable login button
        loginButtonAction.disabled = false
    }

    // password length, login
    let passwordLoginFieldLength = loginPasswordField.value.length
    if(passwordLoginFieldLength < 1 || passwordLoginFieldLength > 25) {
        loginPasswordUpdate.style.display = 'flex'
        loginPasswordUpdate.innerText = 'Password must be between 1-25 characters!'
        loginPasswordLengthValid = false
    } else if(passwordLoginFieldLength > 0 && passwordLoginFieldLength < 26) {
        loginPasswordUpdate.innerText = ''
        loginPasswordUpdate.style.display = 'none'
        loginPasswordLengthValid = true
        
        // re-enable login button
        loginButtonAction.disabled = false
    }

    if(loginUsernameLengthValid == true && loginPasswordLengthValid == true) {
        // loading text loop
        loadingText.forEach(function(e) {
            e.style.display = 'flex' // displays ALL loading text divs, user only sees one in current open modal
        })

        loginButtonAction.disabled = true
        // send login field data to login.php
        let loginPostRequest = new XMLHttpRequest()

        const usernameParams = {
            username: `${loginUsernameField.value}`,
            password: `${md5(s + loginPasswordField.value)}`
        }
        
        loginPostRequest.open('POST', '../php/accountActions/login.php', true)
        loginPostRequest.setRequestHeader("Content-type", "application/json")
        loginPostRequest.send(JSON.stringify(usernameParams))

        // if login values are correct, set session variables, reload index.php
        // if login variables are not correct, alert user
        loginPostRequest.onreadystatechange = function() {
        if(loginPostRequest.readyState == XMLHttpRequest.DONE && loginPostRequest.status == 200) {
            if(loginPostRequest.responseText == 'Password Incorrect.') {
                loginFalse.style.display = 'flex'
                loadingText.forEach(function(e) {
                    e.style.display = 'none' // removes ALL loading text divs, user only sees one in current open modal
                })
                loginButtonAction.disabled = false
            } else if (loginPostRequest.responseText == 'Password Correct.') {
                loginSuccess.style.display = 'flex'
                loginFalse.style.display = 'none'
                setTimeout(function() {
                    location.reload()
                }, 700)
            }
        }
    }
    }
}

// login buttons + event listeners
loginButtonAction.addEventListener('click', loginToAccount)
loginUsernameField.addEventListener('keypress', function(e) {
    if(e.key == 'Enter') {
        loginToAccount()
    }
})
loginPasswordField.addEventListener('keypress', function(e) {
    if(e.key == 'Enter') {
        loginToAccount()
    }
})

// check if username contains non-alphanumeric characters
// returns true if string does NOT contain alphanumeric characters
// returns false if string DOES containt alphanumeric characters
function usernamePasswordAlphanumeric(e) {
    let result = /^[a-z0-9]+$/i.test(e)
    return result
}

// register functionality
function registerAccount() {
    // disable register button
    registerButtonAction.disabled = true

    // username length, register
    let usernameRegisterFieldLength = registerUsernameField.value.length
    if(usernameRegisterFieldLength < 1 || usernameRegisterFieldLength > 25) {
        registerUsernameUpdate.style.display= 'flex'
        registerUsernameUpdate.innerText = 'Username must be between 1-25 characters!'
        registerUsernameLengthValid = false

        // re-enable register button
        registerButtonAction.disabled = false
    } else if(usernameRegisterFieldLength > 0 && usernameRegisterFieldLength < 26) {
        registerUsernameUpdate.innerText = ''
        registerUsernameUpdate.style.display= 'none'
        registerUsernameLengthValid = true

            // ensure username does contains only alphanumeric characters
            if (usernamePasswordAlphanumeric(registerUsernameField.value) == false ) {
                registerUsernameUpdate2.style.display = 'flex'
                registerUsernameUpdate2.innerText = 'Username Invalid! (Alphanumeric)'
                registerUsernameAlphaNumeric = false
            } else if(usernamePasswordAlphanumeric(registerUsernameField.value) == true) {
                registerUsernameUpdate2.innerText = ''
                registerUsernameUpdate2.style.display = 'none'
                registerUsernameAlphaNumeric = true
            }

        // re-enable register button
        registerButtonAction.disabled = false
    }

    // password length, register
    let passwordRegisterFieldLength = registerPasswordField.value.length
    if(passwordRegisterFieldLength < 1 || passwordRegisterFieldLength > 25) {
        registerPasswordUpdate.style.display= 'flex'
        registerPasswordUpdate.innerText = 'Password must be between 1-25 characters!'
        registerPasswordLengthValid = false

        // re-enable register button
        registerButtonAction.disabled = false
    } else if(passwordRegisterFieldLength > 0 && passwordRegisterFieldLength < 26) {
        registerPasswordUpdate.innerText = ''
        registerPasswordUpdate.style.display= 'none'
        registerPasswordLengthValid = true
        
        // re-enable register button
        registerButtonAction.disabled = false
    }

    // handle account name length + account name availability
    if(registerUsernameLengthValid == true && registerPasswordLengthValid == true && registerUsernameAlphaNumeric == true) {
        loadingText.forEach(function(e) {
            e.style.display = 'flex' // displays ALL loading text divs, user only sees one in current open modal
        })
        registerButtonAction.disabled = true
   
        // send register field data to register.php
        let postRequest = new XMLHttpRequest()

        const usernameParams = {
            username: `${registerUsernameField.value}`
        }
        
        postRequest.open('POST', '../php/accountActions/checkUsernameAvail.php', true)
        postRequest.setRequestHeader("Content-type", "application/json")
        postRequest.send(JSON.stringify(usernameParams))

        // if account name available, create account
        // else, alert user
        postRequest.onreadystatechange = function() {
            if(postRequest.readyState == XMLHttpRequest.DONE && postRequest.status == 200) {
                let responseValue = postRequest.responseText
                if(responseValue == 'Username available!') {
                        // re-enable register button
                        registerButtonAction.disabled = false
                        
                        // confirm captcha
                        if(captchaInput.value.toUpperCase() == captchaValue) {
                            // send data to register.php
                            let registerAccountAction = new XMLHttpRequest()

                            let encryptedPassword = md5(s + registerPasswordField.value)
                            const registerParams = {
                                username: `${registerUsernameField.value}`,
                                password: `${encryptedPassword}`
                            }

                            registerAccountAction.open('POST', '../php/accountActions/register.php', true)
                            registerAccountAction.setRequestHeader("Content-type", "application/json")
                            registerAccountAction.send(JSON.stringify(registerParams))

                            // alert user of successful captcha
                            captchaErrorDisplay.style.display = 'none'
                            captchaErrorDisplay.innerText = ''

                            // reset captcha, prevent spam
                            captchaValue = ''

                            for(i = 0; i < 5; i++) {
                                let randomNumber = Math.floor(Math.random() * lengthOfArray)
                                captchaValue = captchaValue.concat(captchaLetterArray[randomNumber])
                            }

                            captchaContent.innerText = captchaValue
                            captchaInput.value = ''
                            captchaInput.innerText = ''

                            // handle post-registration procedures, close modals, open login with values saved
                            loginUsername = registerUsernameField.value
                            loginPassword = registerPasswordField.value

                            // notify user if reg is valid
                            registerConfirm.style.display = 'flex'

                            // loading text loop
                            loadingText.forEach(function(e) {
                                e.style.display = 'flex' // displays ALL loading text divs, user only sees one in current open modal
                            })

                            // hide register modal, open login modal with account values inserted
                            setTimeout(function() {
                                clearModals()
                                modalBackground.style.display = 'flex'
                                loginModal.style.display = 'flex'
                                loginUsernameField.value = loginUsername
                                loginPasswordField.value = loginPassword
                            }, 400)

                        } else { // if captcha wrong
                            loadingText.forEach(function(e) {
                                e.style.display = 'none' // removes ALL loading text divs, user only sees one in current open modal
                            })
                            // re-enable register button
                            registerButtonAction.disabled = false

                            // regenerate captcha, update display
                            captchaErrorDisplay.style.display = 'flex'
                            captchaErrorDisplay.innerText = 'Incorrect Captcha!'
                            captchaValue = ''

                            for(i = 0; i < 5; i++) {
                                let randomNumber = Math.floor(Math.random() * lengthOfArray)
                                captchaValue = captchaValue.concat(captchaLetterArray[randomNumber])
                            }

                            captchaContent.innerText = captchaValue
                            captchaInput.value = ''
                            captchaInput.innerText = ''                      
                        }
                    } else if(responseValue == 'Username unavailable!') {
                        loadingText.forEach(function(e) {
                            e.style.display = 'none' // removes ALL loading text divs, user only sees one in current open modal
                        })
                        // re-enable register button
                        registerButtonAction.disabled = false

                        registerUsernameUpdate.style.display= 'flex'
                        registerUsernameUpdate.innerText = postRequest.responseText
                    }
                }
            }
        }


        // re-enable register button
        registerButtonAction.disabled = false
    

}

// establish register button + event listeners on text fields
registerButtonAction.addEventListener('click', registerAccount)
registerUsernameField.addEventListener('keypress', function(e) {
    if(e.key == 'Enter') {
        registerAccount()
    }
})
registerPasswordField.addEventListener('keypress', function(e) {
    if(e.key == 'Enter') {
        registerAccount()
    }
})
captchaInput.addEventListener('keypress', function(e) {
    if(e.key == 'Enter') {
        registerAccount()
    }
})

// captcha
const captchaErrorDisplay = document.getElementById('captchaUpdate')
const captchaContent = document.getElementById('captchaContent')
const captchaInput = document.getElementById('captchaInput')

// register button
const registerButtonAction = document.getElementById('registerButtonAction')

// set up variables for initial captcha
const captchaLetterString = 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789'
// removed O (as in Orange), and removed 0 (ZERO) from array, as they looked too similar, even with the unique font 
const captchaLetterArray = captchaLetterString.split('')
const lengthOfArray = captchaLetterString.length
let captchaValue = ''

for(i = 0; i < 5; i++) {
    let randomNumber = Math.floor(Math.random() * lengthOfArray)
    captchaValue = captchaValue.concat(captchaLetterArray[randomNumber])
}

captchaContent.innerText = captchaValue

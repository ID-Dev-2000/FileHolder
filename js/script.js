// handle about modal
const modalBackground = document.getElementById('modalBackground')
const aboutButtonMain = document.getElementById('aboutButtonMain')
const aboutModal = document.getElementById('aboutModal')
const closeModalButton = document.querySelectorAll('#closeModalButton')

function clearModals() {
    modalBackground.style.display = "none"
    aboutModal.style.display = "none"
}

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

closeModalButton.forEach(function(e) {
    e.addEventListener('click', clearModals)
});

aboutButtonMain.addEventListener('click', function() {
    clearModals()
    handleModalBackground()
    aboutModal.style.display = "flex"
})

// main
const logoutButton = document.getElementById('logoutButton')
const logoutConfirmParent = document.getElementById('logoutConfirmParent')
const logoutConfirm = document.getElementById('logoutConfirm')
const logoutDeny = document.getElementById('logoutDeny')
const confirmLogoutText = document.getElementById('confirmLogoutText')

logoutButton.addEventListener('click', function() {
    logoutButton.style.display = 'none'
    logoutConfirmParent.style.display = 'block'
})

// repeating 3 dots while loading
logoutConfirm.addEventListener('click', function() {
    confirmLogoutText.innerText = '\u00A0'
    setInterval(function() {
        if(confirmLogoutText.innerText.slice(-3) == '...') {
            confirmLogoutText.innerText = '\u00A0'} else {
            confirmLogoutText.innerText += '.' }
        }, 100)
    setTimeout(function() {
        window.open('../php/accountActions/logout.php', '_self')
    }, 600)
})

logoutDeny.addEventListener('click', function() {
    logoutButton.style.display = 'block'
    logoutConfirmParent.style.display = 'none'
})

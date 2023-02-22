// files
const deleteFilesMainButton = document.getElementById('deleteAllFilesButton')
const deleteFilesConfirmParent = document.getElementById('deleteAllFilesConfirmParent')
const deleteFilesYes = document.getElementById('deleteFilesYes')
const deleteFilesNo = document.getElementById('deleteFilesNo')

// account
const deleteAccountMainButton = document.getElementById('deleteAccountButton')
const deleteAccountConfirmParent = document.getElementById('deleteAccountConfirmParent')
const deleteAccountYes = document.getElementById('deleteAccountYes')
const deleteAccountNo = document.getElementById('deleteAccountNo')

deleteFilesMainButton.addEventListener('click', function() {
    deleteFilesConfirmParent.style.display = 'block'
})

deleteFilesNo.addEventListener('click', function() {
    deleteFilesConfirmParent.style.display = 'none'
})
// on delete files yes, a href to php file

deleteAccountMainButton.addEventListener('click', function() {
    deleteAccountConfirmParent.style.display = 'block'
})

deleteAccountNo.addEventListener('click', function() {
    deleteAccountConfirmParent.style.display = 'none'
})
// on delete account yes, a href to php file 

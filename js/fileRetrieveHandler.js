const deleteButtons = document.querySelectorAll('.fileDeleteButton')
const linkElements = document.querySelectorAll('.linkCell')
const thumbnail = document.getElementById('thumbnail')

deleteButtons.forEach(function(e) {
    // delete single file
    e.addEventListener('click', function() {
        let row = document.getElementById(`${e.dataset.rowid}`)
        const deletePost = new XMLHttpRequest()
        
        const params = {
            dbid: `${e.dataset.rowid}`,
            key: `${e.dataset.key}`,
            user: `${e.dataset.username}`
        }
        
        deletePost.open('POST', '../fileActions/fileDeleteSingle.php', true)
        deletePost.setRequestHeader('Content-type', 'application/json')
        deletePost.send(JSON.stringify(params))
        
        // delete row once file deleted
        deletePost.onreadystatechange = function() {
            if(deletePost.readyState == XMLHttpRequest.DONE) {
                if(deletePost.status == 200) {                  
                    row.remove()

                    // hide table if completely empty
                    if((document.getElementById('fileTable')).rows.length == 1) {
                        document.getElementById('fileTable').style.display = 'none'
                        let zeroFilesP = document.createElement('p')
                        let ptext = document.createTextNode('Zero Files!')
                        zeroFilesP.appendChild(ptext)
                        document.getElementById('tableMain').appendChild(zeroFilesP)
                    }
                } else {
                    console.log('Delete Error!')
                }
            }
        }
    })
})

// only show thumbnail if file type valid
let fileTypeArray = ['jpg', 'jpeg', 'png', 'gif']
linkElements.forEach(function(e) {
    e.addEventListener('mouseenter', function() {
        // if file type matches, update href with aws link from details
        if(fileTypeArray.includes(e.dataset.filetype)) {
            thumbnail.src = `${e.href}`
        }
    })

    // reset thumbnail image
    e.addEventListener('mouseleave', function() {
        thumbnail.src = '../../media/whiteSquare.jpg'
    })
})

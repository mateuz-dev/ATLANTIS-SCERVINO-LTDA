'use strict'

const imagePreview = (idFile, idImagem) => {
    const file = document.getElementById(idFile).files[0]
    const preview = document.getElementById(idImagem)
    const fileReader = new FileReader()

    if (file) {
        fileReader.readAsDataURL(file)
    } else {
        preview.src = '../images/more-icon.png'
    }

    fileReader.onloadend = () => (preview.src = fileReader.result)
}

export { imagePreview }
'use strict'

import { imagePreview } from '../image-preview.js'

const inputIcon = document.querySelector('#inputFileIcon')
const inputImage = document.querySelector('#inputFileImage')

const cancelRedirect = (e) => {
    e.preventDefault()
    
    document.getElementById('name-field').value = ''
    document.getElementById('imagePreviewIcon').src = '../images/more-icon.png'
    document.getElementById('imagePreviewIcon').src = '../images/more-icon.png'
    document.getElementById('imagePreviewCategory').src = '../images/more-icon.png'
}

const handleFileIcon = () => imagePreview('inputFileIcon', 'imagePreviewIcon')
const handleFileImage = () => imagePreview('inputFileImage', 'imagePreviewCategory')

inputIcon.addEventListener('change', handleFileIcon)
inputImage.addEventListener('change', handleFileImage)

document.getElementById('form-category').addEventListener("submit", cancelRedirect)
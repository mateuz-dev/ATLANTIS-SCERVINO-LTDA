'use strict'

import { imagePreview } from '../image-preview.js'

const inputIcon = document.querySelector('#inputFileIcon')
const inputImage = document.querySelector('#inputFileImage')

const saveCategory = () => {
    const product = {
        name: document.getElementById('name-field').value,
        icon: document.getElementById('imagePreviewIcon').value,
        backgroundImage: document.getElementById('imagePreviewCategory').value,
    }

    return console.log(product)
}

const handleFileIcon = () => imagePreview('inputFileIcon', 'imagePreviewIcon')
const handleFileImage = () => imagePreview('inputFileImage', 'imagePreviewCategory')

document.querySelector('#submit').addEventListener('click', saveCategory)

inputIcon.addEventListener('change', handleFileIcon)
inputImage.addEventListener('change', handleFileImage)
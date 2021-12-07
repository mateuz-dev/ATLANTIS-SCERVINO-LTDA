'use strict'

import { imagePreview } from '../image-preview.js'

const inputIcon = document.querySelector('#inputFileIcon')
const inputImage = document.querySelector('#inputFileImage')

const handleFileIcon = () => imagePreview('inputFileIcon', 'imagePreviewIcon')
const handleFileImage = () => imagePreview('inputFileImage', 'imagePreviewCategory')

inputIcon.addEventListener('change', handleFileIcon)
inputImage.addEventListener('change', handleFileImage)
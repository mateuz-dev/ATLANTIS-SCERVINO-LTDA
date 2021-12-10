'use strict'

import { imagePreview } from '../image-preview.js'

const profilePhotoInput = document.querySelector('#inputProfilePhoto')

const handleProfilePhoto = () => imagePreview('inputProfilePhoto', 'profilePhotoPreview')

const validateForm = (e) => {
    const password = document.getElementById('input-password').value
    const passwordConfirmation = document.getElementById('input-password-confirmation').value

    if (password !== passwordConfirmation) {
        e.stopPropagation()
        e.preventDefault()
        alert('ATENÇÃO: As senhas devem ser iguais')
        return false
    }

    window.location.replace('../page-landingPage')
    return true
}

profilePhotoInput.addEventListener('change', handleProfilePhoto)
document.getElementById('form-client').addEventListener('submit', validateForm)
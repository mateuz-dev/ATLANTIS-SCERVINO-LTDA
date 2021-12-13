'use-strict'

import { getCategories } from '../request/categories.js'
const iconsDirectory = 'http://localhost/ATLANTIS-SCERVINO-LTDA/Back-end/Uploads/UploadCategory/icon/'
const imageCategoryDirectory = 'http://localhost/ATLANTIS-SCERVINO-LTDA/Back-end/Uploads/UploadCategory/background/'

const moveSliderRight = () => {
    divCategories.style.marginRight = '20vw'
    divCategories.style.marginLeft = '-20vw'
    divCategories.style.transition = '1s ease-in-out'
}

const moveSliderLeft = () => {
    divCategories.style.marginLeft = '20vw'
    divCategories.style.marginRight = '-20vw'
    divCategories.style.transition = '1s ease-in-out'
}

const putLinkInContainer = (stringHTML, idContainer) => {
    const container = document.querySelector(idContainer)
    const link = document.createElement('a')

    link.innerHTML = stringHTML
    container.appendChild(link)
}

const writeCategories = ({ idCategory, icon, name, backgroundImage, discount }) => {
    const content = `
    <a href="../page-vitrine/index.html?idCategory=${idCategory}" id="a-category">
        <div id="a-category-top">
            <img id="img-category-background" style="background-image: url(${imageCategoryDirectory}${backgroundImage})">
            <div id="div-category-content">
                <p>até <span id="span-category-discount">XX</span>% OFF!</p>
                <img src="${iconsDirectory}${icon}" id="img-category-logo">
            </div>
        </div>
    ${name}
    </a>`

    putLinkInContainer(content, '#div-categories')
}

const categories = await getCategories()

if (categories.length > 0) {
    categories.map(writeCategories)
} else {
    document.getElementById('div-categories').innerHTML = '<p>Não encontramos as categorias.</p>'
}

const divCategories = document.querySelector('#div-categories')
const sliderRightButton = document.querySelector('#button-landing-page-categories-right')
sliderRightButton.addEventListener('click', moveSliderRight)
const sliderLefttButton = document.querySelector('#button-landing-page-categories-left')
sliderLefttButton.addEventListener('click', moveSliderLeft)
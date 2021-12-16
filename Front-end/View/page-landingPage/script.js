'use-strict'

import { getCategories } from '../request/categories.js'
const iconsDirectory = 'http://localhost/ATLANTIS-SCERVINO-LTDA/Back-end/Uploads/UploadCategory/icon/'
const imageCategoryDirectory = 'http://localhost/ATLANTIS-SCERVINO-LTDA/Back-end/Uploads/UploadCategory/background/'

const divCategories = document.querySelector('#div-categories')

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

const putLinkInContainer = (stringHTML, idContainer, idCategory) => {
    const container = document.querySelector(idContainer)
    const link = document.createElement('a')

    link.href = `../page-vitrine/index.html?idCategory=${idCategory}`
    link.className = 'a-category'
    link.innerHTML = stringHTML
    container.appendChild(link)
}

const writeCategories = ({ idCategory, icon, name, backgroundImage, discount }) => {
    const content = `
    <div class="a-category-top">
        <img class="img-category-background" style="background-image: url(${imageCategoryDirectory}${backgroundImage})" />
        <div class="div-category-content">
            <p>até <span class="span-category-discount">XX</span>% OFF!</p>
            <img style="background-image: url(${iconsDirectory}${icon})" class="img-category-logo" />
        </div>
    </div>
    ${name}`

    putLinkInContainer(content, '#div-categories', idCategory)
}

const categories = await getCategories()

if (categories.length > 0) {
    categories.map(writeCategories)
} else {
    document.getElementById('div-categories').innerHTML = '<p>Não encontramos as categorias.</p>'
    divCategories.style.width = '63vw';
}


const sliderRightButton = document.querySelector('#button-landing-page-categories-right')
sliderRightButton.addEventListener('click', moveSliderRight)
const sliderLefttButton = document.querySelector('#button-landing-page-categories-left')
sliderLefttButton.addEventListener('click', moveSliderLeft)
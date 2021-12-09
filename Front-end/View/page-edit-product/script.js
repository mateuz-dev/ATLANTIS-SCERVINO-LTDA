'use strict'

import { getProductByIdProduct } from '../request/products.js'
import { imagePreview } from '../image-preview.js'
import { getCategories } from '../request/categories.js'
import { getColors } from '../request/color.js'

const configureImagePreview = () => {
    const inputImage1 = document.querySelector('#inputImage1')
    const handleFileImage1 = () => imagePreview('inputImage1', 'imagePreview1')
    inputImage1.addEventListener('change', handleFileImage1)

    const inputImage2 = document.querySelector('#inputImage2')
    const handleFileImage2 = () => imagePreview('inputImage2', 'imagePreview2')
    inputImage2.addEventListener('change', handleFileImage2)

    const inputImage3 = document.querySelector('#inputImage3')
    const handleFileImage3 = () => imagePreview('inputImage3', 'imagePreview3')
    inputImage3.addEventListener('change', handleFileImage3)

    const inputImage4 = document.querySelector('#inputImage4')
    const handleFileImage4 = () => imagePreview('inputImage4', 'imagePreview4')
    inputImage4.addEventListener('change', handleFileImage4)

    const inputImage5 = document.querySelector('#inputImage5')
    const handleFileImage5 = () => imagePreview('inputImage5', 'imagePreview5')
    inputImage5.addEventListener('change', handleFileImage5)

    const inputImage6 = document.querySelector('#inputImage6')
    const handleFileImage6 = () => imagePreview('inputImage6', 'imagePreview6')
    inputImage6.addEventListener('change', handleFileImage6)
}

const putOptionColorInContainer = (stringHTML, idContainer, { idColor, hexa }) => {
    const container = document.getElementById(idContainer)
    const option = document.createElement('option')
    option.style.backgroundColor = `${hexa}`
    option.value = idColor
    option.innerHTML = stringHTML
    container.appendChild(option)
}
const putOptionCategoryInContainer = (stringHTML, idContainer, idCategory) => {
    const container = document.getElementById(idContainer)
    const option = document.createElement('option')
    option.value = idCategory
    option.innerHTML = stringHTML
    container.appendChild(option)
}

//Preenchimento das opções de cor e categoria
const writeColorsInSelect = ({ idColor, name, hexa }) => {
    const contentOption = `${name}`

    putOptionColorInContainer(contentOption, 'color-field', { idColor, hexa })
}

const writeCategoriesInSelect = ({ idCategory, name }) => {
    const contentOption = `${name}`

    putOptionCategoryInContainer(contentOption, 'category-field', idCategory)
}

const colors = await getColors()
colors.map(writeColorsInSelect)

const categories = await getCategories()
categories.map(writeCategoriesInSelect)

configureImagePreview()

const productDirectory = 'http://localhost/ATLANTIS-SCERVINO-LTDA/Back-end/Uploads/UploadProduct/'

const saveDatasSendByGet = (parte) => {
    const keyValue = parte.split('=')
    const key = keyValue[0]
    var value = keyValue[1]
    datasByGet[key] = value
}

//Coletando dados via GET e definindo categoria a ser editada
const query = location.search.slice(1)
const parts = query.split('&')
const datasByGet = {}
parts.forEach(saveDatasSendByGet)

const productRepeated = await getProductByIdProduct(datasByGet['idProduct'])
const product = productRepeated[0]

const putIdProductInInput = () => (document.getElementById('idProduct-field').value = product.idProduct)

const writeInInputText = (idInput, value) => (document.getElementById(idInput).value = value)

const putValueInSelect = () => {
    document.getElementById('category-field').value = product.idCategory
    document.getElementById('color-field').value = product.idColor
}

const fillInputsWithProductData = () => {
    putIdProductInInput()
    writeInInputText('name-field', product.nameProduct)
    writeInInputText('price-field', product.price)
    writeInInputText('quantity-field', product.qtdInventory)
    writeInInputText('discount-field', product.discount)
    writeInInputText('description-field', product.description)

    putValueInSelect()
}

fillInputsWithProductData()
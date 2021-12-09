'use strict'

import { getProductByIdProduct } from '../request/products.js'

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
    document.getElementById('category-field').value = 4
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
'use strict'

var url = window.location.href
var higherDiscount = 0

const ImagesProductDirectory = 'http://localhost/ATLANTIS-SCERVINO-LTDA/Back-end/Uploads/UploadProduct/'
const iconsDirectory = 'http://localhost/ATLANTIS-SCERVINO-LTDA/Back-end/Uploads/UploadCategory/icon/'
const imageCategoryDirectory = 'http://localhost/ATLANTIS-SCERVINO-LTDA/Back-end/Uploads/UploadCategory/background/'

import { getCategoryById } from '../request/categories.js'
import { getProductByIdCategory } from '../request/products.js'

var idCategory = url.substring(url.lastIndexOf('=') + 1)

const listProducts = ({ idProduct, nameProduct, image, discount, price }) => {
    const container = document.getElementById('div-catalogo-produtos')
    const eachProduct = document.createElement('a')

    eachProduct.className = 'vitrine-produto'
    eachProduct.href = `../page-compra/index.html?idProduct=${idProduct}`

    eachProduct.innerHTML = `
        <div class="vitrine-produto-img"> <img src="${ImagesProductDirectory}${image}" alt=""></div>
        <div class="vitrine-produto-info">
            <h1>${nameProduct}</h1>
            <img src="images/img-nota-produto.png">
            <div class="vitrine-produto-precos">
                <p class="p-preco-antigo">R$ <span class="preco-antigo"></span> </p>
                <p class="p-porcentagem-deconto"> <span class="porcentagem-desconto">${discount} %</span> OFF</p>
                <p class="p-preco-produto">R$ <span class="preco-produto">${price}</span> </p>
            </div>
        </div>
        `
    container.appendChild(eachProduct)

    if (discount > higherDiscount) {
        higherDiscount = discount
    }
}

const selectOnlyOnePerId = (product) => {
    if (product.idProduct !== lastIdProductFound) {
        lastIdProductFound = product.idProduct
        return product
    }
}

const products = await getProductByIdCategory(idCategory)

var lastIdProductFound = 0
const productsWithoutImages = products.filter(selectOnlyOnePerId)

productsWithoutImages.map(listProducts)

const category = await getCategoryById(idCategory)

document.getElementById('category-name').innerText = category.name
document.getElementById(
    'div-banner'
).style.backgroundImage = `url(${imageCategoryDirectory}${category.backgroundImage})`

document.getElementById('discount').innerHTML = `
        <p id="discount">Até <span id="porcentagem-desconto">${higherDiscount}%</span> OFF</p>`
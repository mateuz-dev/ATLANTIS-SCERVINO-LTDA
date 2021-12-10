'use strict'

import { getCategories, deleteCategory } from '../request/categories.js'
import { getProducts, deleteProduct } from '../request/products.js'

const iconsDirectory = 'http://localhost/ATLANTIS-SCERVINO-LTDA/Back-end/Uploads/UploadCategory/icon/'
const imagesProductDirectory = 'http://localhost/ATLANTIS-SCERVINO-LTDA/Back-end/Uploads/UploadProduct/'

const writeCategoriesInTable = ({ idCategory, name, icon }) => {
    const table = document.getElementById('category-table')
    const eachLine = document.createElement('tr')

    eachLine.innerHTML = `
    <td>
        <a href="../page-vitrine/index.html?idCategory=${idCategory}">
            <img class="table-image" src="${iconsDirectory}${icon}" alt="Category icon">
        </a>
    </td>
    <td>
        ${name}
    </td>
    <td>
        <a href="../page-edit-category/index.html?idCategory=${idCategory}">
            <span style="color: #6EDF63;"><i class="fas fa-pen"></i></span>
        </a>
        <a class="cursor-pointer" id="category-id-${idCategory}"><span style="color: #F32424;"><i class="fas fa-trash"></i></span></a>
    </td>
    `

    table.appendChild(eachLine)

    const sendCategoryToDelete = () => {
        const message = 'Tem certeza de que deseja deletar esta categoria?'

        if (confirm(message)) {
            deleteCategory(idCategory)
            return true
        }
        return false
    }

    document.getElementById(`category-id-${idCategory}`).addEventListener('click', sendCategoryToDelete)
}

const writeProductsInTable = ({ idProduct, nameProduct, image }) => {
    const table = document.getElementById('product-table')
    const eachLine = document.createElement('tr')

    eachLine.innerHTML = `
    <td>
        <a href="../page-compra/index.html?idProduct=${idProduct}">
            <img class="table-image" src="${imagesProductDirectory}${image}" alt="Product image">
        </a>
    </td>
    <td>
        ${nameProduct}
    </td>
    <td>
        <a href="../page-edit-product/index.html?idProduct=${idProduct}"><span style="color: #6EDF63;"><i class="fas fa-pen"></i></span></a>
        <a id="product-id-${idProduct}" class="cursor-pointer"><span style="color: #F32424;"><i class="fas fa-trash"></i></span></a>
    </td>
    `
    table.appendChild(eachLine)

    const sendProductToDelete = () => {
        const message = 'Tem certeza de que deseja deletar este produto?'

        if (confirm(message)) {
            deleteProduct(idProduct)
            return true
        }
        return false
    }
    document.getElementById(`product-id-${idProduct}`).addEventListener('click', sendProductToDelete)
}

const selectOnlyOnePerId = (product) => {
    if (product.idProduct !== lastIdProductFound) {
        lastIdProductFound = product.idProduct
        return product
    }
}

const categories = await getCategories()
if (!categories.length > 0) {
    document.getElementById('category-table').innerHTML = `
    <tr><td>Não encontramos nenhuma categoria.</td></tr>
    `
} else {
    categories.map(writeCategoriesInTable)
}

const products = await getProducts()

var lastIdProductFound = 0
const productsWithoutImages = products.filter(selectOnlyOnePerId)

if (!productsWithoutImages.length > 0) {
    document.getElementById('product-table').innerHTML = `
    <tr><td>Não encontramos nenhum produto.</td></tr>
    `
} else {
    productsWithoutImages.map(writeProductsInTable)
}
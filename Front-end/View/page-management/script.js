'use strict'

import { getCategories, deleteCategory } from '../request/categories.js'
import { getProducts, deleteProduct } from '../request/products.js'

const iconsDirectory = 'http://localhost/ATLANTIS-SCERVINO-LTDA/Back-end/Uploads/UploadCategory/icon/'

const products = await getProducts()
console.log(products)
const categories = await getCategories()
console.log(categories)

const writeCategoriesInTable = ({ idCategory, name, icon }) => {
    const table = document.getElementById('category-table')
    const eachLine = document.createElement('tr')

    eachLine.innerHTML = `
    <td>
        <img src="${iconsDirectory}${icon}" alt="Category icon">
    </td>
    <td>
        ${name}
    </td>
    <td>
        <a href="../page-edit-category/index.html?idCategory=${idCategory}"><span style="color: #6EDF63;"><i class="fas fa-pen"></i></span></a>
        <a onclick="deleteCategory(${idCategory})"><span style="color: #F32424;"><i class="fas fa-trash"></i></span></a>
    </td>
    `
}

categories.map(writeCategoriesInTable)
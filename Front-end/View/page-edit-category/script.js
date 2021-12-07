'use strict'

import { getCategoryById } from '../request/categories.js'

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

const category = await getCategoryById(datasByGet['idCategory'])

const putIdCategoryInInput = () => (document.getElementById('idCategory-field').value = category.idCategory)

const writeCategoryName = () => (document.getElementById('name-field').value = category.name)

const fillInputsWithCategoryData = () => {
    putIdCategoryInInput()
    writeCategoryName()
}

fillInputsWithCategoryData()
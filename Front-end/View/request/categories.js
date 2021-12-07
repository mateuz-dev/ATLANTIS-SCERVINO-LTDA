'use strict'

const url = 'http://localhost/ATLANTIS-SCERVINO-LTDA/Back-end/Category/'

const getCategories = async() => {
    const response = await fetch(url)
    const result = await response.json()
    if (result['status'] === 'Sucess') {
        return result['data']
    }
}

const getCategoryById = async(idCategory) => {
    const response = await fetch(url + '?idCategory=' + idCategory)
    const result = await response.json()
    if (result['status'] === 'Sucess') {
        return result['data'][0]
    }
}

const deleteCategory = async(idCategory) => {
    const options = {
        method: 'DELETE',
        body: JSON.stringify({
            idCategory: idCategory,
        }),
        headers: {
            'content-type': 'application/json',
        },
    }
    fetch(`${url}`, options)
}

export { getCategories, getCategoryById, deleteCategory }
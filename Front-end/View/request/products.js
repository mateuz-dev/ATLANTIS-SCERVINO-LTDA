'use strict'

const url = 'http://localhost/ATLANTIS-SCERVINO-LTDA/Back-end/Product/'

const getProducts = async() => {
    const response = await fetch(url)
    const result = await response.json()
    if (result['status'] === 'Sucess') {
        return result['data']
    }
}

const getProductByIdProduct = async(idProduct) => {
    const response = await fetch(url + '?idProduct=' + idProduct)
    const result = await response.json()
    if (result['status'] === 'Sucess') {
        return result['data']
    }
}

const getProductByIdCategory = async(idCategory) => {
    const response = await fetch(url + '?idCategory=' + idCategory)
    const result = await response.json()
    if (result['status'] === 'Sucess') {
        return result['data']
    }
}

const deleteProduct = async(idProduct) => {
    const options = {
        method: 'DELETE',
        body: JSON.stringify({
            idProduct: idProduct,
        }),
        headers: {
            'content-type': 'application/json',
        },
    }
    fetch(`${url}`, options)

    document.location.reload(true)
}

export { getProducts, getProductByIdProduct, getProductByIdCategory, deleteProduct }
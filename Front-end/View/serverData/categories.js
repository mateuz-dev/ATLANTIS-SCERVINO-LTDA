'use strict'

const url = 'http://25.91.74.61/ATLANTIS-SCERVINO-LTDA/Back-end/Category/'

const getCategories = async() => {
    const response = await fetch(url)
    const result = await response.json()
    if (result['status'] === 'Sucess') {
        return result['data']
    }
}

export { getCategories }
'use strict'

const url = 'http://localhost/ATLANTIS-SCERVINO-LTDA/Back-end/Color/'

const getColors = async() => {
    const response = await fetch(url)
    const result = await response.json()
    if (result['status'] === 'Sucess') {
        return result['data']
    }
}

export { getColors }
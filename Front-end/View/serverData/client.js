'use strict'

const url = 'http://25.91.74.61/ATLANTIS-SCERVINO-LTDA/Back-end/Client/'

const getClients = async() => {
    const response = await fetch(url)
    const result = await response.json()
    if (result['status'] === 'Sucess') {
        return result['data']
    }
}

const getClientByIdClient = async(idClient) => {
    const response = await fetch(url + '?idClient=' + idClient)
    const result = await response.json()
    if (result['status'] === 'Sucess') {
        return result['data']
    }
}

const deleteClient = async(idClient) => {
    const options = {
        method: 'DELETE',
        body: JSON.stringify({
            idClient: idClient,
        }),
        headers: {
            'content-type': 'application/json',
        },
    }
    fetch(`${url}`, options)
}

export { getClients, getClientByIdClient, deleteClient }
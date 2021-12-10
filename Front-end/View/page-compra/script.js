import { getProductByIdProduct } from '../request/products.js'

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

const product = await getProductByIdProduct(datasByGet['idProduct'])

const calculateDiscount = () => {
    return (product[0].price - ((product[0].discount / 100) * product[0].price))
}

const fillPageWithProductDatas = () => {

    document.getElementById('title-page').innerText = product[0].nameProduct
    document.getElementById('preco-produto-sem-desconto').innerText = product[0].price.toString().replace(".", ",")
    document.getElementById('preco-produto').innerText = calculateDiscount().toString().replace(".", ",")

    document.getElementById('discount-value').innerText = product[0].discount

    document.getElementById('descricao-produto').innerText = product[0].description
    document.getElementById('color-product').style.color = product[0].hexa
    document.getElementById('color-name').innerText = product[0].nameColor
}

fillPageWithProductDatas()
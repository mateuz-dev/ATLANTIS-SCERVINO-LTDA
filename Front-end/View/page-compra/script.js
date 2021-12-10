import { getProductByIdProduct } from '../request/products.js'

const imagesProductDirectory = 'http://localhost/ATLANTIS-SCERVINO-LTDA/Back-end/Uploads/UploadProduct/'
var img1 = document.getElementById('image-1')
var img2 = document.getElementById('image-2')
var img3 = document.getElementById('image-3')
var img4 = document.getElementById('image-4')
var img5 = document.getElementById('image-5')
var img6 = document.getElementById('image-6')

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
    return product[0].price - (product[0].discount / 100) * product[0].price
}

const setImgSrc = ({ image }, key) => {
    const tagImage = document.getElementById(`image-${key + 1}`)
    tagImage.src = `${imagesProductDirectory}${image}`
}

const putProductImages = () => {
    product.map(setImgSrc)
}

const removeImageIfEmptyAndPutEventListener = (img) => {
    const tradeImage = () => {
        const imageOnMain = img1.src
        const imageSelected = img.src

        img1.src = imageSelected
        img.src = imageOnMain
    }

    if (img.src.endsWith('images/img-produto.png')) {
        img.style.display = 'none'
    } else {
        img.addEventListener('click', tradeImage)
    }
}

const fillPageWithProductDatas = () => {
    document.getElementById('title-page').innerText = product[0].nameProduct
    document.getElementById('preco-produto-sem-desconto').innerText = product[0].price.toString().replace('.', ',')
    document.getElementById('preco-produto').innerText = calculateDiscount().toString().replace('.', ',')

    document.getElementById('discount-value').innerText = product[0].discount

    document.getElementById('descricao-produto').innerText = product[0].description
    document.getElementById('color-product').style.color = product[0].hexa
    document.getElementById('color-name').innerText = product[0].nameColor

    putProductImages()

    const optionalImages = [img2, img3, img4, img5, img6]

    optionalImages.map(removeImageIfEmptyAndPutEventListener)
}

fillPageWithProductDatas()
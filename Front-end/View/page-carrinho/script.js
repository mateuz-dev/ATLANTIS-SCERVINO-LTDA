'use strict'

import { getProductByIdProduct } from '../request/products.js'

const fretePara = document.getElementById('frete2')
const inputFrete = document.getElementById('inputFrete')

const productsDirectory = 'http://localhost/ATLANTIS-SCERVINO-LTDA/Back-end/Uploads/UploadProduct/'

const minValueFrete = 1000000
const maxValueFrete = 99999999

var valorParcelado = 0
var valorVista = 0
var valorCadaParcela = 0

function encontrarCep() {
    if (inputFrete.value >= minValueFrete && inputFrete.value <= maxValueFrete) {
        fretePara.innerHTML = `
                    <div id="rowAdress">
                        <img src="./images/Ícone-Localização-PNG.png" alt=""> 
                        <h3>Rua Elton Silva, 905 - Centro, Jandira - SP</h3>
                    </div>
                    <div id="envioExpresso">
                        <p>ENVIO EXPRESSO <em>2 dias uteis</em></p>
                        <b>R$10,50</b>
                    </div>
                    <div id="envioComum">
                        <p>ENVIO COMUM <em>5 dias uteis</em></p>
                        <b>R$5,00</b>
                    </div> 
        `
    }
}

function geraStringAleatoria(tamanho) {
    var stringAleatoria = ''
    var caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'
    for (var i = 0; i < tamanho; i++) {
        stringAleatoria += caracteres.charAt(Math.floor(Math.random() * caracteres.length))
    }
    return stringAleatoria
}

const putLineInContainer = (stringHTML, idContainer) => {
    const container = document.querySelector(idContainer)
    const div = document.createElement('div')

    div.innerHTML = stringHTML
    container.appendChild(div)
}

const calculatePriceDiscount = (price, discount) => {
    return price - (discount / 100) * price
}

const calculateInstallments = (price, discount) => {
    var discountInstallments = discount * 0.7
    return price - (discountInstallments / 100) * price
}

const deleteProductFromCart = (idProduct) => {
    const index = cart.indexOf(idProduct)

    if (index > -1) {
        cart.splice(index, 1)

        localStorage.setItem('cart', JSON.stringify(cart))
    }
}

const listProducts = async(idProduct) => {
    const product = await getProductByIdProduct(idProduct)

    const contentLine = `
        <div class="contentCart" id="contentCart ${product[0].idProduct}">
            <div id="product">
            <a href="../page-compra/index.html?idProduct=${idProduct}">
                <img src="${productsDirectory}${product[0].image}" alt="" />
            </a>
                <div id="textProduct" class="textProduct">
                    <div id="textNameProduct" class="textNameProduct">
                        <h2>${product[0].nameProduct}</h2>
                    </div>
                    <div id="rowColor">
                        <div id="circleColor" class="circleColor" style="background-color:${product[0].hexa}"></div>
                        <h2 style="color:${product[0].hexa}">${product[0].nameColor}</h2>
                    </div>
                    <p>Código do Produto: ${geraStringAleatoria(10)}</p>
                </div>
            </div>

                <div id="qtdPrice">
                        <div id="quantity">
                            <div id="slider">
                                <button id="menos">&#9001;</button>
                                <input
                                    type="number"
                                    id="quantityProducts"
                                    value="1"
                                    oninput="validity.valid||(value='1');"
                                    readonly
                                />
                                <button id="mais">&#9002;</button>
                            </div>
                            <img id="${product[0].idProduct}" class="deleteProduct" 
                            src="./images/img_216917.png" 
                            alt=""/>
                        </div>

                <div id="price">
                    <p>De <b>${calculatePriceDiscount(product[0].price, 0).toLocaleString('pt-BR', {
                        style: 'currency',
                        currency: 'BRL',
                    })}</b></p>
                    <p class="actualPrice">Por ${calculateInstallments(
                        product[0].price,
                        product[0].discount
                    ).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}
                     ou ${calculatePriceDiscount(product[0].price, product[0].discount).toLocaleString('pt-BR', {
                         style: 'currency',
                         currency: 'BRL',
                     })} á vista</p>
                </div>
            </div>
        </div>`

    const writeTotal = () => {
        const subtotal = document.getElementById('subtotal')
        if (cart.length === 1) {
            subtotal.innerText = `SUBTOTAL(1 ITEM)`
        } else {
            subtotal.innerText = `SUBTOTAL(${cart.length} ITENS)`
        }

        document.getElementById('precoApagar').innerHTML = `
            <h2>${valorParcelado.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}</h2>
            <p>OU</p>
            <h2>${valorVista.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}</h2>
            <p>á vista</p>`

        document.getElementById('textParcelado').innerText = `(Em até 12x de ${valorCadaParcela.toLocaleString(
            'pt-BR',
            { style: 'currency', currency: 'BRL' }
        )} sem juros e 5% de desconto no Cartão Scervino)`
    }

    valorParcelado += calculateInstallments(product[0].price, product[0].discount)
    valorCadaParcela = valorParcelado / 12
    valorVista += calculatePriceDiscount(product[0].price, product[0].discount)

    writeTotal()

    putLineInContainer(contentLine, '#contentGlobal')

    var mais = document.getElementById('mais')
    var menos = document.getElementById('menos')

    mais.value = product[0].qtdInventory

    mais.addEventListener('click', aumentarProdutos)
    menos.addEventListener('click', diminuirProdutos)

    const sendProductToDeletionCart = () => {
        const message = 'Tem certeza de que deseja remover este produto do carrinho?'

        if (confirm(message)) {
            deleteProductFromCart(idProduct)
            location.reload()
            return true
        }
        return false
    }

    document.getElementById(`${product[0].idProduct}`).addEventListener('click', sendProductToDeletionCart)
}

var cart = []

if (JSON.parse(localStorage.getItem('cart')) !== null) {
    cart = JSON.parse(localStorage.getItem('cart'))
} else {
    localStorage.setItem('cart', JSON.stringify(cart))
}

const main = document.getElementById('main')
const footer = document.getElementById('footer')

if (cart.length > 0) {
    cart.map(listProducts)
} else {
    main.innerHTML = `
    <div id="noContentInCart">
    <h1 class="title-page">NENHUM PRODUTO FOI ADICIONADO AO CARRINHO</h1>
    <img id="mainimg" src="./images/cart.png">
    </div>
    `
    footer.innerHTML = ``
}

if (cart.length > 0) {
    document.getElementById('inputFrete').addEventListener('keypress', encontrarCep)
}

function aumentarProdutos() {
    const qtdProducts = document.getElementById('quantityProducts')
    const mais = document.getElementById('mais')

    if (parseInt(qtdProducts.value) < parseInt(mais.value)) {
        qtdProducts.value++
    }
}

function diminuirProdutos() {
    const qtdProducts = document.getElementById('quantityProducts')
    if (qtdProducts.value > 1) {
        qtdProducts.value = parseInt(qtdProducts.value) - 1
    }
}
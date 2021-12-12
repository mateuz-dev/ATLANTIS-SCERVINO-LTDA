'use strict'

import { getProductByIdProduct } from "../request/products.js"

const url = 'http://localhost/ATLANTIS-SCERVINO-LTDA/Back-end/Products/'


var qtdProducts = document.getElementById("quantityProducts")
const fretePara = document.getElementById("frete2")
const inputFrete = document.getElementById("inputFrete")

const productsDirectory = 'http://localhost/ATLANTIS-SCERVINO-LTDA/Back-end/Uploads/UploadProduct/'

const minValueFrete = 1000000
const maxValueFrete = 99999999

const datasByGet = {}
const product = await getProductByIdProduct(datasByGet['idProduct'])

function aumentarProdutos(qtdMaxProducts) {
    if(qtdProducts.value < qtdMaxProducts){
    qtdProducts.value = parseInt(qtdProducts.value) + 1
    }
}

function diminuirProdutos() {
    if(qtdProducts.value > 1){
        qtdProducts.value = parseInt(qtdProducts.value) - 1
    }
}


function encontrarCep(){
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
    var stringAleatoria = '';
    var caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    for (var i = 0; i < tamanho; i++) {
        stringAleatoria += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
    }
    return stringAleatoria;
}


const putLineInContainer = (stringHTML, idContainer) => {
    const container = document.querySelector(idContainer)
    const div = document.createElement('div')

    div.innerHTML = stringHTML
    container.appendChild(div)
}


const calculatePriceDiscount = (price, discount) => {
    return price - (discount/100) * price
}

const calculateInstallments = (price, discount) => {
    var discountInstallments = discount*0.7
    return price - (discountInstallments/100) * price
}

const writeProductsInCart = ({idProduct, nameProduct, nameColor, hexa, discount, price, qtdInventory, image}) => {
    
    
    const contentLine = `
        <div class="contentCart" id="contentCart ${idProduct}">
            <div id="product">
                <img src="${productsDirectory}${image}" alt="" />

                <div id="textProduct" class="textProduct">
                    <div id="textNameProduct" class="textNameProduct">
                        <h2>${nameProduct}</h2>
                    </div>
                    <div id="rowColor">
                        <div id="circleColor" class="circleColor" style="background-color:${hexa}"></div>
                        <h2 style="color:${hexa}">${nameColor}</h2>
                    </div>
                    <p>Código do Produto: ${geraStringAleatoria(10)}</p>
                </div>
            </div>

                <div id="qtdPrice">
                        <div id="quantity">
                            <div id="slider">
                                <button id="menos" onclick="diminuirProdutos()">&#9001;</button>
                                <input
                                    type="number"
                                    id="quantityProducts"
                                    value="1"
                                    name="quantityProducts"
                                    readonly
                                />
                                <button id="mais" onclick="aumentarProdutos(${qtdInventory})">&#9002;</button>
                            </div>
                            <img id="${idProduct}" class="deleteProduct" src="./images/img_216917.png" alt="" onclick="deleteProduct(${idProduct})"/>
                        </div>

                <div id="price">
                    <p>De <b>R$${price}</b></p>
                    <p class="actualPrice">Por R$${calculateInstallments(price, discount)}
                     ou R$${calculatePriceDiscount(price, discount)} á vista</p>
                </div>
            </div>
        </div>`

       


        putLineInContainer(contentLine, '#contentGlobal')
}


var productsInCart = localStorage.getItem('idProduct');


const products = await getProductByIdProduct(1)

if (products.length > 0) {
    products.map(writeProductsInCart)
}


document.getElementById("inputFrete") 
.addEventListener("keypress", encontrarCep)
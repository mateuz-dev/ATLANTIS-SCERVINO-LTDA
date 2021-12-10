'use strict'


var qtdProducts = document.getElementById("quantityProducts")
const fretePara = document.getElementById("frete2")
const inputFrete = document.getElementById("inputFrete")
const qtdMaxProducts = 10




const minValueFrete = 1000000
const maxValueFrete = 99999999

function aumentarProdutos() {
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





document.getElementById("mais")
.addEventListener("click", aumentarProdutos)

document.getElementById("menos")
.addEventListener("click", diminuirProdutos)

document.getElementById("inputFrete") 
.addEventListener("keypress", encontrarCep)


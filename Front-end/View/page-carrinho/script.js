'use strict'


const inputProdutos = document.getElementById("quantityProducts")

var quantidadeProdutos = inputProdutos.value 

function aumentarProdutos() {
    quantidadeProdutos = quantidadeProdutos + 1
}


function diminuirProdutos() {
    if(quantidadeProdutos > 1){
    quantidadeProdutos = quantidadeProdutos - 1
    }
}



document.getElementById("mais")
.addEventListener("click", aumentarProdutos)

document.getElementById("menos")
.addEventListener("click", diminuirProdutos)
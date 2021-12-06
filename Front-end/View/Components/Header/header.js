'use strict'

import { getCategories } from '../../request/categories.js'
const iconsDirectory = 'http://25.91.74.61/ATLANTIS-SCERVINO-LTDA/Back-end/Uploads/UploadCategory/icon/'

document.querySelector('#header').innerHTML = `<input type="checkbox" id="check">
    <label for="check" class="mobile-menu">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
    </label>

    <a href="">
        <div id="div-title">
            <img src="../Components/Header/images/logo.png">
            <h1>SCERVINO</h1>
        </div>
    </a>

        <form id="form-mobile" action="">
            <img src="../Components/Header/images/search-icon.png">
            <input type="text" name="" id="" placeholder="Buscar">
        </form>
   

    <nav id="nav-list">
        <ul id="ul-menu-options">


            <li> <a href="">Nossa História</a> </li>

            <li id="li-catalog"> Catálogo <img src="../Components/Header/images/arrow-icon.svg" id="arrow">


                <ul id="ul">
                    <ul id="ul-triangle"><img src="../Components/Header/images/triangle-icon.png"></ul>

                    <ul id="ul-categories">
                    </ul>
                </ul>

            </li>

            <form action="">
                <img src="../Components/Header/images/search-icon.png">
                <input type="text" name="" id="" placeholder="Buscar">
            </form>
        </ul>

        <ul id="ul-user-options">
            <a href=""> <img src="../Components/Header/images/cart-icon.png" alt="Carrinho"> </a>
            <a href=""> <img src="../Components/Header/images/user-icon.png" alt="Login/Cadastrar"> </a>
        </ul>
    </nav>

    <nav id="nav-mobile">
            <ul id="menu-options-mobile">
                <li><a href="">Nossa História</a></li>
                
                <li id="li-catalog-mobile"><a href="">Catálogo</a> <img src="../Components/Header/images/arrow-icon.svg" id="arrow-mobile">
                    <ul id="ul-mobile">
                        <ul id="ul-triangle-mobile"><img src="../Components/Header/images/triangle-icon.png"></ul>

                        <ul id="ul-categories-mobile">
                        </ul>
                    </ul>
                </li>
             
                <li><a href="">Carrinho</a></li>
                <li><a href="">Login</a></li>
            </ul>
    </nav>`

const putLineInContainer = (stringHTML, idContainer) => {
    const container = document.querySelector(idContainer)
    const li = document.createElement('li')

    li.innerHTML = stringHTML
    container.appendChild(li)
}

const writeCategoriesInHeader = ({ idCategory, icon, name }) => {
    const contentLine = `
    <li>
        <a href="../page-vitrine/index.html?idCategory=${idCategory}">
        <img src="${iconsDirectory}${icon}"> ${name}
        </a>
    </li>`

    putLineInContainer(contentLine, '#ul-categories')
    putLineInContainer(contentLine, '#ul-categories-mobile')
}

const categories = await getCategories()

if (categories.length > 0) {
    categories.map(writeCategoriesInHeader)
} else {
    const errorMessage = '<p>Não encontramos as categorias</p>'
    putLineInContainer(errorMessage, '#ul-categories')
}
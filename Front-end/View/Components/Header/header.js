'use strict'

function searchBar() {
    form_mobile.classList.add('aumentar-tamanho-barra-pesquisa')
    form_mobile.classList.remove('form-mobile')

    mobile_menu.style.display = 'none'
}

import { getCategories } from '../../request/categories.js'
const iconsDirectory = 'http://localhost/ATLANTIS-SCERVINO-LTDA/Back-end/Uploads/UploadCategory/icon/'

document.querySelector('#header').innerHTML = 
`
        <input type="checkbox" id="check">
        <label for="check" class="mobile-menu">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </label>
    
        <a href="../page-landingPage/index.html">
            <div id="div-title-header">
                <img  src="../Components/Header/images/logo.png">
                <h1>SCERVINO</h1>
            </div>
        </a>
    
            <form class="form-mobile" action="" onclick="searchBar()">
                <img src="../Components/Header/images/search-icon.png">
                <input type="text" name="" id="" placeholder="Buscar">
            </form>
       
    
        <nav id="nav-list">

            <ul id="ul-menu-options">
                <li> <a href="../page-our-history/">Nossa História</a> </li>
    
                <li id="li-catalog"> Catálogo <img src="../Components/Header/images/arrow-icon.svg" class="arrow">
                    <ul id="ul">
                        <li class="li-triangle"><img src="../Components/Header/images/triangle-icon.png"></li>
                        <ul id="ul-categories"></ul>
                    </ul>
                </li>
    
                <form action="">
                    <img src="../Components/Header/images/search-icon.png">
                    <input type="text" name="" id="" placeholder="Buscar">
                </form>
            </ul>
    


            <ul id="ul-user-options">
                <li> <a href="../page-carrinho/"><img src="../Components/Header/images/cart-icon.png" alt="Carrinho"></a> </li>

                <li id="li-user-options">
                    <img src="../Components/Header/images/user-icon.png" alt="Login/Cadastrar">
                    <img src="../Components/Header/images/arrow-icon.svg" class="arrow">
                    <ul id="ul-user-options-ul">
                        <li id="li-triangle-user"><img src="../Components/Header/images/triangle-icon.png"></li>
                        <ul id="ul-user-options-list">
                            <li><img src="../Components/Header/images/edit-icon.svg"><a href="../page-cadastro/">Perfil</a></li>
                            <li><img src="../Components/Header/images/management-icon.svg"><a href="../page-management/">Gerenciamento</a></li>
                            <li><img src="../Components/Header/images/login-icon.svg"><a href="../page-login/">Login</a></li>
                            <li><img src="../Components/Header/images/logout-icon.svg"><a href="">Sair</a></li>
                        </ul>
                    </ul>
                </li>
            </ul>

        </nav>
    




        <nav id="nav-mobile">

            <ul id="menu-options-mobile">
                <li><a href="../page-our-history/">Nossa História</a></li>
                    
                <li id="li-catalog-mobile">Catálogo
                    <ul id="ul-mobile">
                        <div id="div-ul-mobile-top">
                            <button id="button-close-ul-mobile"><img src="../Components/Header/images/back-page-icon.svg"></button>
                            Categorias
                        </div>
                        <ul id="ul-categories-mobile"></ul>
                    </ul>
                </li>
                 
                <li><a href="../page-carrinho/">Carrinho</a></li>
                <li><a href="../page-login/">Login</a></li>

            </ul>
            
        </nav>
`

const putLineInContainer = (stringHTML, idContainer) => {
    const container = document.querySelector(idContainer)
    const li = document.createElement('li')

    li.innerHTML = stringHTML
    container.appendChild(li)
}

const writeCategoriesInHeader = ({ idCategory, icon, name }) => {
    const contentLine = `
        <a href="../page-vitrine/index.html?idCategory=${idCategory}">
        <img src="${iconsDirectory}${icon}"> ${name}
        </a>`

    putLineInContainer(contentLine, '#ul-categories')
    putLineInContainer(contentLine, '#ul-categories-mobile')
}

const categories = await getCategories()

if (categories.length > 0) {
    categories.map(writeCategoriesInHeader)
} else {
    const message = '<p>Não encontramos nenhuma categoria.</p>'
    putLineInContainer(message, '#ul-categories')
}

const form_mobile = document.querySelector('.form-mobile')
const mobile_menu = document.querySelector('.mobile-menu')
const a_header = document.querySelector('#a-header')

form_mobile.addEventListener('click', searchBar)
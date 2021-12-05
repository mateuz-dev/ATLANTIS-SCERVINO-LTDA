'use strict'

import { getCategories } from '../../serverData/categories.js'

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
                            <li>
                                <a href="">
                                    <img src="../Components/Header/images/category-icon.png"> Nome da Categoria
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <img src="../Components/Header/images/category-icon.png"> Nome da Categoria
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <img src="../Components/Header/images/category-icon.png"> Nome da Categoria
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <img src="../Components/Header/images/category-icon.png"> Nome da Categoria
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <img src="../Components/Header/images/category-icon.png"> Nome da Categoria
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <img src="../Components/Header/images/category-icon.png"> Nome da Categoria
                                </a>
                            </li>
                            
                        </ul>
                    </ul>
                </li>
             
                <li><a href="">Carrinho</a></li>
                <li><a href="">Login</a></li>
            </ul>
    </nav>`

const writeCategoriesInHeader = (category) => {
    const containerDesktop = document.querySelector('#ul-categories')
    const eachCategoryLi = document.createElement('li')

    eachCategoryLi.innerHTML = `
        <li>
            <a href="">
                <img src="../Components/Header/images/category-icon.png"> ${category.name}
            </a>
        </li>`

    containerDesktop.appendChild(eachCategoryLi)

    const containerMobile = document.querySelector('#ul-categories-mobile')
    const eachCategoryLiMobile = document.createElement('li')

    eachCategoryLi.innerHTML = `
        <li>
            <a href="">
                <img src="../Components/Header/images/category-icon.png"> ${category.name}
            </a>
        </li>`

    containerMobile.appendChild(eachCategoryLiMobile)
}

const categories = await getCategories()
categories.map(writeCategoriesInHeader)
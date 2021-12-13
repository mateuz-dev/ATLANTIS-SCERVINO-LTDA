"use-strict"

const moveSliderRight = () =>{
    divCategories.style.marginRight = "20vw"
    divCategories.style.marginLeft = "-20vw"
    divCategories.style.transition = "1s ease-in-out"
}

const moveSliderLeft = () =>{
    divCategories.style.marginLeft = "20vw"
    divCategories.style.marginRight = "-20vw"
    divCategories.style.transition = "1s ease-in-out"
}

const divCategories = document.querySelector("#div-categories")
const sliderRightButton = document.querySelector("#button-landing-page-categories-right")
sliderRightButton.addEventListener('click', moveSliderRight)
const sliderLefttButton = document.querySelector("#button-landing-page-categories-left")
sliderLefttButton.addEventListener('click', moveSliderLeft)
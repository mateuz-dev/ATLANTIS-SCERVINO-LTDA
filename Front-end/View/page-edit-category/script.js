'use strict'

import { imagePreview } from '../image-preview.js'

const saveDatasSendByGet = (parte) => {
    const keyValue = parte.split('=');
    const key = keyValue[0];
    var value = keyValue[1];
    datasByGet[key] = value;
}

//Coletando dados via GET e definindo categoria a ser editada
var query = location.search.slice(1);
var parts = query.split('&');
var datasByGet = {};
parts.forEach(saveDatasSendByGet);

const putIdCategoryInInput = () => {
    document.getElementById('idCategory-field').value = parseInt(datasByGet['idCategory'])
}

putIdCategoryInInput()
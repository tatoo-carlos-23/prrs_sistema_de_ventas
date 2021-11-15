function validamos(id, validacion_x, id_btn_formulario) {
    //console.log(validacion_x[2])

    let mostrar_error = document.getElementById('error_formulario')
    let input_obtenido = document.getElementById(id)
    let btn_formulario_actual = document.getElementById(id_btn_formulario)
    let valor_booleano = false
    //console.log(input_obtenido.value)
    REGEX_NUMEROS = /^([0-9])*$/
    REGEX_LETRAS = /^([A-Za-z ])*$/
    REGEX_NUMEROS_LETRAS = /^([A-Za-z0-9])*$/
    REGEX_PRECIO = /^([1-9])+([0-9])+([.][0-9][0-9])?$/ //precio

    if (validacion_x['n'] == 'n') { // SOLO SE PERMITEN NUMEROS
        if (!REGEX_NUMEROS.test(input_obtenido.value)) {
            mostrar_error.value = 'Solo se permiten numeros';
            valor_booleano = true
        } else {
            mostrar_error.value = 'OK'
            valor_booleano = false
        }
    } else if (validacion_x['l'] == 'l') { // SOLO SE PERMITEN LETRAS

        if (!REGEX_LETRAS.test(input_obtenido.value)) {
            mostrar_error.value = 'Solo se permiten letras';
            valor_booleano = true
        } else {
            mostrar_error.value = 'OK'
            valor_booleano = false
        }
    } else if (validacion_x['c'] == 'n') {// VALIDAR POR CANTIDAD DE CARACTERES

        if (!REGEX_NUMEROS.test(input_obtenido.value)) { //solo valida numeros
            mostrar_error.value = 'Solo se permiten numeros';
            valor_booleano = true
        } else {
            if ((input_obtenido.value).length == parseInt(validacion_x['nc'])) {
                mostrar_error.value = 'OK'
                valor_booleano = false
            } else {
                mostrar_error.value = `Perimitidos ${input_obtenido.value.length}/${parseInt(validacion_x['nc'])} caracteres.`;
                valor_booleano = true
            }
        }
    } else if (validacion_x['p'] == 'p') { // SOLO SE PRECIOS MINOMO 10.00 CON DECIMALES

        if (!REGEX_PRECIO.test(input_obtenido.value)) {
            mostrar_error.value = 'Precio invalido, ejemplo: 10.00';
            valor_booleano = true
        } else {
            mostrar_error.value = 'OK'
            valor_booleano = false
        }
    }

    if (valor_booleano == false) {
        mostrar_error.style = 'color: #52c41a'
        input_obtenido.style = ' border-right: 8px solid #52c41a;'
        btn_formulario_actual.disabled = false
        setTimeout(() => {
            mostrar_error.style = 'color: #52c41a; display:none;'
        }, 800)

    } else if (valor_booleano == true) {
        mostrar_error.style = 'color: #f5222d; display:block;'
        input_obtenido.style = ' border-right: 8px solid  #f5222d;'
        btn_formulario_actual.disabled = true
    }

}


$(document).ready(function () {

    // LIMPIAR CAJA DATOS BUSQUEDA CLIENTES
    $('#limpiar_cliente').click(function () {
        $('#buscador_cliente').val('');
        limpiar_buscador_cliente()
    });

    // LIMPIAR CAJA DATOS BUSQUEDA PRODUCTOS
    $('#limpiar_producto').click(function () {
        $('#buscador_producto').val('');
        limpiar_buscador_producto()
    });

    function limpiar_buscador_producto() {
        $('#id_producto').val('');
        $('#nombre_producto').val('');
        $('#stock_restante').val('');
        $('#precio').val('');
        $('#descripcion').val('');
        $('#cantidad').val('');
        $('#img_producto_busqueda').css("display", "none");
    }

    function limpiar_buscador_cliente() {
        $('#nombre_cliente').val('');
        $('#id_cliente').val('');
    }

    // BUSCAMOS EL CLIENTE
    $('#buscador_cliente').keyup(function (e) {
        let data_buscar = $(this).val();// THIS.VAL ES LO QUE ESCRIBO
        let accion = 'buscar_cliente';
        $.ajax({
            url: '../procesos/ventas/venta_de_productos.php',
            type: "POST",
            async: true,
            data: {
                accion: accion,
                data_buscar: data_buscar
            },
            success: function (response) {
                let clientes_encontrados = JSON.parse(response)
                console.log(clientes_encontrados)
                if (clientes_encontrados.length == 0) {
                    $('#nombre_cliente').val('NO SE ENCONTRO ESTE CLIENTE');
                    $('#id_cliente').val('');
                    setTimeout(() => {
                        limpiar_buscador_cliente()
                    }, 1500)
                } else if (clientes_encontrados.length > 0) {
                    $('#nombre_cliente').val(clientes_encontrados[0]['nombres']);
                    $('#id_cliente').val(clientes_encontrados[0]['id_cliente']);
                }
            },
            error: function (error) {
            }
        });
    })


    // BUSCAMOS EL PRODUCTOS
    $('#buscador_producto').keyup(function (e) {
        let data_buscar = $(this).val();// THIS.VAL ES LO QUE ESCRIBO
        let accion = 'buscar_producto';
        $.ajax({
            url: '../procesos/ventas/venta_de_productos.php',
            type: "POST",
            async: true,
            data: {
                accion: accion,
                data_buscar: data_buscar
            },
            success: function (response) {
                let productos_encontrados = JSON.parse(response)
                //console.log(productos_encontrados)
                if (productos_encontrados.length == 0) {
                    $('#nombre_producto').val('NO SE ENCONTRO ESTE PRODUCTO');
                    $('#id_producto').val('');
                    setTimeout(() => {
                        limpiar_buscador_producto()
                    }, 1500)
                } else if (productos_encontrados.length > 0) {
                    $('#id_producto').val(productos_encontrados[0]['id_producto']);
                    $('#nombre_producto').val(productos_encontrados[0]['nombre']);
                    $('#stock_restante').val(productos_encontrados[0]['stock_final']);
                    $('#precio').val(productos_encontrados[0]['precio']);
                    $('#descripcion').val(productos_encontrados[0]['descripcion']);
                    $('#cantidad').val('');
                    $('#img_producto_busqueda').css("display", "block");
                    let url = (productos_encontrados[0]['ruta']);
                    $("#img_resultado").prop("src", url.slice(3));
                }
            },
            error: function (error) {
            }
        });
    })


    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    // CREAMOS VARIABLE PARA ALMACENAR LOS DATOS TEMPORALES DE LA TABLA DE DETALLE DE VENTA
    let DETALLE_VENTA_PRODUCTOS = []

    //  AGREGAMOS PRODUCTOS ALA TABLA XD
    $('#btn_agregar_nuevo_producto').click(function (e) {
        //e.preventDefault();

        let stock_restante = parseInt($('#stock_restante').val());
        let id_producto = parseInt($('#id_producto').val());

        // VERIFICAMOS QUE EXISTA UN PRODUCTO ENCONTRADO Y QUE SU STOCK SE MAYOR A 0
        if (stock_restante > 0 && id_producto > 0) {
            let cantidad = parseInt($('#cantidad').val());

            // COMPROBAMOS QUE EL STOCK RESTANTE SEA MAYOR ALA CANTIDAD INGRESADA
            if (stock_restante > cantidad) {
                let nombre_producto = $('#nombre_producto').val();
                let precio = $('#precio').val();
                let sub_total = (cantidad * precio).toFixed(2);
                let igv = (sub_total * 0.18).toFixed(2);
                let total = (parseInt(sub_total) + parseInt(igv)).toFixed(2);

                // COMPROBAMOS SI ESTE PRODUCTO YA FUE INGRESADO AL DETALLE DE VENTA
                // SI YA EXISTE NO PERMITIRA REGISTRARLO EN LA TABLA
                let comprobamos = DETALLE_VENTA_PRODUCTOS.filter(d => d.id_producto == id_producto)
                //console.log(comprobamos.length)
                if (comprobamos.length == 0) {

                    $('#tbl_detalle_venta_productos').append('<tr style="cursor: pointer;" class="eliminar-item-v" data-id_producto="' + id_producto + '">' +
                        '<td>' + nombre_producto + '</td>' +
                        '<td>' + cantidad + '</td>' +
                        '<td>' + precio + '</td>' +
                        '<td>' + igv + '</td>' +
                        '<td>' + sub_total + '</td>' +
                        '<td>' + total + '</td>' +
                        //'<td> <i style="' + 'color:#f5222d;' + '" class="' + 'fas fa-trash-alt' + '"></i></td>' +
                        '</tr>'
                    );

                    let datos = {
                        id_producto: id_producto,
                        producto: nombre_producto,
                        cantidad: cantidad,
                        precio: precio,
                        igv: igv,
                        sub_total: sub_total,
                        total: total
                    }
                    // INSERTAMOS NUEVOS DATOS AL ARRAY
                    DETALLE_VENTA_PRODUCTOS.push(datos)
                    console.log(DETALLE_VENTA_PRODUCTOS)

                    //LAMAMOS ESTA FUNCION PARA CALCULAR EL MONTO TOTAL
                    calcular_monto_total()

                    // LLAMAMOS ESTA FUNCION PARA RESTAR EL STOCK EN LA BASE DE DATOS
                    actualizar_stock(id_producto, cantidad, 'MENOS');

                    // LIMPIAMOS TODOS LOS INPUT Y EL BUSCADOR
                    $('#buscador_producto').val('');
                    limpiar_buscador_producto()

                } else if (comprobamos.length >= 1) {
                    Swal.fire('YA EXISTE', 'Este producto ya fue ingresado', 'warning')
                }
            } else {
                Swal.fire('', 'Ingrese una cantidad menor al stock final', 'warning')
            }
        } else {
            Swal.fire('', 'Seleccione un producto porfavor', 'warning')
        }
    });

    async function calcular_monto_total() {
        // RECORREMOS EL OBJETO PARA ACTUALIZAR EL MONTO TOTAL DE LA VENTA
        $('#total_detalle_productos').val('0');
        $('#sub_total_detalle_productos').val('0');
        $('#igv_detalle_productos').val('0');
        await Promise.all(DETALLE_VENTA_PRODUCTOS.map((d) => {
            console.log(d)
            let total_inicial = $('#total_detalle_productos').val()
            let igv_inicial = $('#igv_detalle_productos').val();
            let sub_total_inicial = $('#sub_total_detalle_productos').val();
            let sumando_total = (parseInt(d['total']) + parseInt(total_inicial));
            let sumando_igv = (parseInt(d['igv']) + parseInt(igv_inicial));
            let sumando_sub_total = (parseInt(d['sub_total']) + parseInt(sub_total_inicial));
            $('#total_detalle_productos').val(sumando_total.toFixed(2));
            $('#igv_detalle_productos').val(sumando_igv.toFixed(2));
            $('#sub_total_detalle_productos').val(sumando_sub_total.toFixed(2));
        }))
    }

    async function actualizar_stock(id_producto, cantidad, valor) {
        // valor =  MAS, ES PARA DEVOLVER EL STOCK
        // valor = MENOS, ES PARA RESTAR EL STOCK
        $.ajax({
            url: '../procesos/ventas/venta_de_productos.php',
            type: "POST",
            async: true,
            data: {
                accion: 'actualizar_stock',
                id_producto: id_producto,
                cantidad: cantidad,
                valor: valor
            },
            success: function (response) {
                let resultado = JSON.parse(response)
                console.log(resultado)
            },
            error: function (error) {
            }
        });
    }

    // ELIMINAMOS PRODUCTO DE LA TABLA DETALLE VENTA
    $('#tbl_detalle_venta_productos').on('click', 'tr td', function (evt) {
        console.log(evt)
        let target, id, valorSeleccionado;
        target = $(event.target);
        console.log(target)
        id = target.parent().data('id_producto');
        valorSeleccionado = target.text();
        console.log("NOMBRE DEL PRODUCTO: " + valorSeleccionado + "\n ID_PRODUCTO: " + target.parent().data('id_producto'));
        Swal.fire({
            title: 'Esta seguro de eliminar este producto?',
            showCancelButton: true,
            confirmButtonText: `SI`,
        }).then((result) => {
            if (result.isConfirmed) {

                eliminar_producto_objeto_detalle_venta(id);

                Swal.fire('', 'Eliminado', 'success')
                $(this).closest('tr').remove();
            } else {
                //Swal.fire('', 'No se pudo eliminar', 'warning')
            }
        })
    })

    // ELIMINAMOS EL PRODUCTO DEL OBJETO DETALLE_VENTA_PRODUCTOS
    function eliminar_producto_objeto_detalle_venta(id) {
        console.log("id_recibido del producto", id)
        // let detalle_filtro = DETALLE_VENTA_PRODUCTOS.filter(e => e['id_producto'] == id)
        // //console.log("producto a eliminar",detalle_filtro)
        // detalle_filtro.forEach(e => {
        //     let index = DETALLE_VENTA_PRODUCTOS.indexOf(e)
        //     console.log('index', index)
        //     actualizar_stock(e['id_producto'], e['cantidad'], 'MAS');
        //     DETALLE_VENTA_PRODUCTOS.splice(index, 1)
        // })

        DETALLE_VENTA_PRODUCTOS.forEach((e, index) => {
            if (e['id_producto'] == id) {
                console.log(e)
                actualizar_stock(e['id_producto'], e['cantidad'], 'MAS');
                DETALLE_VENTA_PRODUCTOS.splice(index, 1)
            }
        })

        setTimeout(e => {
            calcular_monto_total()
            console.log(DETALLE_VENTA_PRODUCTOS)
        }, 200)
    }

    // ANULAMOS LA VENTA
    $('#id_anular_venta').click(function () {
        if (DETALLE_VENTA_PRODUCTOS.length >= 1) {
            Swal.fire({
                title: 'Esta seguro de anular esta venta en proceso?',
                showCancelButton: true,
                confirmButtonText: `SI`,
            }).then((result) => {
                if (result.isConfirmed) {
                    // DEVOLVEMOS EL STOCK ALA BASE DE DATOS
                    DETALLE_VENTA_PRODUCTOS.forEach(async (d) => {
                        console.log(d)
                        await actualizar_stock(d['id_producto'], d['cantidad'], 'MAS')
                    })
                    $('#buscador_producto').val('');
                    limpiar_buscador_producto()
                    $('#buscador_cliente').val('');
                    limpiar_buscador_cliente()
                    $('#total_detalle_productos').val('')
                    $('#sub_total_detalle_productos').val('');
                    $('#igv_detalle_productos').val('');

                    // ELIMINAMOS LOS ITEMS DE LA TABLA HTML
                    let numero_de_filas = 0;
                    let tabla = document.getElementById('tbl_detalle_venta_productos');
                    let filas_contar = tabla.rows.length;
                    for (let i = numero_de_filas; i < filas_contar; i++) {
                        tabla.deleteRow(numero_de_filas);
                    }
                    // DEJAMOS VACIA LA VARIABLE
                    DETALLE_VENTA_PRODUCTOS = []
                    Swal.fire('', 'Venta anulada correctamente', 'success')
                } else {
                    //Swal.fire('', 'No se pudo eliminar', 'warning')
                }
            })
        } else {
            //Swal.fire('', 'Ningunproducto agregafo', 'warning')
        }


    });

    // REGISTRAMOS LA VENTA EN LA BD
    $('#btn_registrar_nueva_venta').click(function () {

        let id_cliente = $('#id_cliente').val();
        let igv = $('#igv_detalle_productos').val();
        let sub_total = $('#sub_total_detalle_productos').val();
        let total = $('#total_detalle_productos').val()

        if (DETALLE_VENTA_PRODUCTOS.length > 0 && parseInt(id_cliente) > 0) {
            insertar_venta(id_cliente, igv, sub_total, total)
        } else if (DETALLE_VENTA_PRODUCTOS.length == 0) {
            Swal.fire('', 'Ingrese un producto minimo.', 'warning')
        } else if (id_cliente == '') {
            Swal.fire('', 'Seleccione un cliente por favor.', 'warning')
        }

    });

    async function insertar_venta(id_cliente, igv, sub_total, total) {

        $.ajax({
            url: '../procesos/ventas/venta_de_productos.php',
            type: "POST",
            async: true,
            data: {
                accion: 'insertar_venta',
                id_cliente: id_cliente,
                igv: igv,
                sub_total: sub_total,
                total: total
            },
            success: function (response) {
                let resultado = JSON.parse(response)
                if (parseInt(resultado) > 0) {
                    DETALLE_VENTA_PRODUCTOS.forEach(e => {
                        insertar_detalle_venta(resultado, e)
                    })
                    document.getElementById('abrir_modal_venta_final').click()

                    $('#buscador_producto').val('');
                    limpiar_buscador_producto()
                    $('#buscador_cliente').val('');
                    limpiar_buscador_cliente()
                    $('#total_detalle_productos').val('')
                    $('#sub_total_detalle_productos').val('');
                    $('#igv_detalle_productos').val('');

                    // ELIMINAMOS LOS ITEMS DE LA TABLA HTML
                    let numero_de_filas = 0;
                    let tabla = document.getElementById('tbl_detalle_venta_productos');
                    let filas_contar = tabla.rows.length;
                    for (let i = numero_de_filas; i < filas_contar; i++) {
                        tabla.deleteRow(numero_de_filas);
                    }
                    // DEJAMOS VACIA LA VARIABLE
                    DETALLE_VENTA_PRODUCTOS = []
                    Swal.fire('', 'Venta registrada correctamente', 'success')
                } else {
                    console.log('ocurrio un error al insertar la venta')
                }
            },
            error: function (error) {
            }
        });
    }


    async function insertar_detalle_venta(id_venta, data) {
        // valor =  MAS, ES PARA DEVOLVER EL STOCK
        // valor = MENOS, ES PARA RESTAR EL STOCK
        $.ajax({
            url: '../procesos/ventas/venta_de_productos.php',
            type: "POST",
            async: true,
            data: {
                accion: 'insertar_detalle_venta',
                id_venta: id_venta,
                id_producto: data['id_producto'],
                cantidad: data['cantidad'],
                precio: data['precio'],
                total: data['total']
            },
            success: function (response) {
                let resultado = JSON.parse(response)
                if (resultado == 'success') {
                    console.log(resultado)
                } else {
                    console.log(resultado)
                }

            },
            error: function (error) {
            }
        });
    }

})
// $(document).ready(function() {
//     $('#tablaRenglones').Tabledit({
//         deleteButton: true,
//         editButton: true,
//         columns: {
//             identifier: [0, 'id'],
//             editable: [
//                 [1, 'cuenta'],
//                 [2, 'leyenda'],
//                 [3, 'suc'],
//                 [4, 'secc'],
//                 [5, 'debe'],
//                 [6, 'haber']
//             ]
//         },
//         hideIdentifier: true,
//         url: 'altaRenglonesTabla'
//     });
// });
// Función que establece las columnas fijas


function stickyColumns() {
    // Número de elementos que se mantendran fijos
    var stickElements = $('.sticky-column');

    // Variable que permite identificar el numero de columnas a fijar
    var totalColumns = $('thead .sticky-column').length;

    // Formula para identificar la primer columnas
    // Si el total de columnas es 2 obtendremos (2n-1)
    var firstColumn = totalColumns + 'n' + '-' + (totalColumns - 1);

    // Formula para identificar la segunda columna
    // Si el total de columnas es 2 obtendremos (2n+2)
    var secondColum = totalColumns + 'n' + '+' + (totalColumns);

    // Obtenemos el ancho de la primer elemeto de la primera columna
    // este elemento no sirve para posicionar la primera columna totalmente a la izquierda
    var firstElement = $('tbody .sticky-column:first-child()').outerWidth();

    stickElements.each(function() {
        // Si el elemento a fijar tiene el valor del primer elemento de la primera columan
        // Posicionamos los elementos totalmente a la izquierda
        if ($(this).outerWidth() == firstElement) {
            $(this).css('left', '0px');
        } else {
            // Si no lo posicionamos a X(tamaño del primer elemento) pixeles a la izquierda
            $(this).css({
                'left': firstElement,
                'width': '220px'
            });
        }
    });

    // Mueve los elementos fijos al realizar el scroll de la tabla
    $('.fixed-table').scroll(function() {
        $('.sticky-column:nth-child(' + firstColumn + ')').css('left', $(this).scrollLeft());
        $('.sticky-column:nth-child(' + secondColum + ')').css('left', firstElement + $(this).scrollLeft());
    });
}
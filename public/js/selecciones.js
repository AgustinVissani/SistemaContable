const { last } = require("lodash");

function setProvincia() {
    $idP = document.getElementById('idP').value;
    $selectProvincia = document.getElementById('id_provincia');
    $selectProvincia.value = $idP;


    if ($('select[name="id_provincia"] option:selected').text() == "") {
        document.getElementById('noProvincia').hidden = false;
    } else {
        document.getElementById('noProvincia').hidden = true;
    }
}

function setCodigo() {
    $codigo = document.getElementById('codigo').value;
    $selectCodigo = document.getElementById('id_nivel');
    $selectCodigo.value = $codigo;


    if ($('select[name="id_nivel"] option:selected').text() == "") {
        document.getElementById('noCodigo').hidden = false;
    } else {
        document.getElementById('noCodigo').hidden = true;
    }
}

function setRol() {
    $idR = document.getElementById('idR').value;
    $selectRol = document.getElementById('id_rol');
    $selectRol.value = $idR;


    if ($('select[name="id_rol"] option:selected').text() == "") {
        document.getElementById('noRol').hidden = false;
    } else {
        document.getElementById('noRol').hidden = true;
    }


}

function setAgregarenNivelUno() {
    $idN = document.getElementById('id_nivel').value;
    if ($idN == "") {
        document.getElementById('imp').disabled = true;

    } else {
        document.getElementById('imp').disabled = false;
    }
}

function espacios($nivel) {
    $espacios = '';
    $count = 1;
    while (count !== $nivel) {
        $espacios = ' ';
        $count += 1;

    }
    return $espacios;
}

function setCuenta() {
    $codigo = document.getElementById('idC').value;
    $selectCodigo = document.getElementById('id_codigo');
    $selectCodigo.value = $codigo;


    if ($('select[name="id_codigo"] option:selected').text() == "") {
        // document.getElementById('noCodigo').hidden = false;
    } else {
        // document.getElementById('noCodigo').hidden = true;
    }
}

function setSucursal() {
    $codigo = document.getElementById('idS').value;
    $selectCodigo = document.getElementById('id_sucursal');
    $selectCodigo.value = $codigo;


    if ($('select[name="id_sucursal"] option:selected').text() == "") {
        // document.getElementById('noSucursal').hidden = false;
    } else {
        // document.getElementById('noSucursal').hidden = true;
    }
}


function setSeccion() {
    $codigo = document.getElementById('idSec').value;
    $selectCodigo = document.getElementById('id_seccion');
    $selectCodigo.value = $codigo;


    if ($('select[name="id_seccion"] option:selected').text() == "") {
        //  document.getElementById('noSeccion').hidden = false;
    } else {
        //   document.getElementById('noSeccion').hidden = true;
    }
}


function setRetomarAsiento() {
    $ret = document.onclick('retomar').value;
    if ($ret == true) {
        document.getElementById('imp').disabled = true;

    } else {
        document.getElementById('imp').disabled = false;
    }
}

// function setTipo_asiento() {
//     $fecha_asiento = document.getElementById('fecha_asiento').value;
//     $selectAsiento = document.getElementById('tipo_asiento').value;


//     $fecha_asiento = new Date(document.getElementById('fecha_asiento').value);

//     if ($fecha_asiento.getDate() + 1 == $fecha_asiento.getFullYear(), $fecha_asiento.getMonth(), 1) {
//         document.getElementById('tipo_asiento').value = "1";
//         document.getElementById('noFinmes').hidden = false;
//     }

//     $fecha_asiento = new Date(document.getElementById('fecha_asiento').value);
//     var lastDay = new Date($fecha_asiento.getFullYear(), $fecha_asiento.getMonth() + 1, 0);
//     if (($fecha_asiento.getDate() + 1 > $fecha_asiento.getFullYear(), $fecha_asiento.getMonth(), 1) && ($fecha_asiento.getDate() + 1 < lastDay.getDate())) {
//         document.getElementById('tipo_asiento').value = "5";
//         document.getElementById('noFinmes').hidden = false;
//     }
//     $fecha_asiento = new Date(document.getElementById('fecha_asiento').value);

//     var lastDay = new Date($fecha_asiento.getFullYear(), $fecha_asiento.getMonth() + 1, 0);
//     if ($fecha_asiento.getDate() + 1 == lastDay.getDate()) {
//         document.getElementById('tipo_asiento').value = "9";
//         document.getElementById('noFinmes').hidden = true;
//     }
// }
// function noesfinmes() {
//     $fecha_hasta = document.getElementById('fecha_hasta').value;
//     var lastDay = new Date($fecha_hasta.getFullYear(), $fecha_hasta.getMonth() + 1, 0);
//     if ($fecha_hasta.getDate() + 1 != lastDay.getDate()) {
//         document.getElementById('noFinmes').hidden = false;
//     }
// }


function setTipo_asiento(fecha_aper, fecha_cierr, fecha_emi_diario) {

    $fecha_asiento = document.getElementById('fecha_asiento').value;
    $selectAsiento = document.getElementById('tipo_asiento').value;



    $fecha_asiento = new Date(document.getElementById('fecha_asiento').value);
    fecha_aper = new Date(fecha_aper);
    if ($fecha_asiento.getTime() == fecha_aper.getTime()) {
        document.getElementById('tipo_asiento').value = "1";
        // document.getElementById('noFinmes').hidden = false;
    }
    $fecha_asiento = new Date(document.getElementById('fecha_asiento').value);
    var lastDay = new Date($fecha_asiento.getFullYear(), $fecha_asiento.getMonth() + 1, 0);
    // fecha_aper = new Date(fecha_aper);
    // console.log(lastDay.getDate());
    //  console.log($fecha_asiento.getDate() + 1);
    if (($fecha_asiento.getTime() > fecha_aper.getTime())) {
        document.getElementById('tipo_asiento').value = "5";
        // if ($fecha_asiento.getDate() + 1 < lastDay.getDate()) {
        //     document.getElementById('noFinmes').hidden = false;
        // }
    }

    $fecha_asiento = new Date(document.getElementById('fecha_asiento').value);
    fecha_emi_diario = new Date(fecha_emi_diario);
    // console.log(lastDay.getDate());
    // console.log(fecha_emi_diario.getFullYear(), fecha_emi_diario.getMonth() + 1, fecha_emi_diario.getDate());
    // console.log($fecha_asiento.getFullYear(), $fecha_asiento.getMonth() + 1, $fecha_asiento.getDate() + 1);
    if (($fecha_asiento.getFullYear() == fecha_emi_diario.getFullYear()) && ($fecha_asiento.getMonth() + 1 == fecha_emi_diario.getMonth() + 1) && ($fecha_asiento.getDate() + 1 == fecha_emi_diario.getDate())) {
        document.getElementById('tipo_asiento').value = "9";
        // if ($fecha_asiento.getDate() + 1 < lastDay.getDate()) {
        //     document.getElementById('noFinmes').hidden = true;
        // }
    }
}

function finmes() {


    $fecha_asiento = new Date(document.getElementById('fecha_asiento').value);
    var lastDay = new Date($fecha_asiento.getFullYear(), $fecha_asiento.getMonth() + 1, 0);

    if ($fecha_asiento.getDate() + 1 < lastDay.getDate()) {
        document.getElementById('noFinmes').hidden = false;
    } else {
        document.getElementById('noFinmes').hidden = true;
    }
}

function finmes2() {

    $fecha_hasta = new Date(document.getElementById('fecha_hasta').value);
    var lastDay = new Date($fecha_hasta.getFullYear(), $fecha_hasta.getMonth() + 1, 0);

    if ($fecha_hasta.getDate() + 1 < lastDay.getDate()) {
        document.getElementById('noFinmes').hidden = false;
    } else {
        document.getElementById('noFinmes').hidden = true;
    }
}

function finmes3() {

    $fecha_hasta2 = new Date(document.getElementById('fecha_hasta2').value);
    var lastDay = new Date($fecha_hasta2.getFullYear(), $fecha_hasta2.getMonth() + 1, 0);

    if ($fecha_hasta2.getDate() + 1 < lastDay.getDate()) {
        document.getElementById('noFinmes3').hidden = false;
    } else {
        document.getElementById('noFinmes3').hidden = true;
    }
}
function setEmpresa() {
    $idE = document.getElementById('idE').value;
    $selectProvincia = document.getElementById('nombreEmpresa');
    $selectProvincia.value = $idE;


    if ($('select[name="nombreEmpresa"] option:selected').text() == '1') {
        $connection = 'Tp1_Practica_Profesional';
    }

    if ($('select[name="nombreEmpresa"] option:selected').text() == '2') {
        $connection = 'empresa1';
    }
}
window.addEventListener('DOMContentLoaded', () => {

    document.getElementById('inputSearch').addEventListener('input', setSearchListener);
    document.getElementById('btnSaveChange').addEventListener('click', validaCambios);

    setTableRoles();
});


function setTableRoles() {

    const table = document.getElementById('tableUsers');
    const tbody = table.querySelector('tbody');

    fetch('../../php/funciones.php?opc=setTableRoles')
        .then(res => res.json())
        .then(data => {
            if (!data.estado) throw new Error(data.mensaje);
            tbody.innerHTML = data.datos;
        })
        .catch(err => {
            console.error(err);
            pointless('Error al obtener la informacion de los usuarios', 'error');
        })

}

function setSearchListener(evt) {

    const tbody = document.querySelector('#tableUsers tbody');
    const input = evt.target;

    tbody.querySelectorAll('tr').forEach(elem => {
        const regex = new RegExp(input.value, 'ig');

        let newDisplay = regex.test(elem.textContent) ? '' : 'none';
        elem.style.display = newDisplay;
    });

}

function validaCambios(){

    if( document.querySelectorAll('#tableUsers tbody tr:has( input[checked]:not(:checked) )').length ){
        saveNewRoles()
    }else{
        createToast('No hay ningun usuario para actualizar', 'warning');
    }
}

function saveNewRoles(){

    const tbody = document.querySelector('#tableUsers tbody');

    let objSave = [ ... tbody.querySelectorAll('tr:has( input[checked]:not(:checked) )') ].map(elem => {
        let userId = elem.getAttribute('data-userid');
        let radioSelected = elem.querySelector('.tab input:checked')

        return {
            'userId': userId,
            'newRole': radioSelected.value
        };
    });

    let form_data = new FormData();
    form_data.append('opc', 'saveNewRoles');
    form_data.append('users', JSON.stringify( objSave ));

    fetch('../../php/funciones.php',{
        method: 'POST',
        body: form_data
    }).then(res => res.json())
        .then(data => {
            if( !data.estado ) throw new Error( data.mensaje );

            toastReloadPage('Se actualizaron los usuarios con éxito', 'success', 'Se cargará la nueva información...');
        })
        .catch(err => {
            console.error(err)
            createToast('Ocurrio un problema mientras se actualizaban los usuarios', 'error');
        })

}
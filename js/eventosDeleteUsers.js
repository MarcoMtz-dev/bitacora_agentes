window.addEventListener('DOMContentLoaded', () => {

    document.getElementById('inputSearch').addEventListener('input', setSearchListener);

    setTableDeleteUsers();
});


function setTableDeleteUsers() {

    const table = document.getElementById('tableUsers');
    const tbody = table.querySelector('tbody');

    fetch('../../php/funciones.php?opc=setTableDeleteUsers')
        .then(res => res.json())
        .then(data => {
            if (!data.estado) throw new Error(data.mensaje);
            tbody.innerHTML = data.datos;
            setDeleteListeners();
        })
        .catch(err => {
            console.error(err);
            pointless('Error al obtener la informacion de los usuarios', 'error');
        })

}


function setDeleteListeners(){

    document.querySelectorAll('svg.svg-delete').forEach(svg => {
        svg.addEventListener('click', validaDelUser);
    });

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

function validaDelUser( evt ){

    const svg = evt.target;
    const trParent = svg.closest('[data-userid]');
    const nombre = trParent.childNodes[3];

    Swal.fire({
        title: "¿Estás seguro?",
        text: `Estás por borrar el usuario ${nombre.textContent}`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, borralo",
        cancelButtonText: 'Cancelar'
        }).then((result) => {
            if(result.isConfirmed) removeUser( trParent.getAttribute('data-userid') );
    });

}

function removeUser( userId ){

    const trUser = document.querySelector(`[data-userid='${userId}']`);

    if( !trUser ) return createToast('Usuario no encontrado', 'warning');

    let form_data = new FormData();
    form_data.append('opc','removeUser');
    form_data.append('userId', userId);

    fetch('../../php/funciones.php',{
        method: 'POST',
        body: form_data
    }).then(res => res.json())
    .then(data => {
        if( !data.estado ) throw new Error( data.mensaje );
        createToast('Se eliminó el usuario con éxito', 'success');

        trUser.remove()
    })
    .catch(err => {
        console.error(err)
        pointless('Ocurrio un error mientras se eliminaba el usuario');
    })

}
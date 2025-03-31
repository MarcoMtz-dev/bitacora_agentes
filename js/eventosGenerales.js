window.addEventListener('DOMContentLoaded', () => {
    getDarkThemeFromStorage();

    document.querySelectorAll('input:not( :is([type=time], [type=date]) ), textarea').forEach(elem => {
        elem.addEventListener('input', evt => {
            const regex = /[^a-z0-9_()\.\,@\/\%\$\#\!\?\*\+\& \-]/ig;
            let newVal = evt.target.value.replace(regex, '');
            return evt.target.value = newVal;
        })
    });

    document.querySelectorAll('[data-fillwithdb=categoria]').forEach(setSlcCategoria);

    document.querySelectorAll('[data-fillwithelem=categoria]').forEach(elem => {

        const idDepend = elem.getAttribute('data-fillwithelem');

        document.getElementById(idDepend).addEventListener('change', evt => {
            setSlcSubcategoria(elem, evt.target.value);
        });
    });
    
})

function getDarkThemeFromStorage() {

    let objDefault = {
        darkThemeActive: false
    };

    const storage = window.localStorage.getItem('bitacora_bancoppel_storage');
    const objStorage = JSON.parse(storage) ?? objDefault;

    setDarkTheme(objStorage.darkThemeActive);
}

function setDarkTheme(activateDarkTheme) {

    if (activateDarkTheme) {
        document.body.setAttribute('data-bd-dark', 1);
    } else {
        document.body.removeAttribute('data-bd-dark');
    }

}

function pointless(message = '', tipomensaje = 'info') {
    Swal.fire({
        icon: tipomensaje,
        title: message,
        footer: '<a href></a>'
    });
}

function createToast(message = '', type = 'info') {

    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
    Toast.fire({
        icon: type,
        title: message
    });

}

function pointlessLoading(elemToDisable = null) {
    const swal = Swal.fire({
        title: "Cargando...",
        didOpen: () => {
            Swal.showLoading();
            if (elemToDisable) elemToDisable.disabled = true;
        },
        didDestroy: () => {
            if (elemToDisable) elemToDisable.disabled = false;
        }
    })

    return swal;
}

function toastReloadPage(message = '', type = 'info', subtitle = 'La pagina se recargará...'){

    Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        },
        didClose: () => {
            window.location.reload();
        }
    }).fire({
        icon: type,
        title: message,
        text: subtitle
    });

}

function enabledWith(elem){

    let [ idElemParent, valueToSearch, ..._ ] = elem.getAttribute('data-enabledwith').split('/');
    const elemParent = document.getElementById( idElemParent );
    
    elemParent.addEventListener('change', () => {
        
        elem.value = '';

        if( elemParent.value.toUpperCase() == valueToSearch.toUpperCase() || valueToSearch === '*'){
            elem.disabled = false;
        }
        else{
            elem.disabled = true;
        }

    });

}

function addOptionTo(elem, value, text) {
    /*
        Agrega un elemento option al elemento proporcionado en ELEM
    */

    if (text === undefined) text = value;

    const option = document.createElement('option');
    option.value = value;
    option.textContent = text;

    return elem.appendChild(option);
}


function setSlcCategoria(elem) {

    fetch(`../php/funciones.php?opc=getCategorias`)
        .then(res => res.json())
        .then(data => {
            if (!data.estado) throw new Error(data.mensaje);
            elem.innerHTML = data.datos;
        })
        .catch(err => {
            console.error(err);
            createToast('Error al cargar las categorias', 'error');
        })
        
}

function setSlcSubcategoria(elem, elemParent) {

    fetch(`../php/funciones.php?opc=getSubcategoria&categoria=${elemParent}`)
        .then(res => res.json())
        .then(data => {
            if (!data.estado) throw new Error(data.mensaje);
            elem.innerHTML = data.datos;
        })
        .catch(err => {
            console.error(err);
            createToast('Error al cargar las subcategorias', 'error');
        })
}

async function getSessionInfo(){

    let response;

    try{
    
        let res = await fetch('../php/funciones.php?opc=getSessionInfo');
        let data = await res.json();

        response = data.datos;

    }catch(err){
        response = false;
    }

    return response;
}
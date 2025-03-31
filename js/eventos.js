'use strict';

window.addEventListener('DOMContentLoaded', eventListeners);

function eventListeners(){

    const inputOpener = document.getElementById('chboxSideBarOpener');
    const iframeForms = document.getElementById('iframeForms');

    document.querySelectorAll('aside .sidebar-body > .dropdown-container > .sidebar-item').forEach(elem => {
        elem.addEventListener('click', evt => {
            //Abre el sidebar si presionamos un elemento y no esta abierto
            if( !inputOpener.checked ) inputOpener.checked = true
        });
    });


    document.querySelectorAll('[data-src]').forEach(elem => {
        elem.addEventListener('click', evt => {
            const newSrc = evt.target.getAttribute('data-src');
            iframeForms.src = newSrc;
        })
    });

    document.getElementById('darkthemeController').addEventListener('change', evt => setDarkTheme( evt.target.checked ));
    getDarkThemeFromStorage();
}

function setDarkTheme( activateDarkTheme ){
    
    const chboxDarkThemeController = document.getElementById('darkthemeController');
    chboxDarkThemeController.checked = activateDarkTheme

    setDarkThemeChilds( activateDarkTheme );

    let objStorage = JSON.stringify({
        darkThemeActive: activateDarkTheme
    });

    window.localStorage.setItem('bitacora_bancoppel_storage', objStorage);
}

function setDarkThemeChilds( activateDarkTheme ){

    const iframeForms = document.getElementById('iframeForms');
    const iframeChild = iframeForms.contentDocument;

    if( activateDarkTheme ){
        iframeChild.body.setAttribute('data-bd-dark',1);
    }else{
        iframeChild.body.removeAttribute('data-bd-dark');
    }
}

function getDarkThemeFromStorage(){

    let objDefault = {
        darkThemeActive: false
    };

    const storage = window.localStorage.getItem('bitacora_bancoppel_storage');
    const objStorage = JSON.parse(storage) ?? objDefault;
    
    setDarkTheme( objStorage.darkThemeActive );
}
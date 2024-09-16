let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora:'',
    estilista:'',
    lugar: '',
    servicios: []
}

document.addEventListener('DOMContentLoaded',function(){
    iniciarApp();
});

function iniciarApp(){
    mostrarSeccion(); //Muestra y oculta las secciones
    tabs();//Cambia la seccion cuando se presionen los tabs
    botonesPaginador();//Agrega o quita los botones del paginador
    paginaSiguiente();
    paginaAnterior();

    consultarAPI(); //Consulta la API en el backend del API

    idCliente();
    nombreCliente();//Añade el nombre del cliente
    seleccionarFecha();//Añade la fecha de la cita
    seleccionarHora();//Añade la hora de la cita
    estilista();

    mostrarResumen(); //Muestra el resumen de la cita
}

function mostrarSeccion(){
    //Ocultar la seccion que tenga la clase de mostrar
    const seccionAnterior = document.querySelector('.mostrar');
    if(seccionAnterior){
        seccionAnterior.classList.remove('mostrar');
    }
    

    //Seleccionar la seccion con el paso
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');

    //Quita la clase actual al tab anterior
    const tabAnterior = document.querySelector('.actual');
    if(tabAnterior){
        tabAnterior.classList.remove('actual');
    }

    //Resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');

}

function tabs(){
    const botones = document.querySelectorAll('.tabs button');
    
    botones.forEach( boton => {
        boton.addEventListener('click', function(e){
            paso = parseInt( e.target.dataset.paso);
            // paso = parseInt(e.target.dataset.paso);
            mostrarSeccion();

            botonesPaginador();

        });
    })
}


function botonesPaginador(){
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if(paso === 1){
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar')
    }else if(paso === 3){
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar')

        mostrarResumen();
    }else{
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }

    mostrarSeccion();
}

function paginaAnterior(){
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function(){
        if(paso <= pasoInicial) return;

        paso--;

        botonesPaginador();
    })
}

function paginaSiguiente(){
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function(){
        if(paso >= pasoFinal) return;

        paso++;

        botonesPaginador();
    })
}

async function consultarAPI(){
    try{
        const urlServicios = '/api/servicios';
        const urlEstablecimientos = '/api/establecimientos';

        const resultadoServicios = await fetch(urlServicios);
        const resultadoEstablecimientos = await fetch(urlEstablecimientos);

        const servicios = await resultadoServicios.json();
        const establecimientos = await resultadoEstablecimientos.json();

        mostrarServicios(servicios);
        mostrarEstablecimientos(establecimientos);
    }catch(error){
        console.log(error);
    }
}

function mostrarServicios(servicios){
    servicios.forEach( servicio =>{
        const { id, nombre, precio} = servicio;

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$ ${precio}`;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = function() {
            seleccionarServicio(servicio)
        };

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio)
        
        document.querySelector('#servicios').appendChild(servicioDiv);
    });
}

function seleccionarServicio(servicio){
    const { id } = servicio;
    const { servicios } = cita;

    //Identificar el elemento al que se le da click
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

    //Comprobar si un servicio ya fue seleccionado
    if( servicios.some( agregado => agregado.id === id) ){
        //Eliminar
        cita.servicios = servicios.filter(agregado => agregado.id !== id);
        divServicio.classList.remove('seleccionado');
    }else{
        //Agregar
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add('seleccionado');
    }
    console.log(cita);
}


function idCliente(){
    const id = document.querySelector('#id').value;

    cita.id = id;
}

function nombreCliente(){
    const nombre = document.querySelector('#nombre').value;

    cita.nombre = nombre;
}

function seleccionarFecha(){
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function(e){
        
        const dia = new Date(e.target.value).getUTCDay();
        
        if([].includes(dia)){
            e.target.value = '';
            mostrarAlerta('Lunes no permitidos', 'error', '.formulario');
        }else{
            cita.fecha = e.target.value;
        }
    });
}

function seleccionarHora(){
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function(e){


        const horaCita = e.target.value;
        const hora =  horaCita.split(":")[0];
        if(hora < 12 || hora > 21){
            e.target.value = '';
            mostrarAlerta('Hora no valida','error','.formulario');
        }else{
            cita.hora = e.target.value;
        }
    })
}

function estilista(){
    const estilista = document.querySelector('#estilista');
    estilista.addEventListener('input', function(){
        cita.estilista = estilista.value;
    });
}

function mostrarEstablecimientos(establecimientos) {
    // Selecciona el contenedor donde se añadirá el elemento <select>
    const contenedor = document.querySelector('#ubicacion');
    
    // Crea el elemento <select>
    const select = document.createElement('select');
    select.id = 'select-establecimientos';

    // Añade una opción vacía al principio del select (opcional)
    const opcionDefault = document.createElement('option');
    opcionDefault.textContent = 'Selecciona un establecimiento';
    opcionDefault.value = '';
    select.appendChild(opcionDefault);

    // Itera sobre los establecimientos y crea una opción para cada uno
    establecimientos.forEach(establecimiento => {
        const { id, ubicacion } = establecimiento;

        const option = document.createElement('option');
        option.value = ubicacion;  // Establece el valor de la opción al id del establecimiento
        option.textContent = ubicacion;  // Establece el texto visible de la opción al nombre del establecimiento

        select.appendChild(option);
    });

    // Limpia el contenedor y añade el <select>
    contenedor.innerHTML = ''; // Elimina cualquier contenido anterior
    contenedor.appendChild(select);

    // Añade un event listener al select
    select.addEventListener('change', function(event) {
        const selectedId = event.target.value;
        
        // Actualiza la propiedad 'establecimientos' de cita con el id seleccionado
        cita.lugar = selectedId;

        // Opcional: Puedes hacer algo más con el objeto cita aquí
        console.log(cita);
    });
}

function mostrarAlerta(mensaje, tipo, elemento, desaparece = true){
    //Previene que se generen multiples alertas
    const alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia) {
        alertaPrevia.remove();
    }

    //Crea una alerta
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    if(desaparece){
        //Elimina la alerta
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }
    
}

function mostrarResumen(){
    const resumen = document.querySelector('.contenido-resumen');

    //Limpiar el contenido de resumen
    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
    }
    console.log(Object.values(cita).includes(''))

    if(Object.values(cita).includes('') || cita.servicios.length === 0){
        mostrarAlerta('Faltan datos de servicios,Fecha u Hora','error','.contenido-resumen', false);
        return;
    }
    
    //Formatear el DIV de resumen
    const { nombre, fecha, hora, estilista,servicios, lugar } = cita;

    

    //Head para servicios en resumen
    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Resumen de servicios';
    resumen.appendChild(headingServicios);

    //Llamando y Mostrando los servicios solicitados
    servicios.forEach(servicio =>{
        const { id, precio, nombre} = servicio;
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio: </span> $${precio}`;

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);
    });

    //Head para cita en resumen
    const headingCita = document.createElement('H3');
    headingCita.textContent = 'Resumen de Cita';
    resumen.appendChild(headingCita);

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre: </span> ${nombre}`;

    //Formatear la fecha a español
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(year, mes, dia));

    const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'};
    const fechaFormateada = fechaUTC.toLocaleDateString('es-MX', opciones);

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha: </span> ${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora: </span> ${hora}`;

    const estilistaSeleccionado = document.createElement('P');
    estilistaSeleccionado.innerHTML = `<span>Estilista: </span> ${estilista}`;

    const establecimientoSeleccionado = document.createElement('P');
    establecimientoSeleccionado.innerHTML = `<span>Ubicacion: </span> ${lugar}`;

    //Boton para crear una cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = reservarCita;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);
    resumen.appendChild(establecimientoSeleccionado);
    resumen.appendChild(estilistaSeleccionado);
    

    resumen.appendChild(botonReservar);
}

async function reservarCita(){
    
    const { nombre, fecha, hora,lugar ,estilista,servicios, id } = cita;

    const idServicios = servicios.map( servicio => servicio.id)
    console.log(idServicios);

    
    const datos = new FormData();
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('estilista', estilista);
    datos.append('lugar', lugar);
    datos.append('usuarioId', id);
    datos.append('servicios', idServicios);


    // console.log([...datos]);

    try{
        //Peticio a la API
        const url = '/api/citas';
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });

        const resultado = await respuesta.json();

        if(resultado.resultado){
            Swal.fire({
                icon: "success",
                title: "Cita Creada",
                text: "Tu cita fue creada correctamente",
                button: 'OK'
            }).then( () => {
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
                
            })
        }
    }catch(error){
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Hubo un error mientras agendabamos tu cita"
          });
    }

    
    // console.log(...datos);
}
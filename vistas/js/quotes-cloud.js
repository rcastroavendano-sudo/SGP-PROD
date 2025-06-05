/*==================================================================================================
INICIALIZANDO VARIABLES GLOBALES, FUNCIONES Y VARIABLES DESDE LA BD
==================================================================================================*/
/* Funcion que solo acepta valores positivos incluyendo el 0
es llamada desde los input u-rack-bellet y u-rack-liray
*/
function soloValoresPositivos(input) {
    // Elimina cualquier valor no numérico y garantiza que el número sea positivo o cero
    input.value = input.value.replace(/[^0-9]/g, '');

    // Verifica que el valor no sea negativo
    if (parseInt(input.value) < 0) {
        input.value = '0'; // Establece a 0 si el número es negativo
    }
  }
  
  
// Inicializa el contador de filas para llevar el seguimiento del número de filas en la tabla
let contadorFilas = 0;

// Lista de columnas que tendrá cada fila
const columnas = [
    "num", "qty", "vm", "datacenter", "vcpu", "vmem", "vdisk", "bkp", "so", "cals", "bd",
    "sal", "bwinetbp", "bwinetbs", "bwinetlp", "bwinetls", "ip", "valor", "acciones"
];

/* Este bloque se ejecutará únicamente si el usuario pincha en Crear Quotes y que éste esté en la ruta '/SGP/quotes-cloud'
gracias a la validación con window.location.pathname.
Evento que se ejecuta cuando el contenido HTML del documento ha sido completamente cargado y analizado,
pero antes de que se hayan cargado hojas de estilo, imágenes y subframes. */

document.addEventListener("DOMContentLoaded", () => {   
    if (window.location.pathname === '/SGP/quotes-cloud') {
        agregarFila();  // Agrega una fila por defecto al cargar la página en la sección "quotes-cloud".

        obtenerValorDesdeServidor('obtenerValorDCBellet', 'sqlDCBellet');
        obtenerValorDesdeServidor('obtenerValorDCUBellet', 'sqlDCUBellet');
        obtenerValorDesdeServidor('obtenerValorDCLiray', 'sqlDCLiray');
        obtenerValorDesdeServidor('obtenerValorDCULiray', 'sqlDCULiray');
        obtenerValorDesdeServidor('obtenerValorDCAmbos', 'sqlDCAmbos');

        obtenerValorDesdeServidor('obtenerValorVcpu', 'sqlVcpu');
        obtenerValorDesdeServidor('obtenerValorVmem', 'sqlVmem');
        obtenerValorDesdeServidor('obtenerValorVdisk', 'sqlVdisk');

        obtenerValorDesdeServidor('obtenerValorBkpBronze', 'sqlBkpBronze');
        obtenerValorDesdeServidor('obtenerValorBkpSilver', 'sqlBkpSilver');
        obtenerValorDesdeServidor('obtenerValorBkpGold', 'sqlBkpGold');
        obtenerValorDesdeServidor('obtenerValorBkpPlatinum', 'sqlBkpPlatinum');

        obtenerValorDesdeServidor('obtenerValorSOLinux', 'sqlSOLinux');
        obtenerValorDesdeServidor('obtenerValorSOWindows', 'sqlSOWindows');
        obtenerValorDesdeServidor('obtenerValorSOOracle', 'sqlSOOracle');
        obtenerValorDesdeServidor('obtenerValorSOCals', 'sqlSOCals');

        obtenerValorDesdeServidor('obtenerValorBDMySQL', 'sqlBDMySQL');
        obtenerValorDesdeServidor('obtenerValorBDSQLServer', 'sqlBDSQLServer');
        obtenerValorDesdeServidor('obtenerValorBDPostgreSQL', 'sqlBDPostgreSQL');
        obtenerValorDesdeServidor('obtenerValorBDSal', 'sqlBDSAL');

        obtenerValorDesdeServidor('obtenerValorRedesBWINET100PrimarioBellet', 'sqlRedesBWINET100PrimarioBellet');
        obtenerValorDesdeServidor('obtenerValorRedesBWINET200PrimarioBellet', 'sqlRedesBWINET200PrimarioBellet');
        obtenerValorDesdeServidor('obtenerValorRedesBWINET300PrimarioBellet', 'sqlRedesBWINET300PrimarioBellet');

        obtenerValorDesdeServidor('obtenerValorRedesBWINET100SecundarioBellet', 'sqlRedesBWINET100SecundarioBellet');
        obtenerValorDesdeServidor('obtenerValorRedesBWINET200SecundarioBellet', 'sqlRedesBWINET200SecundarioBellet');
        obtenerValorDesdeServidor('obtenerValorRedesBWINET300SecundarioBellet', 'sqlRedesBWINET300SecundarioBellet');

        obtenerValorDesdeServidor('obtenerValorRedesBWINET100PrimarioLiray', 'sqlRedesBWINET100PrimarioLiray');
        obtenerValorDesdeServidor('obtenerValorRedesBWINET200PrimarioLiray', 'sqlRedesBWINET200PrimarioLiray');
        obtenerValorDesdeServidor('obtenerValorRedesBWINET300PrimarioLiray', 'sqlRedesBWINET300PrimarioLiray');

        obtenerValorDesdeServidor('obtenerValorRedesBWINET100SecundarioLiray', 'sqlRedesBWINET100SecundarioLiray');
        obtenerValorDesdeServidor('obtenerValorRedesBWINET200SecundarioLiray', 'sqlRedesBWINET200SecundarioLiray');
        obtenerValorDesdeServidor('obtenerValorRedesBWINET300SecundarioLiray', 'sqlRedesBWINET300SecundarioLiray');

        obtenerValorDesdeServidor('obtenerValorRedesIPPublica', 'sqlRedesIPPublica');
    }
});


/**
 * Función para obtener valores desde el servidor mediante AJAX que está en el archivo quotes.ajax.php.
 * Es llamada desde el DOMContentLoaded
 * @param {string} accion - Nombre de la acción que se enviará al servidor (son los obtenerValor... y que son procesadas en el archivo quotes.ajax.php).
 * @param {string} variableGlobal - Nombre de la variable global en la que se almacenará el valor recibido del servidor AJAX (son los sql...) en el archivo quotes.ajax.php.
 */
function obtenerValorDesdeServidor(accion, variableGlobal) {
    $.ajax({
        url: 'ajax/quotes.ajax.php', // Ruta del archivo AJAX que manejará la solicitud
        type: 'POST',               // Método HTTP utilizado para la solicitud.
        data: { 
            accion: accion          // Variable Acción enviada al servidor como parte de los datos.
        }, 
        success: function(response) {
            try {
                var data = JSON.parse(response); // Se analiza la respuesta parseando a formato JSON.
                //console.log(`Valor recibido del servidor: ${data.valor}`); // Verifica el valor recibido
                
                if (data.success) {
                    // Asigna el valor recibido a una variable global (como por ejemplo sqlDCBellet), manejando valores no numéricos.
                    window[variableGlobal] = !isNaN(parseFloat(data.valor)) ? parseFloat(data.valor) : 0;

                    // Muestra el valor rescatado desde el AJAX - BD en la consola
                    //console.log(`${variableGlobal}:`, window[variableGlobal]);

                } else {
                    console.error("No se pudo obtener el valor de ${accion}.");
                }
            } catch (e) {
                console.error("Error en obtenerValorDesdeServidor al parsear la respuesta:", e);
            }
        },
        error: function() {
            console.error("Error en obtenerValorDesdeServidor al parsear la respuesta:", e);
        }
    });
}
/*==================================================================================================
FIN INICIALIZANDO VARIABLES GLOBALES Y VARIABLES DESDE LA BD
==================================================================================================*/




/*==================================================================================================
ACTUALIZANDO LOS VALORES EN LAS FILAS
==================================================================================================*/
/*Función que actualiza el costo total de la quote sumando los valores de todas las filas
 * Llamada desde:
 * actualizarCostoCadaFila()
 * agregarFila()
 * actualizarYEliminarFila()
 */
function actualizarCostoTotal() {
    let total = 0;

    // Recorre todos los "Valor Mensual USD" de todas las y los suma para que al final, los asigne al "costo total (USD)"
    for (let i = 1; i <= contadorFilas; i++) {
        // Obtiene el valor del input y lo convierte a número usando parseFloat
        let valor = parseFloat(document.querySelector(`input[id='valor-id-${i}']`).value);

        // Verifica que el valor sea un número válido antes de sumarlo al total, si es otra cosa, le suma 0.
        if (!isNaN(valor)) {
            total += valor;
        }
        else
            total+=0;
    }
    // Asigna el valor total con 2 decimales al campo "costo-total"
    document.querySelector("input[name='costo-total']").value = total.toFixed(2);
}

/* Función que actualiza el costo de cada fila calculando el valor basado en los recursos de cada VM
 * Llamada desde agregarFila()
*/
function actualizarCostoCadaFila() {
    let valorFila = 0, cantSrv=1;
    const fila = this.closest("tr"); // Obtiene la fila donde se encuentra el input  

    fila.querySelectorAll("input, select").forEach(element => {
        let valor = 0;
        let valorFilaCheckIP =0;

        // Divide el atributo "name" del element en dos partes: el nombre y el ID.
        // Usa el método split(), que separa la cadena en un array usando el delimitador "-id-".
        // Extrae la parte del "nombre base" antes de "-id-" y el id del element despues de "-id-"
        // En el ejemplo "so-id-1", esto devolverá baseName="so" y baseId="1";
        const baseName = element.name.split("-id-")[0];
        const baseId = element.name.split("-id-")[1];

        // Asigna el valor al Combobox "DATACENTER"
        if (element.tagName === "SELECT" && baseName === "datacenter")
        { 
            //console.log("Valor seleccionado datacenter:", element.value);
            //Asignar el nuevo valor para el Datacenter seleccionado
            if (element.value === "Bellet")
                valorFila += sqlDCBellet;
            else if (element.value === "Liray")
                valorFila += sqlDCLiray;
            else if (element.value === "Ambos")
                valorFila += sqlDCAmbos;
        }

        // Asigna el valor a todos los "INPUT"
        else if (element.tagName === "INPUT")
        {
            valor = parseInt(element.value) || 0; // Obtiene el valor numérico o 0 si es inválido

            if (baseName === "vcpu") {
                valorFila +=  valor * sqlVcpu; // Multiplica el valor de vCPU por su costo
                //console.log("2. Paso x SQL, va en: ", valorFila);
            }
            else if (baseName === "vmem") {
                valorFila += valor * sqlVmem; // Multiplica el valor de memoria por su costo
                //console.log("3. Paso x MEM, va en: ", valorFila);
            }
            else if (baseName === "vdisk") {
                valorFila += valor * sqlVdisk; // Multiplica el valor de disco por su costo
                //console.log("4. Paso x vDisk, va en: ", valorFila);
            }
            else if (baseName === "cals") {
                valorFila += valor * Number(sqlSOCals); // Multiplica el valor de disco por su costo
                //console.log("5. Paso x CALS, va en: ", valorFila);
            }
            else if (baseName === "sal") {
                valorFila += valor * Number(sqlBDSAL); // Multiplica el valor de disco por su costo
                //console.log("6. Paso x SAL, va en: ", valorFila);
            }

            else if (baseName === "qty") {
                if (element.value === "0" || element.value === ""){
                    cantSrv = 1;
                    element.value=1; // No permite que el valor de qty sea 0 
                    //console.log("QTY IF: " + element.value);
                }
                else{
                    cantSrv = element.value;
                    //console.log("QTY ELSE: " + element.value);
                }
            }              
            
            else if (baseName === "ip" && element.type === "checkbox") {
                //console.log("\n\n8. Paso x CheckIP, va en: ", valorFila);
                //console.log("Estado actual (checked):", element.checked);  // Muestra si el checkbox está marcado o no
                //console.log("Estado previo (dataset.checked):", element.dataset.checked);  // Muestra el estado previo guardado en dataset.checked
                
                if (element.dataset.checked === undefined || element.dataset.checked === null) { //Si el estado del check es raro, le asigna false.
                    element.dataset.checked = "false";
                }
                
                const estadoActual = element.checked;  // Estado actual del checkbox
                const estadoPrevio = element.dataset.checked;  // Estado previo almacenado en dataset.checked       
                if (estadoActual !== estadoPrevio) {  // Si hay un cambio de estado
                    if (estadoActual) {
                        valorFilaCheckIP = sqlRedesIPPublica;  // Sumar costo si se marca
                    } else {
                        valorFilaCheckIP = 0;  // Restar costo si se desmarca
                    }
                    // Actualizar el estado previo
                    element.dataset.checked = estadoActual ? "true" : "false";
                }
            }
        }

        // Asigna el valor al Combobox "RESPALDO - BKP"
        else if (element.tagName === "SELECT" && baseName === "bkp")
        {
            //console.log("Valor seleccionado BKP:", element.value);
            //Asignar el nuevo valor para el tipo de respaldo seleccionado
            if (element.value === "Bronze")
                valorFila += sqlBkpBronze;
            else if (element.value === "Silver")
                valorFila += sqlBkpSilver;
            else if (element.value === "Gold")
                valorFila += sqlBkpGold;
            else if (element.value === "Platinum")
                valorFila += sqlBkpPlatinum;
            //console.log("9. Paso x BKP, va en: ", valorFila);
        }
            
        // Asigna el valor al Combobox "SISTEMA OPERATIVO - SO"
        else if (element.tagName === "SELECT" && baseName === "so") { 
            //console.log("Valor seleccionado SO:", element.value);
            // Asignar el nuevo valor para el SO
            if (element.value === "Linux")
                valorFila += sqlSOLinux;
            else if (element.value === "Windows")
                valorFila += sqlSOWindows;
            else if (element.value === "Oracle")
                valorFila += sqlSOOracle;
            //console.log("10. Paso x SO, va en: ", valorFila);
        }

        // Asigna el valor al Combobox "BASE DE DATOS - BD"
        else if (element.tagName === "SELECT" && baseName === "bd"){ 
            //console.log("Valor seleccionado BD:", element.value);
            // Asignar el nuevo valor para la BD
            if (element.value === "MySQL")
                valorFila += sqlBDMySQL;
            else if (element.value === "SQLServer")
                valorFila += sqlBDSQLServer;
            else if (element.value === "PostgreSQL") 
                valorFila += sqlBDPostgreSQL;
            //console.log("12. Paso x BD, va en: ", valorFila);
        }

        // Asigna el valor al Combobox "ANCHO DE BANDA DE INTERNET - BANDWIDTH x GB (Internet)-Bellet	"
        else if (element.tagName === "SELECT" && baseName === "bwinet") {
            //console.log("Valor seleccionado BW INET:", element.value);
            // Asignar el nuevo valor para la BD
            if (element.value === "100Mbps")
                valorFila += sqlRedesBWINET100;
            else if (element.value === "200Mbps")
                valorFila += sqlRedesBWINET200;
            else if (element.value === "300Mbps")
                valorFila += sqlRedesBWINET300;
            //console.log("13.Paso x BWINET, va en: ", valorFila);
        }
        //Calculando el valor de cada fila...
        valorFila = valorFila * cantSrv; //Multiplica el valorFila por la cantidad de servidores definidos en Qty (cantSrv)
        valorFila += valorFilaCheckIP; //Suma al valorFila, el valor de IP pública en caso de estar seleccionado

        const valorInput = fila.querySelector(`input[id='valor-id-${baseId}']`);
        
        valorInput.value = valorFila.toFixed(2);
            
        actualizarCostoTotal();
    });
    
    

}
/*==================================================================================================
FIN ACTUALIZANDO LOS VALORES EN LAS FILAS
==================================================================================================*/




/*==================================================================================================
AGREGAR/ELIMINAR FILAS
==================================================================================================*/
/* Función que agrega una nueva fila a la tabla dinámica, creando las celdas con inputs (valores que se ingresan)
 * y selects/combobox (como la opcion de: datacenter, respaldo, SO,  BD y BANDWIDTH x GB)
 * Llamada desde:
 * document.addEventListener
 * Boton "Agregar Fila"
*/
function agregarFila() {
    if (window.location.pathname === "/SGP/quotes-cloud") { 
    const tabla = document.getElementById("tabla-dinamica").getElementsByTagName("tbody")[0];
    const nuevaFila = document.createElement("tr"); // Crea una nueva fila vacía
    contadorFilas++;  

    // Construye cada celda de la fila basándose en las columnas definidas
    columnas.forEach((columna) => {
        const nuevaCelda = document.createElement("td"); // Crea una nueva celda

        switch (columna) {
            case "num":
                // Muestra el número de fila basado en el contador
                nuevaCelda.textContent = contadorFilas;
                break;

            case "qty":
                // Crea inputs simples para estas columnas
                nuevaCelda.appendChild(crearInput("Number", columna, `form-control col-${columna}`, actualizarCostoCadaFila));
                break;
            case "vm":
                // Crea inputs simples para estas columnas
                nuevaCelda.appendChild(crearInput("text", columna, `form-control col-${columna} text-align-left`, actualizarCostoCadaFila));
                break;

            case "datacenter":
                // Crea un select con opciones para el datacenter
                nuevaCelda.appendChild(crearSelect(columna, `
                    <option value="" selected>¿DC?</option>
                    <option value="Bellet">Bellet</option>
                    <option value="Liray">Liray</option>
                    <option value="Ambos">Ambos</option>
                `, function () {
                                        
                    // Habilita o deshabilita los campos del datacenter seleccionado
                    let valorFilaQuote = `${this.id.split("-id-")[1]}`;

                    let bwinetbp = document.querySelector(`#bwinetbp-id-${valorFilaQuote}`);
                    let bwinetbs = document.querySelector(`#bwinetbs-id-${valorFilaQuote}`);
                    let bwinetlp = document.querySelector(`#bwinetlp-id-${valorFilaQuote}`);
                    let bwinetls = document.querySelector(`#bwinetls-id-${valorFilaQuote}`);

                    if (this.value === "Bellet") {
                        bwinetbp.disabled=false;
                        bwinetbs.disabled=false;

                        bwinetlp.disabled=true;
                        bwinetls.disabled=true;
                    }
                    else if (this.value === "Liray") {
                        bwinetbp.disabled=true;
                        bwinetbs.disabled=true;
                        
                        bwinetlp.disabled=false;
                        bwinetls.disabled=false;
                    }
                    else if (this.value === "Ambos") {
                        bwinetbp.disabled=false;
                        bwinetbs.disabled=false;

                        bwinetlp.disabled=false;
                        bwinetls.disabled=false;
                    }
                    else{
                        bwinetbp.disabled=true;
                        bwinetbs.disabled=true;

                        bwinetlp.disabled=true;
                        bwinetls.disabled=true;
                    }

                    // Llamar a la función que actualizará el costo de la fila
                    actualizarCostoCadaFila.call(this);
                }));
                break;

            case "vcpu":
            case "vmem":
            case "vdisk":
                // Inputs que disparan un evento al cambiar para actualizar el total de la fila
                nuevaCelda.appendChild(crearInput("Number", columna, `form-control col-${columna}`, actualizarCostoCadaFila));
                break;

            case "bkp":
                // Select con opciones para niveles de respaldo
                nuevaCelda.appendChild(crearSelect(columna, `
                    <option value="" selected>¿BKP?</option>
                    <option value="Bronze">Bronze</option>
                    <option value="Silver">Silver</option>
                    <option value="Gold">Gold</option>
                    <option value="Platinum">Platinum</option>
                `, function () {
                    // Llamar a la función que actualizará el costo de la fila
                    actualizarCostoCadaFila.call(this);
                }));
                break;

            case "so":
                // Select para seleccionar el sistema operativo
                nuevaCelda.appendChild(crearSelect(columna, `
                    <option value="" selected>¿S.O.?</option>
                    <option value="Linux">Linux</option>
                    <option value="Windows">Windows</option>
                    <option value="Oracle">Oracle</option>
                `, function () {  
                    // Habilita o deshabilita el input de CALs basado en el sistema operativo
                    console.log(`Nuevo valor seleccionado: ${this.value}`);
                    console.log(`Nombre: ${this.name}`);
                    console.log(`ID: ${this.id}`);

                    const fila = this.closest("tr");
                    if (!fila) {
                        console.error("No se encontró la fila contenedora.");
                        return;
                    }

                    // Obtiene el valor de la Fila. Éste viene después del "-id-" del ID del select
                    let valorFilaCals = `${this.id.split("-id-")[1]}`;
                    const calsInput = fila.querySelector(`input[id='cals-id-${valorFilaCals}']`);
                    
                    // Habilita o deshabilita el campo CALs dependiendo del SO seleccionado
                    if (this.value.startsWith("Win")) {
                        calsInput.disabled = false; // Habilitar CALs
                    } else {
                        calsInput.disabled = true; // Deshabilitar CALs
                        calsInput.value = 0; // Establecer el valor a 0 cuando está deshabilitado
                    }

                    // Llamar a la función que actualizará el costo de la fila
                    actualizarCostoCadaFila.call(this);
                }));
                break;

            case "cals":
                // Crear el input deshabilitado por defecto
                const inputCals = crearInput("Number", columna, `form-control col-${columna}`, null, false);
                nuevaCelda.appendChild(inputCals);

                // Asociar un evento para recalcular solo si está habilitado
                inputCals.addEventListener("input", function () {
                    actualizarCostoCadaFila.call(this); // Llama a la función en el contexto del input
                });
                break;

            case "bd":
                // Select para seleccionar la base de datos
                nuevaCelda.appendChild(crearSelect(columna, `
                    <option value="" selected>¿BD?</option>
                    <option value="sinBD">Sin BD</option>
                    <option value="MySQL">MySQL</option>
                    <option value="SQLServer">SQLServer</option>
                    <option value="PostgreSQL">PostgreSQL</option>
                `, function () {
                    // Habilita o deshabilita el input de SAL basado en la base de datos seleccionada
                    const fila = this.closest("tr");


                    // Obtiene el valor de la Fila. Éste viene después del "-id-" del ID del select
                    let valorFilaSal = `${this.id.split("-id-")[1]}`;
                    const salInput = fila.querySelector(`input[name='sal-id-${valorFilaSal}']`);
            
                    // Habilita o deshabilita el campo SAL dependiendo de la BD seleccionada
                    if (this.value.startsWith("SQL")) {
                        salInput.disabled = false; // Habilitar SAL
                    } else {
                        salInput.disabled = true; // Deshabilitar SAL
                        salInput.value = 0; // Establecer el valor a 0 cuando está deshabilitado
                    }

                    // Llamar a la función que actualizará el costo de la fila
                    actualizarCostoCadaFila.call(this);
            
                }));
                break;
                
            case "sal":
                // Crear el input deshabilitado por defecto
                const inputSals = crearInput("Number", columna, `form-control col-${columna}`, null, false);
                nuevaCelda.appendChild(inputSals);

                // Asociar un evento para recalcular solo si está habilitado
                inputSals.addEventListener("input", function () {
                    actualizarCostoCadaFila.call(this); // Llama a la función en el contexto del input
                });
                break;

            case "bwinetbp":
                // Select para ancho de banda de internet para el enlace primario de Bellet
                nuevaCelda.appendChild(crearSelect(columna, `
                    <option value="" selected>¿BW Internet?</option>
                    <option value="100Mbps">101 Mbps Simétrico</option>
                    <option value="200Mbps">201 Mbps Simétrico</option>
                    <option value="300Mbps">301 Mbps Simétrico</option>
                `, function () {
                    // Llamar a la función que actualizará el costo de la fila
                    actualizarCostoCadaFila.call(this);
                }, false)); // Agregar el parámetro false para deshabilitar el select por defecto
                break;

            case "bwinetbs":
                // Select para ancho de banda de internet para el enlace secundario de Bellet
                nuevaCelda.appendChild(crearSelect(columna, `
                    <option value="" selected>¿BW Internet?</option>
                    <option value="100Mbps">102 Mbps Simétrico</option>
                    <option value="200Mbps">202 Mbps Simétrico</option>
                    <option value="300Mbps">302 Mbps Simétrico</option>
                `, function () {
                    // Llamar a la función que actualizará el costo de la fila
                    actualizarCostoCadaFila.call(this);
                }, false)); // Agregar el parámetro false para deshabilitar el select por defecto
                break;

            case "bwinetlp":
                // Select para ancho de banda de internet para el enlace primario de Liray
                nuevaCelda.appendChild(crearSelect(columna, `
                    <option value="" selected>¿BW Internet?</option>
                    <option value="100Mbps">103 Mbps Simétrico</option>
                    <option value="200Mbps">203 Mbps Simétrico</option>
                    <option value="300Mbps">303 Mbps Simétrico</option>
                `, function () {
                    // Llamar a la función que actualizará el costo de la fila
                    actualizarCostoCadaFila.call(this);
                }, false)); // Agregar el parámetro false para deshabilitar el select por defecto
                break;

            case "bwinetls":
                // Select para ancho de banda de internet para el enlace secundario de Liray
                nuevaCelda.appendChild(crearSelect(columna, `
                    <option value="" selected>¿BW Internet?</option>
                    <option value="100Mbps">104 Mbps Simétrico</option>
                    <option value="200Mbps">204 Mbps Simétrico</option>
                    <option value="300Mbps">304 Mbps Simétrico</option>
                `, function () {
                    // Llamar a la función que actualizará el costo de la fila
                    actualizarCostoCadaFila.call(this);
                }, false)); // Agregar el parámetro false para deshabilitar el select por defecto
                break;
            

            case "ip":
                const checkbox = document.createElement("input");
                checkbox.type = "checkbox";
                checkbox.name = "ip-id-" + contadorFilas;
                checkbox.id = "ip-id-" + contadorFilas;
                checkbox.className = "form-check-input custom-checkbox";
                nuevaCelda.style.textAlign = "center"; // Centrar el checkbox
                nuevaCelda.style.verticalAlign = "middle";
                nuevaCelda.appendChild(checkbox);

                // Asignar el evento change
                checkbox.addEventListener("change", function() {
                    //console.log("Cambio de estado del checkbox", this); // Verifica el elemento 'checkbox'
                    actualizarCostoCadaFila.call(this);  // Usar `this` para pasar el checkbox a la función
                });
                break;

            case "valor":
                // Input de valor no editable
                const input = crearInput("Number", columna, `form-control col-${columna}`, null, true);
                input.value = "0,00"; // Asignar el valor predeterminado
                nuevaCelda.appendChild(input);
                break;

            case "acciones":
                // Botón para eliminar la fila
                const eliminarBtn = document.createElement("button");
                eliminarBtn.classList.add("btn", "btn-danger", "btn-eliminar"); // Agregar la clase personalizada y las clases de Bootstrap
                eliminarBtn.textContent = "x";
                
                eliminarBtn.onclick = actualizarYEliminarFila; // Evento para eliminar la fila
                nuevaCelda.appendChild(eliminarBtn);
                break;
        }

        nuevaFila.appendChild(nuevaCelda); // Agrega la celda a la fila
    });

    tabla.appendChild(nuevaFila); // Agrega la fila completa a la tabla
}
}

/* Función que crea un input (NO INCLUYE LOS SELECT/COMBOBOX) pero si incluye el checkbox de la IP pública
 * con las propiedades especificadas
 * Es llamada desde agregarFila()
*/
function crearInput(tipo, nombre, clase, evento = null, habilitado = true) {
    const input = document.createElement("input"); // Crea un nuevo elemento de tipo <input> que se añadirá dinámicamente al DOM.
    input.type = tipo; // Tipo del input (text, number, etc.)
    input.name = nombre + "-id-" + contadorFilas; // Nombre del input
    input.id = nombre + "-id-" + contadorFilas; // ID del input
    input.className = clase; // Clase para aplicar estilos
    input.required = true; // Hace que el input sea obligatorio

    // Si el nombre del input es "qty" y su valor está vacío ("") o es igual a "0", establece su valor en 1 por defecto
    if (nombre === "qty" && (input.value === "" || input.value === "0"))
        input.value = 1;


    // Verifica si el valor de la variable `tipo` es igual a "Number". 
    if (tipo === "Number") {
        input.min = 0; // Establece el valor mínimo como 1 para evitar valores negativos
        input.placeholder=0;
        // Validar la entrada para que solo acepte números positivos
        input.addEventListener("input", () => {
            // Elimina cualquier carácter no numérico y asegura que el valor sea >= 0
            input.value = input.value.replace(/[^0-9]/g, ""); // Permite solo dígitos
            //console.log(`Valor actual del input ${nombre}: ${input.value}`); // Muestra el valor que se ingreso
        });
    }

    if (evento) input.addEventListener("input", evento); // Asocia un evento si está definido

    if (!habilitado){
        input.disabled = true; // Deshabilita el input si el habilitado viene en false
        input.value = 0; // Establece el valor predeterminado a 0
    }
    return input; // Devuelve el input creado
}

/* Función que crea un elemento select (NO INCLUYE LOS INPUT) con opciones predefinidas
 * Es llamada desde agregarFila()
*/
function crearSelect(nombre, opciones, evento = null, habilitado=true) {
    const select = document.createElement("select");
    select.name = nombre + "-id-" + contadorFilas; // Nombre del select
    select.id = nombre + "-id-" + contadorFilas; // ID del select
    //console.log(`Creando select: name=${select.name}, id=${select.id}`);

    select.className = "form-control"; // Clase para aplicar estilos
    select.required = true; // Hace que el select sea obligatorio
    select.innerHTML = opciones; // Inserta las opciones en formato HTML

    if (!habilitado) {
        select.disabled = true; // Deshabilita el select si el habilitado viene en false
    }

    /*Si el valor de evento está definido, se utiliza addEventListener para asociar ese evento con el select.
    Específicamente, se está agregando un evento de tipo "change", lo que significa que se ejecutará una función (el valor de evento) cada vez que el valor del select cambie.
    */
    if (evento)
        select.addEventListener("change", evento); // Asocia un evento si está definido

    return select; // Devuelve el select creado
}

/* Función que elimina una fila de la tabla, actualiza los números de fila y recalcula el costo total
 * Es llamada desde agregarFila()
*/
function actualizarYEliminarFila() {
    //console.log("entra a actualizarYEliminarFila()");

    const fila = this.closest("tr"); // Obtiene la fila actual
    contadorFilas--; // Reduce el contador de filas
    fila.remove(); // Elimina la fila del DOM

    // Recalcula y ajusta los números de las filas, los input, select y checkbox
    const filas = document.querySelectorAll("#tabla-dinamica tbody tr"); // Obtiene todas las filas del cuerpo de la tabla
    filas.forEach((fila, indice) => {
        // Actualiza el número de la fila
        fila.cells[0].textContent = indice + 1; // Actualiza la celda de la columna "num" con el índice ajustado

        // Recorre cada celda de la fila
        fila.querySelectorAll("td").forEach((celda, i) => {
            const columna = columnas[i]; // Obtiene el nombre de la columna desde el array 'columnas'
            let inputTemp = null;

            // Verifica si hay un input, select o checkbox en la celda
            if (celda.querySelector('input[type="text"], input[type="number"], input[type="date"]')) {
                inputTemp = celda.querySelector('input');
            } else if (celda.querySelector('select')) {
                inputTemp = celda.querySelector('select');
            } else if (celda.querySelector('input[type="checkbox"]')) {
                inputTemp = celda.querySelector('input[type="checkbox"]');
            }

            // Si el elemento es un input, select o checkbox, actualiza sus atributos 'name' e 'id'
            if (inputTemp) {
                // Actualiza solo el atributo 'name' e 'id' sin cambiar el contenido del value
                inputTemp.name = `${columna}-id-${indice + 1}`;
                inputTemp.id = `${columna}-id-${indice + 1}`;
                //console.log("inputTemp.name:|",inputTemp.name,"|inputTemp.id:|",inputTemp.id);
            }

        });
    });
    // Recalcula el costo total cada vez que se elimina una fila
    actualizarCostoTotal(); // Actualiza el costo total
}
/*==================================================================================================
FIN AGREGAR/ELIMINAR FILAS
==================================================================================================*/




/*==================================================================================================
BOTON GENERAR QUOTE
==================================================================================================*/
function generarQuote() {
    // Obtener y validar los campos de entrada
    const campos = [
        "numero-op", "nombre-op", "nombre-cliente", 
        "account-manager", "costo-total", 
        "u-rack-bellet", "u-rack-liray"
    ];

    const valoresCampos = campos.reduce((acumulador, id) => {
        const valor = document.getElementById(id)?.value || "";
        if (!valor) {
            console.log(`El campo ${id} está vacío.`);
        }
        return { ...acumulador, [id]: valor };
    }, {});

    /*
    if (Object.values(valoresCampos).some((valor) => !valor)) {
        console.log("Por favor, completa todos los campos requeridos.");
        return; // Salir de la función si algún campo está vacío
    }
        */

    console.log("Valores de los campos:", valoresCampos);

    // Procesar las filas dinámicas
    for (let fila = 1; fila <= contadorFilas; fila++) {
        columnas.forEach((columna) => {
            const valor = document.getElementById(`${columna}-qty-id-${fila}`)?.value || "0";
            console.log(`${columna} (fila ${fila}): ${valor}`);
        });
    }
}


import dotenv from 'dotenv'; // Importa dotenv
dotenv.config({ path: '../.env' }); // Carga el archivo .env

import {TronWeb} from 'tronweb'; 

// Función para generar una nueva dirección
const generateAddress = () => {
    const tronWeb = new TronWeb({
        fullHost: 'https://nile.trongrid.io',  // Usando el nodo de prueba de Shasta
        headers: { "TRON-PRO-API-KEY": process.env.TRON_KEY },
        privateKey: process.env.TRON_PRIVATE_KEY
    });

    // Crear cuenta
    tronWeb.createAccount().then(address => {
        console.log("Respuesta completa de la cuenta creada: ", address);
        // Verifica si la dirección está en `address.base58` o en otra propiedad
        if (address.base58) {
            console.log("Dirección creada: ", address.base58);
        } else {
            console.log("No se encontró la propiedad 'base58' en la respuesta.");
        }
    }).catch(error => {
        console.log("Error al crear la cuenta:", error);
    });
};

// Llamar a la función para que se ejecute
generateAddress();
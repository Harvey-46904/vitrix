import { TronLinkAdapter } from '@tronweb3/tronwallet-adapters';

const tronLink = new TronLinkAdapter();

async function connectWallet() {
    try {
        console.log("Activador de función");
        await tronLink.connect();
        const address = tronLink.address;
        console.log('Billetera conectada:', address);
        document.getElementById("walletAddress").innerText = "Conectado: " + address;
        // Puedes actualizar el DOM o realizar otras acciones con la dirección de la billetera
    } catch (error) {
        console.error('Error al conectar la billetera:', error);
    }
}

// Exponer la función al ámbito global para que pueda ser llamada desde el HTML
window.connectWallet = connectWallet;

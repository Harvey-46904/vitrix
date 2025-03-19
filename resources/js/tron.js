import { TronLinkAdapter } from '@tronweb3/tronwallet-adapters';

const tronLink = new TronLinkAdapter();
const USDT_CONTRACT = "TXYZopYRdj2D9XRtbG411XZZ3kM5VkAeBf"; // USDT en TRON
const DEST_CONTRACT = "TBq6tXJfPpbhQEBYnSh4aQyzycceFu15XJ"; //


//usdt

//mycontoract



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
// Función para pagar con USDT al contrato inteligente
async function payWithUSDT(amount, reason) {
    if (!tronLink.connected) {
        console.log("Conéctate primero a la billetera");
        return;
    }

    const tronWeb = window.tronWeb; // TronWeb ya debe estar inyectado por TronLink
    const sender = tronLink.address;

    try {
        const usdtContract = await tronWeb.contract().at(USDT_CONTRACT);
        const contract = await tronWeb.contract().at(DEST_CONTRACT);
        const amountInSun = tronWeb.toSun(amount); // Convierte USDT a 6 decimales

        // 1️⃣ Aprobar el gasto de USDT por parte de tu contrato
        await usdtContract.approve(DEST_CONTRACT, amountInSun).send({
            feeLimit: 100_000_000,
            from: sender
        });

        console.log("Aprobación exitosa. Ahora enviando los fondos...");

        // 2️⃣ Llamar a `receiveUSDT` con el monto y razón
        let tx = await contract.receiveUSDT(amountInSun, reason).send({
            feeLimit: 100_000_000,
            from: sender
        });

        console.log("Pago exitoso. TX:", tx);
        alert("Pago realizado con éxito: " + tx);
    } catch (error) {
        console.error("Error al pagar con USDT:", error);
    }
}
function detectarDispositivo() {
    return /Mobi|Android|iPhone|iPad|iPod/i.test(navigator.userAgent) ? "movil" : "web";
}

document.addEventListener("DOMContentLoaded", async function () {
    const esMovil = detectarDispositivo() === "movil";
    
    if (esMovil) {
        document.getElementById("celular").classList.remove("d-none");
    } else {
        document.getElementById("computador").classList.remove("d-none");

        // Configurar TronLink en PC
        const adapter = new TronLinkAdapter();
        const tronlinkButton = document.getElementById("tronlinkButton");

        tronlinkButton.addEventListener("click", async () => {
            try {
                await adapter.connect();
                console.log("Conectado a TronLink");
            } catch (error) {
                console.error("Error conectando a TronLink:", error);
            }
        });
    }
});

// Exponer funciones al global para usarlas en el HTML
window.connectWallet = connectWallet;
window.payWithUSDT = payWithUSDT;

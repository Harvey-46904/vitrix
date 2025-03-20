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

async function obtenerBilletera() {
    try {
        await tronLink.connect();
        const address = tronLink.address;

        if (address && address.trim() !== "") {
            return address;
        }
    } catch (error) {
        if (error.message.includes("rejected connection")) {
            alert("El usuario rechazó la conexión a TronLink.")
            console.warn("El usuario rechazó la conexión a TronLink.");
        } else {
            alert("Error al conectar con TronLink:")
            console.error("Error al conectar con TronLink:", error);
        }
    }

    return null;
}

document.addEventListener("DOMContentLoaded", async function () {
    const esMovil = detectarDispositivo() === "movil";
    const billetera = await obtenerBilletera();

    if (billetera) {
        console.log("Billetera detectada:", billetera);
        document.getElementById("walletAddress").innerText = "Conectado: " + billetera;
        return; // Si ya hay una billetera conectada, no mostramos botones ni deeplinks
    }
    if (esMovil) {
        document.getElementById("celular").classList.remove("d-none");
        const dappUrl = "https://www.vitrix.io/qr";
        const encodedDappUrl = encodeURIComponent(dappUrl);


        // Abrir TronLink con deeplink
        document.getElementById("btnTronLink").addEventListener("click", function () {
            const params = {
                "url": dappUrl,
                "action": "open",
                "protocol": "tronlink",
                "version": "1.0"
            };
            const deepLink = "tronlinkoutside://pull.activity?param=" + encodeURIComponent(JSON.stringify(params));
            window.location.href = deepLink;
        });

        // Abrir OKX con deeplink
        document.getElementById("btnOKX").addEventListener("click", function () {

            const encodedUrl = "https://www.okx.com/download?deeplink=" + encodeURIComponent("okx://wallet/dapp/url?dappUrl=" + encodeURIComponent(dappUrl));
            window.location.href = encodedUrl;

        });
        // Abrir TokenPocket con deeplink
        document.getElementById("btnTokenPocket").addEventListener("click", function () {
            const deepLink = "tpdapp://open?params=" + encodeURIComponent(JSON.stringify({
                "url": dappUrl,
                "action": "open",
                "protocol": "tpdapp",
                "version": "1.0"
            }));
            window.location.href = deepLink;
        });
    } else {
        document.getElementById("computador").classList.remove("d-none");

        // Configurar TronLink en PC
        const adapter = new TronLinkAdapter();
        const tronlinkButton = document.getElementById("tronlinkButton");

        tronlinkButton.addEventListener("click", async () => {
            try {
                document.getElementById("walletAddress").innerText = "Conectado: " + billetera;
            } catch (error) {
                console.error("Error conectando a TronLink:", error);
            }
        });
    }
});

// Exponer funciones al global para usarlas en el HTML
window.connectWallet = connectWallet;
window.payWithUSDT = payWithUSDT;

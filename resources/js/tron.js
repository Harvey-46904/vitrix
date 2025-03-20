import { TronLinkAdapter } from '@tronweb3/tronwallet-adapters';

const tronLink = new TronLinkAdapter();
const USDT_CONTRACT = "TXYZopYRdj2D9XRtbG411XZZ3kM5VkAeBf"; // USDT en TRON
const DEST_CONTRACT = "TBq6tXJfPpbhQEBYnSh4aQyzycceFu15XJ"; //


//usdt

//mycontoract



async function connectWallet() {
    try {
        console.log("Activador de función");
        //await tronLink.connect();
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
    let billetera="";
    if (!window.tronWeb || !window.tronWeb.defaultAddress.base58) {

        const address = tronLink.address;
        if (address && address.trim() !== "") {
       
            billetera=address;
        }else{
            console.log("Conéctate primero a la billetera");
        }
       
    }else{
        billetera= window.tronWeb.defaultAddress.base58;
    }

 

    const tronWeb = window.tronWeb; // TronWeb ya debe estar inyectado por TronLink
    let sender=null;
    if(billetera!=null){
         sender = billetera;
    }
    console.log("billetera transaccion",sender);
    

    try {
        const usdtContract = await tronWeb.contract().at(USDT_CONTRACT);
        const contract = await tronWeb.contract().at(DEST_CONTRACT);
        const amountInSun = tronWeb.toSun(amount); // Convierte USDT a 6 decimales

        // 1️⃣ Aprobar el gasto de USDT por parte de tu contrato
        let approveTx = await usdtContract.approve(DEST_CONTRACT, amountInSun).send({
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
        // Si TronLink ya está disponible y la billetera está conectada
        if (window.tronWeb && window.tronWeb.defaultAddress.base58) {
            document.getElementById("walletAddress").value  = window.tronWeb.defaultAddress.base58;
            document.getElementById("status").classList.remove("text-danger");
            document.getElementById("status").classList.add("text-success");
            document.getElementById("status").innerText = " Conectado";
            document.getElementById("methodspay").classList.remove("d-none");
            
            return window.tronWeb.defaultAddress.base58;

        }

        // Si no hay billetera conectada, intentamos conectar manualmente
      //  await tronLink.connect();
        const address = tronLink.address;

        if (address && address.trim() !== "") {
            document.getElementById("walletAddress").value  =address;
            document.getElementById("status").classList.remove("text-danger");
            document.getElementById("status").classList.add("text-success");
            document.getElementById("status").innerText = " Conectado";
            document.getElementById("methodspay").classList.remove("d-none");
            return address;
        }
    } catch (error) {
        if (error.message.includes("rejected connection")) {
            console.warn("El usuario rechazó la conexión a TronLink.");
        } else {
            console.error("Error al conectar con TronLink:", error);
        }
    }

    return null;
}

document.addEventListener("DOMContentLoaded", async function () {
    const esMovil = detectarDispositivo() === "movil";
    const billetera = await obtenerBilletera();
    console.log("esta respueta",billetera);
    
    if (billetera) {
        console.log("Billetera detectada:", billetera);
        return; // Si ya hay una billetera conectada, no mostramos botones ni deeplinks
    }
    if (esMovil) {
        document.getElementById("celular").classList.remove("d-none");
        const dappUrl = "https://www.vitrix.io/payforms/";
        const encodedDappUrl = encodeURIComponent(dappUrl);


        // Abrir TronLink con deeplink
        document.getElementById("btnTronLink").addEventListener("click", function (event) {
            const action = event.target.getAttribute("data-action");
            const user = event.target.getAttribute("data-user");
            const id = event.target.getAttribute("data-id");
            const params = {
                "url": dappUrl+action+"/"+user+"/"+id,
                "action": "open",
                "protocol": "tronlink",
                "version": "1.0"
            };
            const deepLink = "tronlinkoutside://pull.activity?param=" + encodeURIComponent(JSON.stringify(params));
            window.location.href = deepLink;
        });

        // Abrir OKX con deeplink
        document.getElementById("btnOKX").addEventListener("click", function (event) {
            const action = event.target.getAttribute("data-action");
            const user = event.target.getAttribute("data-user");
            const id = event.target.getAttribute("data-id");
            let newulr=dappUrl+action+"/"+user+"/"+id;
            const encodedUrl = "https://www.okx.com/download?deeplink=" + encodeURIComponent("okx://wallet/dapp/url?dappUrl=" + encodeURIComponent(newulr));
            window.location.href = encodedUrl;

        });
        // Abrir TokenPocket con deeplink
        document.getElementById("btnTokenPocket").addEventListener("click", function (event) {
            const action = event.target.getAttribute("data-action");
            const user = event.target.getAttribute("data-user");
            const id = event.target.getAttribute("data-id");
            let newulr=dappUrl+action+"/"+user+"/"+id;
            const deepLink = "tpdapp://open?params=" + encodeURIComponent(JSON.stringify({
                "url": newulr,
                "action": "open",
                "protocol": "tpdapp",
                "version": "1.0"
            }));
            window.location.href = deepLink;
        });
    } else {
        document.getElementById("computador").classList.remove("d-none");

       
        const tronlinkButton = document.getElementById("tronlinkButton");

        tronlinkButton.addEventListener("click", async () => {
            try {
                // Validar si TronLink está instalado
                if (!window.tronWeb || !window.tronWeb.defaultAddress) {
                    alert("Primero debes instalar la extensión de TronLink.");
                    return;
                }else{
                       await tronLink.connect();
                    const address = tronLink.address;

                    if (address && address.trim() !== "") {
                        document.getElementById("walletAddress").innerText = "Conectado: " + address;
                      
                    }
                }
            } catch (error) {
                console.error("Error conectando a TronLink:", error);
            }
        });
    }
});

// Exponer funciones al global para usarlas en el HTML
window.connectWallet = connectWallet;
window.payWithUSDT = payWithUSDT;

import { BrowserProvider, Contract, parseUnits } from "ethers";


// Configurar proveedor (Metamask inyecta `window.ethereum`)

const provider = new BrowserProvider(window.ethereum);
 

// Direcciones de contrato en Polygon (asegúrate de reemplazar con las reales en mainnet o Amoy)
const USDT_CONTRACT = "0xc2132D05D31c914a87C6611C10748AEb04B58e8F"; // Dirección del contrato USDT en Polygon
const DEST_CONTRACT = "0xe94D803385e20a0578867854E67B4F5Eb8e5c65e"; // Dirección de tu contrato inteligente
const usdtAbi = ["function approve(address spender, uint256 amount) public returns (bool)"];
const destAbi = ["function receiveUSDT(uint256 amount, string reason, uint256 userId, uint256 id) public"];


function startCountdown(duration) {
    let timeRemaining = duration;
    const countdownElement = document.getElementById("countdown");
    const progressBar = document.getElementById("progress-bar");

    const interval = setInterval(() => {
        const minutes = Math.floor(timeRemaining / 60);
        const seconds = timeRemaining % 60;
        countdownElement.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

        // Actualiza la barra de progreso
        const progressPercentage = (timeRemaining / duration) * 100;
        progressBar.style.width = progressPercentage + "%";

        if (timeRemaining <= 0) {
            clearInterval(interval);
            countdownElement.textContent = "Tiempo agotado";
        }

        timeRemaining--;
    }, 1000);
}
async function connectWallet() {
    try {
        if (!window.ethereum) {
            alert("Metamask no está instalado");
            return;
        }

        // Solicitar acceso a la cuenta de Metamask
        await window.ethereum.request({ method: 'eth_requestAccounts' });

        const provider = new ethers.providers.Web3Provider(window.ethereum);
        const signer = provider.getSigner();
        const address = await signer.getAddress();

        console.log('Billetera conectada:', address);
        document.getElementById("walletAddress").innerText = "Conectado: " + address;

        return { provider, signer, address }; // por si lo necesitas para futuras llamadas
    } catch (error) {
        console.error('Error al conectar la billetera:', error);
    }
}
async function generateInvoice(userId, hashId, reason, amount, status) {
    try {
        const response = await fetch('/generateinvoice', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                user_id: userId,
                hash_id: hashId,
                reason: reason,
                amount: amount,
                status: status
            })
        });

        const data = await response.json(); // Convertimos la respuesta a JSON

        if (!response.ok) {
            throw new Error(data.message || "Error al generar la invoice");
        }

        console.log("✅ Invoice generada:", data);
        return data; // Retorna la respuesta para usarla en otro lado

    } catch (error) {
        console.error("❌ Error:", error);
        return null; // Retorna null si hay error
    }
}
async function UpdateInvoiceStatus(invoice, status) {
    try {
        const response = await fetch('/updateinvoicestatus', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                invoice_id: invoice,
                status: status

            })
        });

        const data = await response.json(); // Convertimos la respuesta a JSON

        if (!response.ok) {
            throw new Error(data.message || "Error al generar la invoice");
        }

        console.log("✅ Invoice generada:", data);
        return data; // Retorna la respuesta para usarla en otro lado

    } catch (error) {
        console.error("❌ Error:", error);
        return null; // Retorna null si hay error
    }
}
async function payWithUSDT(amount, reason, users_id, id) {
    alert("boton precionado para pagar");
    try {
      if (!window.ethereum) {
        alert("Metamask no está instalado");
        return;
      }
  
      const provider = new BrowserProvider(window.ethereum);
      await provider.send("eth_requestAccounts", []); // solicitar permisos
      const signer = await provider.getSigner();
      const address = await signer.getAddress();
      console.log("Billetera transacción:", address);

      const amountInUnits = parseUnits(amount.toString(), 6); // USDT tiene 6 decimales
  
      
  
      const usdt = new Contract(USDT_CONTRACT, usdtAbi, signer);
      const dest = new Contract(DEST_CONTRACT, destAbi, signer);
  
      // 1️⃣ Aprobar USDT
      const approveTx = await usdt.approve(DEST_CONTRACT, amountInUnits);
      await approveTx.wait();
      console.log("Aprobación exitosa:", approveTx.hash);
  
      // 2️⃣ Enviar transacción
      const tx = await dest.receiveUSDT(amountInUnits, reason, users_id, id);
      console.log("Pago enviado. Esperando confirmación... TX:", tx.hash);
  
      const invoice = await generateInvoice(users_id, tx.hash, reason, amount, "Pendiente");
      let invoicevalue;
  
      if (invoice) {
        $("#alertaerror").addClass("d-none");
        $("#alertacorrecto").removeClass("d-none").text("Transacción en proceso de verificación...");
        $("#esperaconfirmacion").removeClass("d-none");
        startCountdown(180);
        $("#hashid").removeClass("d-none").text("Hash: " + tx.hash);
        invoicevalue = invoice.data;
      } else {
        console.log("⚠️ No se pudo generar la invoice.");
        return false;
      }
  
      // 3️⃣ Esperar confirmación
      const receipt = await tx.wait();
      if (receipt.status === 1) {
        console.log("✅ Transacción confirmada:", receipt);
        await UpdateInvoiceStatus(invoicevalue, "SUCCESS");
        $("#alertacorrecto").text("Transacción confirmada correctamente.");
        $("#esperaconfirmacion").addClass("d-none");
        $("#actionfinal").removeClass("d-none").text("Fondos depositados correctamente a su cuenta VITRIX");
      } else {
        console.error("❌ Transacción fallida:", receipt);
        await UpdateInvoiceStatus(invoicevalue, "FAILED");
        $("#alertaerror").removeClass("d-none").text("❌ Ocurrió un error.");
        $("#alertacorrecto").addClass("d-none");
        $("#esperaconfirmacion").addClass("d-none");
        $("#actionfinal").removeClass("d-none").text("Los fondos no fueron depositados");
      }
    } catch (error) {
      console.error("Error al pagar con USDT:", error);
      $("#alertaerror").removeClass("d-none").text("Error: " + error.message);
      $("#alertacorrecto").addClass("d-none");
      $("#hashid").addClass("d-none");
    }
  }
function detectarDispositivo() {
    return /Mobi|Android|iPhone|iPad|iPod/i.test(navigator.userAgent) ? "movil" : "web";
}

async function obtenerBilletera() {

   
    
    try {
        if (!window.ethereum) {
            $("#walleterror").removeClass("d-none").text("Metamask no está instalado.");
            return null;
        }


        await provider.send("eth_requestAccounts", []);
        const signer = await provider.getSigner();
        const address = await signer.getAddress();

        document.getElementById("walletAddress").value = address;
        document.getElementById("status").classList.remove("text-danger");
        document.getElementById("status").classList.add("text-success");
        document.getElementById("status").innerText = " Conectado";
        document.getElementById("methodspay").classList.remove("d-none");

        return address;

    } catch (error) {
        if (error.code === 4001) {
            $("#walleterror").removeClass("d-none").text("El usuario rechazó la conexión a Metamask.");
            console.warn("El usuario rechazó la conexión a Metamask.");
        } else {
            $("#walleterror").removeClass("d-none").text("Error al conectar con Metamask.");
            console.error("Error al conectar con Metamask:", error);
        }
    }

    return null;
}

document.addEventListener("DOMContentLoaded", async function () {
    alert("cargo");
    const esMovil = detectarDispositivo() === "movil";
    const billetera = await obtenerBilletera(); // la versión que ya te pasé
    

    if (billetera) {
        console.log("Billetera detectada:", billetera);
        return; // Ya conectado
    }

    const dappUrl = "https://www.vitrix.io/payforms/";
    
    if (esMovil) {
        document.getElementById("celular").classList.remove("d-none");

        // Trust Wallet (usa MetaMask-compatible Deeplink)
        document.getElementById("btnTrustWallet").addEventListener("click", function (event) {
            const action = event.target.getAttribute("data-action");
            const user = event.target.getAttribute("data-user");
            const id = event.target.getAttribute("data-id");
            const newUrl = dappUrl + action + "/" + user + "/" + id + "?deeplink=1";
            const deepLink = "https://link.trustwallet.com/open_url?coin_id=60&url=" + encodeURIComponent(newUrl);
            window.location.href = deepLink;
        });

        // OKX
        document.getElementById("btnOKX").addEventListener("click", function (event) {
            const action = event.target.getAttribute("data-action");
            const user = event.target.getAttribute("data-user");
            const id = event.target.getAttribute("data-id");
            const newUrl = dappUrl + action + "/" + user + "/" + id + "?deeplink=1";
            const deepLink = "https://www.okx.com/download?deeplink=" + encodeURIComponent("okx://wallet/dapp/url?dappUrl=" + encodeURIComponent(newUrl));
            window.location.href = deepLink;
        });

        // TokenPocket
        document.getElementById("btnTokenPocket").addEventListener("click", function (event) {
            const action = event.target.getAttribute("data-action");
            const user = event.target.getAttribute("data-user");
            const id = event.target.getAttribute("data-id");
            const newUrl = dappUrl + action + "/" + user + "/" + id + "?deeplink=1";
            const deepLink = "tpdapp://open?params=" + encodeURIComponent(JSON.stringify({
                url: newUrl,
                action: "open",
                protocol: "tpdapp",
                version: "1.0"
            }));
            window.location.href = deepLink;
        });

    } else {
        // PC / Escritorio
        document.getElementById("computador").classList.remove("d-none");

        const metamaskButton = document.getElementById("metamaskButton");

        metamaskButton.addEventListener("click", async () => {
            try {
                if (!window.ethereum) {
                    alert("Primero debes instalar Metamask.");
                    return;
                }

                const provider = new ethers.providers.Web3Provider(window.ethereum);
                await provider.send("eth_requestAccounts", []);
                const signer = provider.getSigner();
                const address = await signer.getAddress();

                document.getElementById("walletAddress").innerText = "Conectado: " + address;

            } catch (error) {
                $("#walleterror").removeClass("d-none").text("Error conectando a Metamask.");
                console.error("Error conectando a Metamask:", error);
            }
        });
    }
});


window.connectWallet = connectWallet;
window.payWithUSDT = payWithUSDT;
/*window.getUSDTBalance = getUSDTBalance;
window.batchTransferUSDT = batchTransferUSDT;*/
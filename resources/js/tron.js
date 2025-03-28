import { TronLinkAdapter } from '@tronweb3/tronwallet-adapters';

const tronLink = new TronLinkAdapter();
const USDT_CONTRACT = "TXYZopYRdj2D9XRtbG411XZZ3kM5VkAeBf"; // USDT en TRON
const DEST_CONTRACT = "TFJJyXqcm2njrUQi7Ss3XiZjZEEeePKaMg"; //


//usdt

//mycontoract

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
async function payWithUSDT(amount, reason, users_id,id) {
    let billetera = "";
    if (!window.tronWeb || !window.tronWeb.defaultAddress.base58) {
        const address = tronLink.address;
        if (address && address.trim() !== "") {
            billetera = address;
        } else {
            console.log("Conéctate primero a la billetera");
            return;
        }
    } else {
        billetera = window.tronWeb.defaultAddress.base58;
    }

    const tronWeb = window.tronWeb;
    let sender = billetera ? billetera : null;
    if (!sender) return console.error("No se pudo obtener la billetera");

    console.log("Billetera transacción:", sender);

    try {
        const usdtContract = await tronWeb.contract().at(USDT_CONTRACT);
        const contract = await tronWeb.contract().at(DEST_CONTRACT);
        const amountInSun = tronWeb.toSun(amount); // Convierte USDT a 6 decimales

        // 1️⃣ Aprobar el gasto de USDT
        let approveTx = await usdtContract.approve(DEST_CONTRACT, amountInSun).send({
            feeLimit: 100_000_000,
            from: sender
        });

        console.log("Aprobación exitosa. TX:", approveTx);

        // 2️⃣ Llamar a `receiveUSDT`
        let tx = await contract.receiveUSDT(amountInSun, reason,users_id,id).send({
            feeLimit: 100_000_000,
            from: sender
        });

        console.log("Pago enviado. Esperando confirmación... TX:", tx);
        const invoice = await generateInvoice(users_id, tx, reason, amount, "Pendiente");
        let invoicevalue;

        if (invoice) {
            $("#alertaerror").addClass("d-none");
            $("#alertacorrecto").removeClass("d-none").text("Transacción en proceso de verificación...");
            $("#esperaconfirmacion").removeClass("d-none");
            startCountdown(180);
            $("#hashid").removeClass("d-none").text("Hash: " + tx);
            invoicevalue=invoice.data;
        } else {
            console.log("⚠️ No se pudo generar la invoice.");
            return false;
        }

        // 3️⃣ Esperar confirmación en la blockchain
        let confirmed = false;
        while (!confirmed) {
            await new Promise(resolve => setTimeout(resolve, 5000)); // Esperar 5 segundos

            let txInfo = await tronWeb.trx.getTransactionInfo(tx);

            if (txInfo && txInfo.receipt) {
                console.log("🔍 Estado de la transacción:", txInfo.receipt.result);

                if (txInfo.receipt.result === "SUCCESS") {
                    confirmed = true;
                    
                    console.log("✅ Transacción confirmada:", txInfo);
                    const invoicestatus = await   UpdateInvoiceStatus(invoicevalue,txInfo.receipt.result) 
                   
                    
                    $("#alertacorrecto").text("Transacción confirmada correctamente.");
                    $("#esperaconfirmacion").addClass("d-none");

                    $("#actionfinal").removeClass("d-none").text("Fondos depositados Correctamente a su cuenta VITRIX");
                    
                } else if (txInfo.receipt.result === "REVERT" || txInfo.receipt.result === "FAILED") {
                    console.error("❌ Transacción fallida:", txInfo);
                    const invoicestatus = await   UpdateInvoiceStatus(invoicevalue,txInfo.receipt.result) 
                    $("#alertaerror").removeClass("d-none").text("❌ Ocurrio un error.");
                    $("#alertacorrecto").addClass("d-none");
                    $("#esperaconfirmacion").addClass("d-none");
                    $("#actionfinal").removeClass("d-none").text("Los fondos no fueron depositados");
                    confirmed = true; // Salimos del bucle ya que falló
                }
            }
        }
    } catch (error) {
        console.error("Error al pagar con USDT:", error);
        $("#alertaerror").removeClass("d-none").text("Error: " + error);
        $("#alertacorrecto").addClass("d-none");
        $("#hashid").addClass("d-none");
    }
}
function detectarDispositivo() {
    return /Mobi|Android|iPhone|iPad|iPod/i.test(navigator.userAgent) ? "movil" : "web";
}




async function UpdateInvoiceStatus(invoice,status) {
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

async function blockchainvitrix(hash,pay_moment) {
    try {
        const response = await fetch('/blockchainvitrix', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                hash: hash,
                pay_moment:pay_moment
            })
        });

        const data = await response.json(); // Convertimos la respuesta a JSON

        if (!response.ok) {
            throw new Error(data.message || "Error al generar la invoice");
        }

        console.log("✅ PAGARE  generada:", data);
        return data; // Retorna la respuesta para usarla en otro lado

    } catch (error) {
        console.error("❌ Error:", error);
        return null; // Retorna null si hay error
    }
}

async function procesadorpagares(hash,id) {
    try {
        const response = await fetch('/procesadorpagares', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                hash: hash,
                id: id
            })
        });

        const data = await response.json(); // Convertimos la respuesta a JSON

        if (!response.ok) {
            throw new Error(data.message || "Error al generar la invoice");
        }

        console.log("✅ PAGARE  generada:", data);
        return data; // Retorna la respuesta para usarla en otro lado

    } catch (error) {
        console.error("❌ Error:", error);
        return null; // Retorna null si hay error
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
async function obtenerBilletera() {
    try {
        // Si TronLink ya está disponible y la billetera está conectada
        if (window.tronWeb && window.tronWeb.defaultAddress.base58) {
            document.getElementById("walletAddress").value = window.tronWeb.defaultAddress.base58;
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
            document.getElementById("walletAddress").value = address;
            document.getElementById("status").classList.remove("text-danger");
            document.getElementById("status").classList.add("text-success");
            document.getElementById("status").innerText = " Conectado";
            document.getElementById("methodspay").classList.remove("d-none");
            return address;
        }
    } catch (error) {
        if (error.message.includes("rejected connection")) {
            $("#walleterror").removeClass("d-none").text("El usuario rechazó la conexión a TronLink.");
            console.warn("El usuario rechazó la conexión a TronLink.");
        } else {
            $("#walleterror").removeClass("d-none");
            console.error("Error al conectar con TronLink:", error);
        }
    }

    return null;
}

async function getUSDTBalance() {
    try {
        if (!window.tronWeb) {
            console.log("Conéctate primero a TronLink.");
            return;
        }

        const tronWeb = window.tronWeb;
        const contract = await tronWeb.contract().at(DEST_CONTRACT);
        const balance = await contract.getUSDTBalance().call();

        const balanceInUSDT = tronWeb.fromSun(balance); // Convertir a formato legible (6 decimales)
        console.log("Balance USDT del contrato:", balanceInUSDT);
        
        $("#usdtBalance").text(`Balance: ${balanceInUSDT} USDT`); // Mostrar en HTML
    } catch (error) {
        console.error("Error al obtener balance USDT:", error);
    }
}
async function batchTransferUSDT(recipients, amounts, transactionIds,totality) {
    try {
        if (!window.tronWeb || !window.tronWeb.ready) {
            alert("Conéctate a TronLink primero.");
            return;
        }

        const contractAddress = DEST_CONTRACT; // Dirección del contrato
        const tronWeb = window.tronWeb;
        const contract = await tronWeb.contract().at(contractAddress);

        // Enviar la transacción
        let tx = await contract.batchTransferUSDT(recipients, amounts, transactionIds).send({
            feeLimit: 100000000, // 100 TRX
        });

        console.log("⏳ Transacción enviada:", tx);
        const invoicestatus = await  blockchainvitrix(tx,totality) 
        let blockid;
        if(invoicestatus){
             blockid=invoicestatus.data;
        }
        console.log("⌛ Esperando confirmación...");

        // 🔥 Esperar a que la transacción se confirme en la blockchain
        let receipt = null;
        while (!receipt || !receipt.receipt) {
            await new Promise((resolve) => setTimeout(resolve, 5000)); // Esperar 3 segundos
            receipt = await tronWeb.trx.getTransactionInfo(tx);
        }

        console.log("✅ Transacción confirmada:", receipt);
        if(receipt){
             const processpagos = await  procesadorpagares(tx,blockid) 
             if(processpagos){
                return true;
                
             }
           

        }
        
    } catch (error) {
        console.error("❌ Error en la transacción:", error);
        return false;
    }
}

document.addEventListener("DOMContentLoaded", async function () {
    const esMovil = detectarDispositivo() === "movil";
    const billetera = await obtenerBilletera();
    console.log("esta respueta", billetera);

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
                "url": dappUrl + action + "/" + user + "/" + id,
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
            let newulr = dappUrl + action + "/" + user + "/" + id;
            const encodedUrl = "https://www.okx.com/download?deeplink=" + encodeURIComponent("okx://wallet/dapp/url?dappUrl=" + encodeURIComponent(newulr));
            window.location.href = encodedUrl;

        });
        // Abrir TokenPocket con deeplink
        document.getElementById("btnTokenPocket").addEventListener("click", function (event) {
            const action = event.target.getAttribute("data-action");
            const user = event.target.getAttribute("data-user");
            const id = event.target.getAttribute("data-id");
            let newulr = dappUrl + action + "/" + user + "/" + id;
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
                } else {
                    await tronLink.connect();
                    const address = tronLink.address;

                    if (address && address.trim() !== "") {
                        document.getElementById("walletAddress").innerText = "Conectado: " + address;

                    }
                }
            } catch (error) {
                $("#walleterror").removeClass("d-none");
                console.error("Error conectando a TronLink:", error);
            }
        });
    }
});

// Exponer funciones al global para usarlas en el HTML
window.connectWallet = connectWallet;
window.payWithUSDT = payWithUSDT;
window.getUSDTBalance = getUSDTBalance;
window.batchTransferUSDT = batchTransferUSDT;

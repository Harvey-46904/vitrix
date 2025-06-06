import { BrowserProvider, Contract, parseUnits ,formatUnits } from "ethers";


// Configurar proveedor (Metamask inyecta `window.ethereum`)


 

// Direcciones de contrato en Polygon (asegúrate de reemplazar con las reales en mainnet o Amoy)
const USDT_CONTRACT = "0xc2132D05D31c914a87C6611C10748AEb04B58e8F"; // Dirección del contrato USDT en Polygon
const DEST_CONTRACT = "0x8DEE78F5525df489b32060Be79021CaE0d283f93"; // Dirección de tu contrato inteligente
//const DEST_CONTRACT = "0xe94D803385e20a0578867854E67B4F5Eb8e5c65e";

const usdtAbi = ["function approve(address spender, uint256 amount) public returns (bool)"];
//const destAbi = ["function receiveUSDT(uint256 amount, string reason, uint256 userId, uint256 id) public"];
const destAbi =[
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "_usdtTokenAddress",
				"type": "address"
			},
			{
				"internalType": "address",
				"name": "master",
				"type": "address"
			}
		],
		"stateMutability": "nonpayable",
		"type": "constructor"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": false,
				"internalType": "uint256[]",
				"name": "successfulTransactions",
				"type": "uint256[]"
			},
			{
				"indexed": false,
				"internalType": "uint256[]",
				"name": "failedTransactions",
				"type": "uint256[]"
			}
		],
		"name": "BatchTransferCompleted",
		"type": "event"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": true,
				"internalType": "address",
				"name": "sender",
				"type": "address"
			},
			{
				"indexed": false,
				"internalType": "uint256",
				"name": "amount",
				"type": "uint256"
			},
			{
				"indexed": false,
				"internalType": "string",
				"name": "reason",
				"type": "string"
			},
			{
				"indexed": false,
				"internalType": "uint256",
				"name": "idus",
				"type": "uint256"
			},
			{
				"indexed": false,
				"internalType": "uint256",
				"name": "idmeta",
				"type": "uint256"
			}
		],
		"name": "ReceivedUSDT",
		"type": "event"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": true,
				"internalType": "address",
				"name": "recipient",
				"type": "address"
			},
			{
				"indexed": false,
				"internalType": "uint256",
				"name": "amount",
				"type": "uint256"
			}
		],
		"name": "Withdrawal",
		"type": "event"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "newOwner",
				"type": "address"
			},
			{
				"internalType": "address",
				"name": "newUSDT",
				"type": "address"
			}
		],
		"name": "SettingsOwner",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "address[]",
				"name": "recipients",
				"type": "address[]"
			},
			{
				"internalType": "uint256[]",
				"name": "amounts",
				"type": "uint256[]"
			},
			{
				"internalType": "uint256[]",
				"name": "transactionIds",
				"type": "uint256[]"
			}
		],
		"name": "batchTransferUSDT",
		"outputs": [
			{
				"internalType": "uint256[]",
				"name": "",
				"type": "uint256[]"
			},
			{
				"internalType": "uint256[]",
				"name": "",
				"type": "uint256[]"
			}
		],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"inputs": [],
		"name": "getUSDTBalance",
		"outputs": [
			{
				"internalType": "uint256",
				"name": "",
				"type": "uint256"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [],
		"name": "owner",
		"outputs": [
			{
				"internalType": "address",
				"name": "",
				"type": "address"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "uint256",
				"name": "amount",
				"type": "uint256"
			},
			{
				"internalType": "string",
				"name": "reason",
				"type": "string"
			},
			{
				"internalType": "uint256",
				"name": "idus",
				"type": "uint256"
			},
			{
				"internalType": "uint256",
				"name": "idmeta",
				"type": "uint256"
			}
		],
		"name": "receiveUSDT",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "newOwner",
				"type": "address"
			},
			{
				"internalType": "address",
				"name": "newMdevos",
				"type": "address"
			},
			{
				"internalType": "address",
				"name": "newUSDT",
				"type": "address"
			}
		],
		"name": "uSettings",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"inputs": [],
		"name": "usdtTokenAddress",
		"outputs": [
			{
				"internalType": "address",
				"name": "",
				"type": "address"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "uint256",
				"name": "amount",
				"type": "uint256"
			}
		],
		"name": "withdrawUSDT",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
	}
];

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

function detectarDispositivo() {
    return /Mobi|Android|iPhone|iPad|iPod/i.test(navigator.userAgent) ? "movil" : "web";
}

async function obtenerBilletera() {
	
    try {
        if (!window.ethereum) {
            $("#walleterror").removeClass("d-none").text("Metamask no está instalado.");
            return null;
        }

		await window.ethereum.request({ method: 'eth_requestAccounts' });
        const provider = new BrowserProvider(window.ethereum);

	
        //await provider.send("eth_requestAccounts", []);
        const signer = await provider.getSigner();
        const address = await signer.getAddress();

        document.getElementById("walletAddress").value = address;
        document.getElementById("status").classList.remove("text-danger");
        document.getElementById("status").classList.add("text-success");
        document.getElementById("status").innerText = " Conectado";
        document.getElementById("methodspay").classList.remove("d-none");
		document.getElementById("contend_meta_pc").classList.add("d-none");
		
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

async function getUSDTBalance() {
    try {
        if (!window.ethereum) {
            console.log("Conéctate primero con Metamask.");
            return;
        }
        await window.ethereum.request({ method: 'eth_requestAccounts' });
        const provider = new BrowserProvider(window.ethereum);
        const contract = new Contract(DEST_CONTRACT, destAbi, provider);
        const balance = await contract.getUSDTBalance();
        const balanceInUSDT = formatUnits(balance, 6); // USDT usa 6 decimales
        console.log("Balance USDT del contrato:", balanceInUSDT);
        document.getElementById("usdtBalance").textContent = `Balance: ${balanceInUSDT} USDT`;
    } catch (error) {
        console.error("Error al obtener balance USDT:", error);
    }
}



async function blockchainvitrix(hash, pay_moment,transactionIds) {
    try {
        const response = await fetch('/blockchainvitrix', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                hash: hash,
                pay_moment: pay_moment,
                transaction_ids: transactionIds.join(',')
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

async function procesadorpagares(hash, id) {
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

async function payWithUSDT(amount, reason, users_id, id) {
    
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

	    // Extraer la razón si está disponible
		let reason = error?.reason || error?.error?.reason || "Error desconocido";
    
		// Mostrarlo en tu alerta
		$("#alertaerror").removeClass("d-none").text("Error: " + reason);
     
      $("#alertacorrecto").addClass("d-none");
      $("#hashid").addClass("d-none");
    }
  }
async function batchTransferUSDT(recipients, amounts, transactionIds, totality) {
    try {
        if (!window.ethereum) {
            alert("Metamask no está instalado.");
            return;
        }
		const provider = new BrowserProvider(window.ethereum);
        //const provider = new ethers.BrowserProvider(window.ethereum);
        await provider.send("eth_requestAccounts", []);
        const signer = await provider.getSigner();
        const address = await signer.getAddress();
        console.log("Billetera:", address);

       
		const destContract = new Contract(DEST_CONTRACT, destAbi, signer);
        // Asegúrate de que los montos están en formato correcto (BigInt con 6 decimales)
		
        const formattedAmounts = amounts;

		console.log("saldos",formattedAmounts);
		
        const tx = await destContract.batchTransferUSDT(recipients, formattedAmounts, transactionIds);
        console.log("⏳ Transacción enviada:", tx.hash);

        const invoicestatus = await blockchainvitrix(tx.hash, totality,transactionIds);
        let blockid = invoicestatus?.data;

        console.log("⌛ Esperando confirmación...");
        const receipt = await tx.wait();

        if (receipt.status === 1) {
            console.log("✅ Transacción confirmada:", receipt);
            const process = await procesadorpagares(tx.hash, blockid);
            return process ? true : false;
        } else {
            console.error("❌ Transacción fallida:", receipt);
            return false;
        }

    } catch (error) {
        console.error("❌ Error en la transacción:", error);
        return false;
    }
}

async function RetiroTransferUSDT(amount) {
    try {
        if (!window.ethereum) {
            alert("Metamask no está instalado.");
            return;
        }
		const provider = new BrowserProvider(window.ethereum);
        //const provider = new ethers.BrowserProvider(window.ethereum);
        await provider.send("eth_requestAccounts", []);
        const signer = await provider.getSigner();
        const address = await signer.getAddress();
        console.log("Billetera:", address);

       
		const destContract = new Contract(DEST_CONTRACT, destAbi, signer);
        // Asegúrate de que los montos están en formato correcto (BigInt con 6 decimales)
		
       
        const amountInUnits = parseUnits(amount.toString(), 6); // USDT tiene 6 decimales
		console.log("saldo de retiros",amountInUnits);
		
        const tx = await destContract.withdrawUSDT(amountInUnits);
        console.log("⏳ Transacción enviada:", tx.hash);


        console.log("⌛ Esperando confirmación...");
        const receipt = await tx.wait();

        if (receipt.status === 1) {
            console.log("✅ Transacción confirmada:", receipt);
            return true;
        } else {
            console.error("❌ Transacción fallida:", receipt);
            return false;
        }

    } catch (error) {
        console.error("❌ Error en la transacción:", error);
        return false;
    }
}
document.addEventListener("DOMContentLoaded", async function () {
	const esMovil = detectarDispositivo() === "movil";
	
	if (esMovil) {
		console.log("celular");
		if (window.ethereum) {
			await obtenerBilletera();
            return null;
        }
        document.getElementById("celular").classList.remove("d-none");
		const dappUrl = "https://www.vitrix.io/payforms/";

		//metamask
		document.getElementById("btnMetamaskMobile").addEventListener("click", function (event) {
			const action = event.target.getAttribute("data-action");
			const user = event.target.getAttribute("data-user");
			const id = event.target.getAttribute("data-id");
			const newUrl = dappUrl + action + "/" + user + "/" + id + "?deeplink=1";
		
			// Crear deeplink para MetaMask Mobile
			const deepLink = "https://metamask.app.link/dapp/" + newUrl.replace(/^https?:\/\//, '');
		
			// Abrir MetaMask Mobile
			window.location.href = deepLink;
		});

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
		console.log("PC ESCRITORIO");
        // PC / Escritorio
        document.getElementById("computador").classList.remove("d-none");

       
    }
  
});


window.connectWallet = connectWallet;
window.payWithUSDT = payWithUSDT;
window.getUSDTBalance = getUSDTBalance;
window.obtenerBilletera = obtenerBilletera;
window.RetiroTransferUSDT = RetiroTransferUSDT;

window.batchTransferUSDT = batchTransferUSDT;
import Echo from 'laravel-echo';
import  Pusher from 'pusher-js';
import { WalletConnectWallet, WalletConnectChainID } from "@tronweb3/walletconnect-tron";
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true,
    wsHost: window.location.hostname,
    wsPort: 6001,
    wssPort: 6001,
    forceTLS: true,
    disableStats: true,
});


const wallet = new WalletConnectWallet({
    network: WalletConnectChainID.Mainnet, 
    options: {
        relayUrl: "wss://relay.walletconnect.com",
        projectId: "", // Opcional, si no tienes uno puedes dejarlo vacío
        metadata: {
            name: "Vitrix Casino",
            description: "Apuesta con USDT en la red TRON",
            url: "https://vitrix.io",
            icons: ["https://vitrix.io//storage/themes/October2024/bnwl1WSwXAvMk33o97Pq.png"]
        }
    }
});

window.connectWallet = async function () {
    try {
        await wallet.connect();
        document.getElementById("walletAddress").innerText = "Conectado: " + wallet.address;
    } catch (error) {
        console.error("Error al conectar la billetera:", error);
    }
};
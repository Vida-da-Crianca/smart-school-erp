  import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.9/firebase-app.js";
  import { getMessaging, onBackgroundMessage } from "https://www.gstatic.com/firebasejs/9.6.9/firebase-messaging-sw.js";

  // Inicializar o fireBase
  const firebaseApp = initializeApp({ 
    apiKey: "AIzaSyAZe5zs4dcuwn_P_k-RzrJCJQVj9RrghIs",
    authDomain: "smart-school-erp-722f3.firebaseapp.com",
    projectId: "smart-school-erp-722f3",
    storageBucket: "smart-school-erp-722f3.appspot.com",
    messagingSenderId: "215966691514",
    appId: "1:215966691514:web:e8e18d2fd31a4a5873d283",
    measurementId: "G-HTE6WHJ3WE"
  });
  
  const messaging = getMessaging(firebaseApp);

  onBackgroundMessage(messaging, (payload) => {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
  })

  self.addEventListener('install', (e) => {
    console.log(`[Firebase Service Worker] Instalado`);
    self.skipWaiting(); //Forçar instalação do sistema MAJ
  });
  
  self.addEventListener('activate', (e) => {
    console.log(`[Firebase Service Worker] Ativado.`);
  });
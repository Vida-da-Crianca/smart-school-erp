importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js');
firebase.initializeApp({
    apiKey: "AIzaSyAZe5zs4dcuwn_P_k-RzrJCJQVj9RrghIs",
    authDomain: "smart-school-erp-722f3.firebaseapp.com",
    projectId: "smart-school-erp-722f3",
    storageBucket: "smart-school-erp-722f3.appspot.com",
    messagingSenderId: "215966691514",
    appId: "1:215966691514:web:e8e18d2fd31a4a5873d283",
    measurementId: "G-HTE6WHJ3WE"
});
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
  console.log(
    "[firebase-messaging-sw.js] Received background message ",
    payload,
  );
  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    body: payload.notification.body,
    click_action: payload.notification.click_action
  };

  return self.registration.showNotification(
    notificationTitle,
    notificationOptions,
  );
});
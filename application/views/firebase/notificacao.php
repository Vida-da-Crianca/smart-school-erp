
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.9/firebase-app.js";
    import { getMessaging, getToken, onMessage } from "https://www.gstatic.com/firebasejs/9.6.9/firebase-messaging.js";

    const cfg = {
        apiKey: "AIzaSyAZe5zs4dcuwn_P_k-RzrJCJQVj9RrghIs",
        authDomain: "smart-school-erp-722f3.firebaseapp.com",
        projectId: "smart-school-erp-722f3",
        storageBucket: "smart-school-erp-722f3.appspot.com",
        messagingSenderId: "215966691514",
        appId: "1:215966691514:web:e8e18d2fd31a4a5873d283",
        measurementId: "G-HTE6WHJ3WE"
    };
    
    const fireApp = initializeApp(cfg);
    const messaging = getMessaging(fireApp);

    onMessage(messaging, (payload) => {
        console.log('[Firebase] Recebido mensagem lado do cliente ', payload);
        if (!(self.Notification && self.Notification.permission === 'granted')) {
            return;
        }

        Notification.requestPermission().then((permission) => {
            if(permission === "granted"){
                var notification = new Notification(payload.notification.title, { 
                    body: payload.notification.body, 
                    icon:  '',
                    badge: '',
                    tag: 'renotify',
                    renotify: true,
                });
                notification.onclick = function(){
                    console.log(console.log(this));
                };
            }
        })

    });

    if('serviceWorker' in navigator){
        navigator.serviceWorker.register('<?=base_url() ?>firebase-service-work.js', { type: 'module' }).then(registration => {
            console.log('[Firebase] iniciado');

            getToken(messaging, { 
				vapidKey: "BEHKWUEqhGGS0bYEWUnim2ItjXG7Od21NKS8XL8wOIV33H4zxBiR__hQ1UH2FdstAe6ifeZw6zQyOm4cbjbP3kY" ,
			    serviceWorkerRegistration: registration
			})
            .then(function(token){

                console.log(token);
                
                var _data = new FormData();
                _data.append('token', token);

                fetch('<?=base_url()?>sw/token', {
                    method: 'POST',
                    body: _data
                }).then( response => response.json())
                .then(data => {
                    console.log(data);
                });
            })
            .catch(function(err) {
                console.error('[Firebase] Erro na tentativa de salvar o token. ', err);
            });
        })
        .catch(error => {
            console.error('[Firebase] Erro: ', error);
        });
    }
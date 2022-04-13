var firebaseConfig = {
    apiKey: "AIzaSyAZe5zs4dcuwn_P_k-RzrJCJQVj9RrghIs",
    authDomain: "smart-school-erp-722f3.firebaseapp.com",
    projectId: "smart-school-erp-722f3",
    storageBucket: "smart-school-erp-722f3.appspot.com",
    messagingSenderId: "215966691514",
    appId: "1:215966691514:web:e8e18d2fd31a4a5873d283",
    measurementId: "G-HTE6WHJ3WE"
};
firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();
function notify(){
    $.confirm({
        theme: 'dark',
        columnClass: 'medium',
        title: 'Exibir Notificações',
        content: 'Por favor, permita que nosso site envie notificações para você, caso esta janela persista, siga o tutorial abaixo.' +
        '<div class="text-center"><br><br><h3>Tutorial Navegador Mobile</h3><br>1. Toque no cadeado ao lado da url: <br><img src="' + baseurl + '/backend/dist/img/tut_1.png"/>' +
        '<br>2. Depois toque em Permissões.<br><img src="' + baseurl + '/backend/dist/img/tutm_1.png"/> <br>3. Toque em Notificações: <br><img src="' + baseurl + '/backend/dist/img/tutm_2.png"/> ' +
        '<br>4. E por fim, toque no botão de liga/desliga: <br><img src="' + baseurl + '/backend/dist/img/tutm_3.png"/><br><br><h3>Tutorial Navegador WEB</h3><br>1. Clique no cadeado ao lado da url: <br><img src="' + baseurl + '/backend/dist/img/tut_1.png"/>' +
        '<br>2. Depois clique no botão de liga/desliga, igual na imagem (destacado em vermelho).<br><img src="' + baseurl + '/backend/dist/img/tut_2.png"/><br>3. Pronto, feche esta janela.' +
        '</div>',
        buttons: {
            'Entendido': function(){
                initFirebaseMessagingRegistration();
            }
        }
    });
}
function initFirebaseMessagingRegistration() {
        messaging
        .requestPermission()
        .then(function () {
            return messaging.getToken()
        })
        .then(function(token) {
            console.log(token);
            $.ajax({
                url: '<?=base_url()?>sw/token',
                type: 'POST',
                data: {
                    token: token
                },
                dataType: 'JSON',
                success: function (response) {
                    console.log('Token salvado com sucesso.');
                },
                error: function (err) {
                    notify();
                    console.log('User Chat Token Error'+ err);
                },
            });
        }).catch(function (err) {
            notify();
            console.log('User Chat Token Error'+ err);
        });
 }
messaging.onMessage(function(payload) {
    const noteTitle = payload.notification.title;
    const noteOptions = {
        body: payload.notification.body,
        icon: payload.notification.icon,
    };
    new Notification(noteTitle, noteOptions);
});

$(document).ready(function(){
    initFirebaseMessagingRegistration();
});
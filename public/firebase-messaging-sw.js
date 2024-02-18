// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: 'AIzaSyDjD9dHVTVYEvHf1R_hV0QyGtlLgaIHmm4',
    authDomain: 'elwada7-bf529.firebaseapp.com',
    databaseURL: 'https://project-id.firebaseio.com',
    projectId: 'elwada7-bf529',
    storageBucket: 'elwada7-bf529.appspot.com',
    messagingSenderId: '845913731989',
    appId: '1:845913731989:web:0bd366a102b4292d4bfc9c',
    measurementId: 'G-FCCWE06R5L',
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    console.log("Message received.", payload);
    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png",
    };
    return self.registration.showNotification(
        title,
        options,
    );
});

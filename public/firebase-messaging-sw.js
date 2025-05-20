importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
   
firebase.initializeApp({
  apiKey: "AIzaSyDvgKr0qOwKBQnrMoPS9_3riCnsN4vro5k",
  authDomain: "ekios-probolinggo.firebaseapp.com",
  projectId: "ekios-probolinggo",
  storageBucket: "ekios-probolinggo.firebasestorage.app",
  messagingSenderId: "811602678526",
  appId: "1:811602678526:web:78cd3691b1ee2b2b1f0baf",
  measurementId: "G-LFFW9BRGWQ"
});
  
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({data:{title,body,icon}}) {
    console.log(title);
    return self.registration.showNotification(title,{body,icon});
});
importScripts('https://www.gstatic.com/firebasejs/11.3.1/firebase-app-compat.js'); // Or your Firebase version
importScripts('https://www.gstatic.com/firebasejs/11.3.1/firebase-messaging-compat.js'); // Or your Firebase version



const firebaseConfig = {
  apiKey: "AIzaSyCuu5HyjJ0zPma-jwvxlLcNrhrpubyftMk",
  authDomain: "alarbagi-8c44a.firebaseapp.com",
  databaseURL: "https://alarbagi-8c44a-default-rtdb.europe-west1.firebasedatabase.app",
  projectId: "alarbagi-8c44a",
  storageBucket: "alarbagi-8c44a.firebasestorage.app",
  messagingSenderId: "524130844148",
  appId: "1:524130844148:web:3597ca019ef052a6934da1"
};


firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();

messaging.onBackgroundMessage(function (payload) {
  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    body: payload.notification.body,
    icon: payload.notification.icon,
  };
  // self.registration.showNotification(notificationTitle, notificationOptions);
});

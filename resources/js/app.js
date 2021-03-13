require('./bootstrap');

window.Vue = require('vue');
import Vue from 'vue'

import videoPage from './Components/VideoComponent';
import reciverEmail from './Components/ReciverEmailComponent';
import reciverPhone from './Components/ReciverPhoneComponent';
import passwordChange from './Components/ChangePasswordComponent';

const app = new Vue({
    el: '#main',
    components:{
        'video-page':videoPage,
        'reciver-email': reciverEmail,
        'reciver-phone':reciverPhone,
        'password-change' : passwordChange,
    }
});


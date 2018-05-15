
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import axios from 'axios';
import $ from "jquery";
/*require('jquery-ui');*/

// import '/bulma/css/bulma.css';
require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */



Vue.component('member-row', require('./components/memberSearchRow.vue'));

Vue.component('search-results', require('./components/searchResults.vue'));


const app = new Vue({
    el: '#app',

    data: {
    	members: [],
    	searchTerm: '',
    	membersToDisplay: [],
    	displayTableSummary: true,
    },
    mounted: function() {
    	axios.get('/search/members/all')

    	.then(function (response){
    		app.members = response.data;
    		app.membersToDisplay = response.data;
    	})

    	.catch(function (error){
    		console.log(error);
    	})
    },
    methods:{
    	filterMembers: function() {
    		app.membersToDisplay = app.members.filter(function(member) {
			  return member.fname == 'Matt';
			});
			
    	}
    }


});

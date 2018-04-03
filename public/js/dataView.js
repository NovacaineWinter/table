function url(uri){

    cleanURI = (uri[0] == '/') ? uri.substr(1) : uri;

    return document.head.querySelector("[property=siteurl]").content+'/'+cleanURI;
}

/*
$('#postcode_lookup').getAddress({
    api_key: 'noApiKeyNeeded',  
    api_endpoint:url('search/postcode'),
    output_fields:{
        line_1: '#line1',
        line_2: '#line2',
        line_3: '#line3',
        post_town: '#town',
        county: '#county',
        postcode: '#postcode'
    },                                                                                                              
    onLookupSuccess: function(data){$('.toReveal').show();},
    onLookupError: function(){alert('lookup error')},
    onAddressSelected: function(elem,index){/* Your custom code *//*}
});
*/

$('#postcode_lookup').getAddress({
    api_key: 'rvBtpEH-nUaFB-VJjC51PQ12935',  
    output_fields:{
        line_1: '#line1',
        line_2: '#line2',
        line_3: '#line3',
        post_town: '#town',
        county: '#county',
        postcode: '#postcode'
    },                                                                                                       
    onLookupSuccess: function(data){/* Your custom code */},
    onLookupError: function(){/* Your custom code */},
    onAddressSelected: function(elem,index){/* Your custom code */}
});

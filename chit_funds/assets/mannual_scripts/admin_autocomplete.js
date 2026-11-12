var Typeheads = function () {

   var Chits = function() {

      var chits = new Bloodhound({
         datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
         queryTokenizer: Bloodhound.tokenizers.whitespace,
         limit: 10,
         prefetch: {
            url: base_url+'index.php/Auction_controller/get_chits_json',
            filter: function(list) {
               return $.map(list, function(chit_id) { return { name: chit_id }; });
            }
         }
      });

      chits.initialize();

      if (App.isRTL()) {
         $('#chit_id').attr("dir", "rtl");  
      }
      $('#chit_id').typeahead(null, {
         name: 'chit_id',
         displayKey: 'name',
         hint: (App.isRTL() ? false : true),
         source: chits.ttAdapter()
      });
   }

   var Subscriber = function() {
      var subscribers = new Bloodhound({
         datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
         queryTokenizer: Bloodhound.tokenizers.whitespace,
         limit: 10,
         prefetch: {
            url: base_url+'index.php/Auction_controller/get_subscribers_json',
            filter: function(list) {
               return $.map(list, function(subscriber_id) { return { name: subscriber_id }; });
            }
         }
      });

      subscribers.initialize();

      if (App.isRTL()) {
         $('#subscriber_id').attr("dir", "rtl");  
      }
      $('#subscriber_id').typeahead(null, {
         name: 'subscriber_id',
         displayKey: 'name',
         hint: (App.isRTL() ? false : true),
         source: subscribers.ttAdapter()
      });
   }

   var Bidder = function() {
      var subscribers = new Bloodhound({
         datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
         queryTokenizer: Bloodhound.tokenizers.whitespace,
         limit: 10,
         prefetch: {
            url: base_url+'index.php/Auction_controller/get_subscribers_json',
            filter: function(list) {
               return $.map(list, function(bidder_id) { return { name: bidder_id }; });
            }
         }
      });

      subscribers.initialize();

      if (App.isRTL()) {
         $('#bidder_id').attr("dir", "rtl");  
      }
      $('#bidder_id').typeahead(null, {
         name: 'bidder_id',
         displayKey: 'name',
         hint: (App.isRTL() ? false : true),
         source: subscribers.ttAdapter()
      });
   }

   return {
      init: function () {
         Chits();
         Subscriber();
         Bidder();
      }
   };
}();

jQuery(document).ready(function() {    
   Typeheads.init(); 
});
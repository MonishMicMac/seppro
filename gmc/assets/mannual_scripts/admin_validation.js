var FormValidation = function () {

   var subscriber_form = function() {
      var form_subscriber = $('#subscriber_form');
      var error_subscriber = $('.alert-danger', form_subscriber);

      form_subscriber.validate({
         errorElement: 'span',
         errorClass: 'help-block help-block-error',
         focusInvalid: false,
         ignore: "",
         rules: {
           /* s_party_id: {
               required: true
            },*/
            party_name: {
               required: true
            },
            aadhar_no: {
               required: true,
               number: true
            },
            /*dob: {
               required: true
            },*/
            mobile_no: {
               required: true
            },
            phone_no: {
               required: true
            }/*,
            city: {
               required: true
            },
            area: {
               required: true
            },
            address: {
               required: true
            }*/
         },

         messages: {
           /* s_party_id: {
               required: "Please Enter Party ID"
            },*/
            party_name: {
               required: "Please Enter Party Name"
            },
            aadhar_no: {
               required: "Please Enter Aadhar No",
               number: "Only Numbers"
            },
            /*dob: {
               required: "Please Enter Date Of Birth"
            },*/
            mobile_no: {
               required: "Please Enter Mobile No"
            },
            phone_no: {
               required: "Please Enter Phone No"
            }/*,,
            city: {
               required: "Please Enter City"
            }
            area: {
               required: "Please Enter Area"
            },
            address: {
               required: "Please Enter Address"
            }*/
         },

         errorPlacement: function (error, element) {
            if (element.parent(".input-group").size() > 0) {
               error.insertAfter(element.parent(".input-group"));
            } else if (element.attr("data-error-container")) { 
               error.appendTo(element.attr("data-error-container"));
            } else if (element.parents('.radio-list').size() > 0) { 
               error.appendTo(element.parents('.radio-list').attr("data-error-container"));
            } else if (element.parents('.radio-inline').size() > 0) { 
               error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
            } else if (element.parents('.checkbox-list').size() > 0) {
               error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
            } else if (element.parents('.checkbox-inline').size() > 0) { 
               error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
            } else {
               error.insertAfter(element);
            }
         },

         invalidHandler: function (event, validator) {  
            error_subscriber.show();
            App.scrollTo(error_subscriber, -200);
         },

         highlight: function (element) {
            $(element).closest('.form-group').addClass('has-error');
         },

         unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
         },

         success: function (label) {
            label.closest('.form-group').removeClass('has-error');
         },

         submitHandler: function (form) {
            error_subscriber.hide();
            form_subscriber[0].submit();
         }

      });
   }

   var chit_form = function() {
      var form_chit = $('#chit_form');
      var error_chit = $('.alert-danger', form_chit);

      form_chit.validate({
         errorElement: 'span',
         errorClass: 'help-block help-block-error',
         focusInvalid: false,
         ignore: "",
         rules: {
            c_chit_id: {
               required: true,
               remote: {
                  url: base_url+"index.php/Chit_controller/check_chit_id",
                  type: "post",
                  data: {
                     auto_id: function() {
                        return $( "#auto_id" ).val();
                     },
                     chit_id: function() {
                        return $( "#chit_id" ).val();
                     }
                  }
               }
            },
            chit_name: {
               required: true
            },
            chit_amount: {
               required: true,
               number: true
            },
            subscribers: {
               required: true,
               number: true
            },
            total_months: {
               required: true,
               number: true
            },
            commission: {
               required: true,
               number: true
            },
            chit_date: {
               required: true
            },
            chit_time: {
               required: true
            }
         },

         messages: {
            c_chit_id: {
               required: "Please Enter Chit ID",
               remote: "Already Exists"
            },
            chit_name: {
               required: "Please Enter Chit Name"
            },
            chit_amount: {
               required: "Please Enter Chit Amount",
               number: "Only Numbers"
            },
            subscribers: {
               required: "Please Enter No. Of Subscribers",
               number: "Only Numbers"
            },
            total_months: {
               required: "Please Enter Total Months",
               number: "Only Numbers"
            },
            commission: {
               required: "Please Enter Commission %",
               number: "Only Numbers"
            },
            chit_date: {
               required: "Please Select Chit Date"
            },
            chit_time: {
               required: "Please Select Chit Time"
            }
         },

         errorPlacement: function (error, element) {
            if (element.parent(".input-group").size() > 0) {
               error.insertAfter(element.parent(".input-group"));
            } else if (element.attr("data-error-container")) { 
               error.appendTo(element.attr("data-error-container"));
            } else if (element.parents('.radio-list').size() > 0) { 
               error.appendTo(element.parents('.radio-list').attr("data-error-container"));
            } else if (element.parents('.radio-inline').size() > 0) { 
               error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
            } else if (element.parents('.checkbox-list').size() > 0) {
               error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
            } else if (element.parents('.checkbox-inline').size() > 0) { 
               error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
            } else {
               error.insertAfter(element);
            }
         },

         invalidHandler: function (event, validator) {  
            error_chit.show();
            App.scrollTo(error_chit, -200);
         },

         highlight: function (element) {
            $(element).closest('.form-group').addClass('has-error');
         },

         unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
         },

         success: function (label) {
            label.closest('.form-group').removeClass('has-error');
         },

         submitHandler: function (form) {
            error_chit.hide();
            form_chit[0].submit();
         }

      });
   }

   var auction_form = function() {
      var form_auction = $('#auction_form');
      var error_auction = $('.alert-danger', form_auction);

      form_auction.validate({
         errorElement: 'span',
         errorClass: 'help-block help-block-error',
         focusInvalid: false,
         ignore: "",
         rules: {
            auction_id: {
               required: true
            },
            auction_date: {
               required: true
            },
            chit_id: {
               required: true,
               remote: {
                  url: base_url+"index.php/Auction_controller/check_chit_id",
                  type: "post",
                  data: {
                     chit_id: function() {
                        return $( "#chit_id" ).val();
                     },
                     auction_date: function() {
                        return $( "#auction_date" ).val();
                     },
                     condition: function() {
                        return $( "#condition" ).val();
                     }
                  }
               }
            },
            bidder_id: {
               required: true,
               remote: {
                  url: base_url+"index.php/Auction_controller/check_bidder_id",
                  type: "post",
                  data: {
                     chit_id: function() {
                        return $( "#chit_id" ).val();
                     },
                     bidder_id: function() {
                        return $( "#bidder_id" ).val();
                     },
                     condition: function() {
                        return $( "#condition" ).val();
                     }
                  }
               }
            },
            total_subsription: {
               required: true,
               number: true
            },
            bid_count: {
               required: true,
               number: true
            },
            bid_amount: {
               required: true,
               number: true
            }
         },

         messages: {
            auction_id: {
               required: "Please Enter Auction ID"
            },
            auction_date: {
               required: "Please Select Auction Date"
            },
            chit_id: {
               required: "Please Enter Chit Name",
               remote: "Please Enter Valid Chit Name"
            },
            bidder_id: {
               required: "Please Enter Bidder Name",
               remote: "Please Enter Valid Bidder Name"
            },
            total_subsription: {
               required: "Please Enter Total Subscribers",
               number: "Only Numbers"
            },
            bid_count: {
               required: "Please Enter Total Bidders",
               number: "Only Numbers"
            },
            bid_amount: {
               required: "Please Enter Bid Amount",
               number: "Only Numbers"
            }
         },

         errorPlacement: function (error, element) {
            if (element.parent(".input-group").size() > 0) {
               error.insertAfter(element.parent(".input-group"));
            } else if (element.attr("data-error-container")) { 
               error.appendTo(element.attr("data-error-container"));
            } else if (element.parents('.radio-list').size() > 0) { 
               error.appendTo(element.parents('.radio-list').attr("data-error-container"));
            } else if (element.parents('.radio-inline').size() > 0) { 
               error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
            } else if (element.parents('.checkbox-list').size() > 0) {
               error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
            } else if (element.parents('.checkbox-inline').size() > 0) { 
               error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
            } else {
               error.insertAfter(element);
            }
         },

         invalidHandler: function (event, validator) {  
            error_auction.show();
            App.scrollTo(error_auction, -200);
         },

         highlight: function (element) {
            $(element).closest('.form-group').addClass('has-error');
         },

         unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
         },

         success: function (label) {
            label.closest('.form-group').removeClass('has-error');
         },

         submitHandler: function (form) {
            error_auction.hide();
            form_auction[0].submit();
         }

      });
}


var collection_form = function() {
   var form_collection = $('#collection_form');
   var error_collection = $('.alert-danger', form_collection);

   form_collection.validate({
      errorElement: 'span',
      errorClass: 'help-block help-block-error',
      focusInvalid: false,
      ignore: "",
      rules: {
         bill_no: {
            required: true
            // remote: {
            //    url: base_url+"index.php/Collection_controller/check_bill_no",
            //    type: "post",
            //    data: {
            //       auto_id: function() {
            //          return $( "#auto_id" ).val();
            //       },
            //       bill_no: function() {
            //          return $( "#bill_no" ).val();
            //       }
            //    }
            // }
         },
         bill_month: {
            required: true
         },
         collected_date: {
            required: true
         },
         chit_id: {
            required: true,
            remote: {
               url: base_url+"index.php/Collection_controller/check_chit_id",
               type: "post",
               data: {
                  chit_id: function() {
                     return $( "#chit_id" ).val();
                  }
               }
            }
         },
         subscriber_id: {
            required: true,
            remote: {
               url: base_url+"index.php/Collection_controller/check_subscriber_id",
               type: "post",
               data: {
                  subscriber_id: function() {
                     return $( "#subscriber_id" ).val();
                  }
               }
            }
         },
         coll_amount: {
            required: true,
            number: true
         },
         out_amount: {
            required: true,
            number: true
         }
      },

      messages: {
         bill_no: {
            required: "Please Enter Bill No",
            remote: "Already Exists!"
         },
         bill_month: {
            required: "Please Select Bill Month"
         },
         collected_date: {
            required: "Please Select Collected Date"
         },
         chit_id: {
            required: "Please Enter Chit Name",
            remote: "Please Enter Valid Chit Name"
         },
         subscriber_id: {
            required: "Please Enter Subscriber Name",
            remote: "Please Enter Valid Subscriber Name"
         },
         coll_amount: {
            required: "Please Enter Collection Amount",
            number: "Only Numbers"
         },
         out_amount: {
            required: "Please Enter Outstanding Amount",
            number: "Only Numbers"
         }
      },

      errorPlacement: function (error, element) {
         if (element.parent(".input-group").size() > 0) {
            error.insertAfter(element.parent(".input-group"));
         } else if (element.attr("data-error-container")) { 
            error.appendTo(element.attr("data-error-container"));
         } else if (element.parents('.radio-list').size() > 0) { 
            error.appendTo(element.parents('.radio-list').attr("data-error-container"));
         } else if (element.parents('.radio-inline').size() > 0) { 
            error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
         } else if (element.parents('.checkbox-list').size() > 0) {
            error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
         } else if (element.parents('.checkbox-inline').size() > 0) { 
            error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
         } else {
            error.insertAfter(element);
         }
      },

      invalidHandler: function (event, validator) {  
         error_collection.show();
         App.scrollTo(error_collection, -200);
      },

      highlight: function (element) {
         $(element).closest('.form-group').addClass('has-error');
      },

      unhighlight: function (element) {
         $(element).closest('.form-group').removeClass('has-error');
      },

      success: function (label) {
         label.closest('.form-group').removeClass('has-error');
      },

      submitHandler: function (form) {
         error_collection.hide();
         form_collection[0].submit();
      }

   });
}


var user_form = function() {
   var form_user = $('#user_form');
   var error_user = $('.alert-danger', form_user);

   form_user.validate({
      errorElement: 'span',
      errorClass: 'help-block help-block-error',
      focusInvalid: false,
      ignore: "",
      rules: {
         first_name: {
            required: true
         },
         last_name: {
            required: true
         },
         user_name: {
            required: true,
            remote: {
               url: base_url+"index.php/User_controller/check_user_id",
               type: "post",
               data: {
                  auto_id: function() {
                     return $( "#auto_id" ).val();
                  },
                  user_name: function() {
                     return $( "#user_name" ).val();
                  }
               }
            }
         },
         password: {
            required: true
         },
         conf_password: {
            required: true,
            equalTo : "#password"
         },
         phone_no: {
            required: true,
            number: true
         },
         email_id: {
            required: true,
            email: true
         },
         user_role: {
            required: true
         }
      },

      messages: {
         first_name: {
            required: "Please Enter First Name"
         },
         last_name: {
            required: "Please Enter Last Name"
         },
         user_name: {
            required: "Please Enter User Name",
            remote: "Already Exists!"
         },
         password: {
            required: "Please Enter Password"
         },
         conf_password: {
            required: "Please Enter Confirm Password",
            equalTo : "Please Enter Same As Password"
         },
         phone_no: {
            required: "Please Select Phone No",
            number: "Only Numbers"
         },
         email_id: {
            required: "Please Enter Email ID",
            email: "Please Enter Valid Email ID"
         },
         user_role: {
            required: "Please Select User Role"
         }
      },

      errorPlacement: function (error, element) {
         if (element.parent(".input-group").size() > 0) {
            error.insertAfter(element.parent(".input-group"));
         } else if (element.attr("data-error-container")) { 
            error.appendTo(element.attr("data-error-container"));
         } else if (element.parents('.radio-list').size() > 0) { 
            error.appendTo(element.parents('.radio-list').attr("data-error-container"));
         } else if (element.parents('.radio-inline').size() > 0) { 
            error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
         } else if (element.parents('.checkbox-list').size() > 0) {
            error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
         } else if (element.parents('.checkbox-inline').size() > 0) { 
            error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
         } else {
            error.insertAfter(element);
         }
      },

      invalidHandler: function (event, validator) {  
         error_user.show();
         App.scrollTo(error_user, -200);
      },

      highlight: function (element) {
         $(element).closest('.form-group').addClass('has-error');
      },

      unhighlight: function (element) {
         $(element).closest('.form-group').removeClass('has-error');
      },

      success: function (label) {
         label.closest('.form-group').removeClass('has-error');
      },

      submitHandler: function (form) {
         error_user.hide();
         form_user[0].submit();
      }

   });
}


var chit_subs_form = function() {
   var form_chit_subs = $('#chit_subs_form');
   var error_chit_subs = $('.alert-danger', form_chit_subs);

   form_chit_subs.validate({
      errorElement: 'span',
      errorClass: 'help-block help-block-error',
      focusInvalid: false,
      ignore: "",
      rules: {
         chit_id: {
            required: true,
            remote: {
               url: base_url+"index.php/Chit_subs_controller/check_chit_subs_id",
               type: "post",
               data: {
                  chit_id: function() {
                     return $( "#chit_id" ).val();
                  },
                  popup_chit_id: function() {
                     return $( "#popup_chit_id" ).val();
                  },
                  condition: function() {
                     return $( "#condition" ).val();
                  }
               }
            }
         }
      },

      messages: {
         chit_id: {
            required: "Please Enter Chit ID",
            remote: "Already Exists!"
         }

      },

      errorPlacement: function (error, element) {
         if (element.parent(".input-group").size() > 0) {
            error.insertAfter(element.parent(".input-group"));
         } else if (element.attr("data-error-container")) { 
            error.appendTo(element.attr("data-error-container"));
         } else if (element.parents('.radio-list').size() > 0) { 
            error.appendTo(element.parents('.radio-list').attr("data-error-container"));
         } else if (element.parents('.radio-inline').size() > 0) { 
            error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
         } else if (element.parents('.checkbox-list').size() > 0) {
            error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
         } else if (element.parents('.checkbox-inline').size() > 0) { 
            error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
         } else {
            error.insertAfter(element);
         }
      },

      invalidHandler: function (event, validator) {  
         error_chit_subs.show();
         App.scrollTo(error_chit_subs, -200);
      },

      highlight: function (element) {
         $(element).closest('.form-group').addClass('has-error');
      },

      unhighlight: function (element) {
         $(element).closest('.form-group').removeClass('has-error');
      },

      success: function (label) {
         label.closest('.form-group').removeClass('has-error');
      },

      submitHandler: function (form) {
         var error_cnt=0;
         $(".subscriber_id").each(function(){
            if($(this).val()==''){
               $(this).closest("div.form-group").addClass("has-error");
               $(this).closest("div").find('span').remove();
               $(this).after('<span id="subscriber_id-error" class="help-block help-block-error">Please Enter Subscriber ID / Name</span>');
               error_cnt++;
            } else {
               $(this).closest("div.form-group").removeClass("has-error");
               $(this).closest("div").find('span').remove();
            }
         });

         if(error_cnt==0){
            form_chit_subs[0].submit();
         }

         error_chit_subs.hide();
         return false;
      }

   });
}


var deposit_form = function() {
   var form_deposit = $('#deposit_form');
   var error_deposit = $('.alert-danger', form_deposit);

   form_deposit.validate({
      errorElement: 'span',
      errorClass: 'help-block help-block-error',
      focusInvalid: false,
      ignore: "",
      rules: {
        /* chit_id: {
            required: true
         },*/
        /* subscriber_id: {
            required: true,
            remote: {
               url: base_url+"index.php/Deposit_controller/check_subscriber_id",
               type: "post",
               data: {
                  auto_id: function() {
                     return $( "#auto_id" ).val();
                  },
                  chit_id: function() {
                     return $( "#chit_id" ).val();
                  },
                  subscriber_id: function() {
                     return $( "#subscriber_id" ).val();
                  }
               }
            }
         },*/
         subscriber_id: {
            required: true
         },
         amount: {
            required: true
         }
      },

      messages: {
         /*chit_id: {
            required: "Please Enter Chit ID"
         },*/
          subscriber_id: {
            required: "Please Enter Subscriber ID"
         },/*
         subscriber_id: {
            required: "Please Enter Subscriber ID",
            remote: "Already Exists!"
         },*/
         amount: {
            required: "Please Enter Amount"
         }
      },

      errorPlacement: function (error, element) {
         if (element.parent(".input-group").size() > 0) {
            error.insertAfter(element.parent(".input-group"));
         } else if (element.attr("data-error-container")) { 
            error.appendTo(element.attr("data-error-container"));
         } else if (element.parents('.radio-list').size() > 0) { 
            error.appendTo(element.parents('.radio-list').attr("data-error-container"));
         } else if (element.parents('.radio-inline').size() > 0) { 
            error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
         } else if (element.parents('.checkbox-list').size() > 0) {
            error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
         } else if (element.parents('.checkbox-inline').size() > 0) { 
            error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
         } else {
            error.insertAfter(element);
         }
      },

      invalidHandler: function (event, validator) {  
         error_deposit.show();
         App.scrollTo(error_deposit, -200);
      },

      highlight: function (element) {
         $(element).closest('.form-group').addClass('has-error');
      },

      unhighlight: function (element) {
         $(element).closest('.form-group').removeClass('has-error');
      },

      success: function (label) {
         label.closest('.form-group').removeClass('has-error');
      },

      submitHandler: function (form) {
         form_deposit[0].submit();
         error_deposit.hide();
      }

   });
}


return {
   init: function () {
      chit_form();
      subscriber_form();
      auction_form();
      collection_form();
      user_form();
      chit_subs_form();
      deposit_form();
   }
};
}();

jQuery(document).ready(function() {
   FormValidation.init();
});
jQuery(document).ready(function()
{
  // handle sending step 1
  jQuery('#SubmitQuestion').live('click', function(event) {
    event.preventDefault();
    var language = jQuery('input[name=chooselanguage]:checked').val();
    postLanguage(language);
  });

  // handle language changes
  jQuery('a.langchange').live('click', function(event) {
    event.preventDefault();
    var language = jQuery(this).attr('href');
    postLanguage(language);
  });

  // handle the rsvp radio button
  jQuery('input[name=rsvp]').live('change', function() {
    var value = jQuery('input[name=rsvp]:checked').val();
    if (value == 1)
    {
      jQuery('div.guestswitch').show('slow');
      jQuery('div.guestswitch input[name=avec][value=0]').attr('checked', true);
    }
    else
    {
      jQuery('div.guestswitch').hide('slow');
      jQuery('div.guest').hide('slow');
      jQuery('div.guest input').attr('value', '');
    }
  });

  // handle the avec radio button
  jQuery('input[name=avec]').live('change', function() {
    var value = jQuery('input[name=avec]:checked').val();

    if (value == 1)
    {
      jQuery('div.guest').show('slow');
    }
    else
    {
      jQuery('div.guest').hide('slow');
      jQuery('div.guest input').attr('value', '');
    }
  });

  // handle sending step 2
  jQuery('input#register').live('click', function(event) {
    event.preventDefault();
    postRegistration();
  });

  /**
   * Posts the given language
   */
  function postLanguage(language)
  {
    if (typeof language === 'undefined')
    {
      language = jQuery('input[name=chooselanguage]:checked').val();
    }

    if (typeof language === 'undefined')
    {
      language = jQuery(this).attr('href');
    }

    if (typeof language !== 'undefined')
    {
      jQuery.ajax({
        url: '/nnp:language',
        type: 'POST',
        data: 'lang=' + language,
        dataType: 'json',
        success: function(json) {
          jQuery('div#main').html(json.page);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          //console.log('error');
        }
      });
    }
  };

  /**
   * Posts the filled in form
   */
  function postRegistration()
  {
    if (jQuery('input#firstname').val() && jQuery('input#lastname').val() && jQuery('input#email').val())
    {
      var data = jQuery('form#contact_information').serialize();
      //console.log('send: ' + data);

      // remove the error classes, if they were added
      jQuery('input#firstname').removeClass('error');
      jQuery('input#lastname').removeClass('error');
      jQuery('input#email').removeClass('error');
      if (! jQuery('div.form-row.error').hasClass('hidden'))
      {
        jQuery('div.errormsg').addClass('hidden');
      }

      jQuery.ajax({
        url: '/nnp:register',
        type: 'POST',
        data: jQuery('form#contact_information').serialize(),
        dataType: 'json',
        success: function(json) {
          jQuery('div#main').html(json.page);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          //console.log('error');
        }
      });
    }
    else
    {
      if (jQuery('input#firstname').val() == '')
      {
        jQuery('input#firstname').addClass('error');
      }
      if (jQuery('input#lastname').val() == '')
      {
        jQuery('input#lastname').addClass('error');
      }
      if (jQuery('input#email').val() == '')
      {
        jQuery('input#email').addClass('error');
      }
      // show the error message
      jQuery('div.errormsg').show('slow');
    }
  }
});
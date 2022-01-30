function ToggleVisibility(show_elem, hide_elem) 
{
  $('#'+show_elem).toggle();
  $('#'+hide_elem).toggle();
}

function checkUniqueEmail(elem, email, ref_id="")
{
  var return_flag = 1;
  $.ajax({
    url: 'includes/ajax.inc.php',
    type: 'post',
    data: {response: 'UNIQUE_EMAIL', email:email, ref_id:ref_id},
    async: false,
    success: function(result) {
      // $(elem)
      // console.log(result)
      return_flag = result;
    },
    error: function(errors) {
      alert(errors.responseText);
    }
  })

  return return_flag;
}

function passwordify(pass_str="")
{
  var new_str = "";
  if(pass_str!='')
  {
    $.ajax({
      url: 'includes/ajax.inc.php',
      type: 'post',
      data: {response: 'PASSWORDIFY', pass_str:pass_str},
      async: false,
      success: function(result) {
        // $(elem)
        // console.log(result)
        new_str = result;
      },
      error: function(errors) {
        alert(errors.responseText);
      }
    })    
  }

  return new_str;
}


$("#signup").click(function() {
  $("#first").fadeOut("fast", function() {
    $("#second").fadeIn("fast");
  });
});

$("#signin").click(function() {
  $("#second").fadeOut("fast", function() {
    $("#first").fadeIn("fast");
  });
});



$(function() {
 $("form[name='login']").validate({
  rules: {     
     txtemail: {
       required: true,
       email: true
     },
     txtpassword: {
       required: true,

     }
   },
   messages: {
     txtemail: "Please enter a valid email address",
     txtpassword: {
       required: "Please enter password",
     }
   },
   submitHandler: function(form) {
      var p_str = passwordify(txtpassword.value);
      txtpassword.value = p_str;
      form.submit();
   }
 });
});



$(function() {

  $("form[name='registration']").validate({
    rules: {
      firstname: "required",
      email: {
        required: true,
        email: true
      },
      password: {
        required: true,
        minlength: 5
      }
    },
    
    messages: {
      firstname: "Please enter your firstname",
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long"
      },
      email: "Please enter a valid email address"
    },

    submitHandler: function(form) 
    {
      var validEmail = checkUniqueEmail(email, email.value);
      // alert(validEmail);
      if(validEmail == '0')
      {
        console.log('email not found')
        var p_str = passwordify(password.value);
        password.value = p_str;
        form.submit();
      }
      else
      {
        alert('Email id already exists');
      }
    }
  });
});

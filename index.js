$(document).ready(function () {
  $('#register_btn').click(function (event) {
    $('#login_modal').hide("explode");
    $('#register_modal').show("explode");
  });
  $('#login_btn').click(function (event) {
    $('#register_modal').hide("explode");
    $('#login_modal').show("explode");
  });
  $('#cnf_pwd').focusout(function (event) {
    var password = $('#pwd').val();
    var confirmPassword = $('#cnf_pwd').val();
    if (password != confirmPassword) {
      alert("Confirm password does not match with password entered. Please Re-enter your password");
      $('#cnf_pwd').val("");
    }
  });
  $("#registration_btn").click(function (event) {
    event.preventDefault();
    $.ajax({
      url: "/guvi.php",
      type: "POST",
      data: {
        purpose: 'register',
        name: $('#name').val(),
        password: $('#pwd').val(),
        email: $('#email').val(),
        age: $('#age').val(),
        dob: $('#dob').val(),
        contact_no: $('#contact').val()
      },
      success: function (data, textStatus, jqXHR) {
        alert('Registered Successfully');
        $('#register_modal').hide("explode");
        $('#login_modal').show("explode");
      },
      error: function (jqXHR, textStatus, errorThrown) {
      }
    });
  });
  $("#login").click(function (event) {
    event.preventDefault();
    $.ajax({
      url: "/guvi.php",
      type: "POST",
      data: {
        purpose: 'login',
        email: $('#login_email').val(),
        password: $('#login_pwd').val()
      },
      success: function (data, textStatus, jqXHR) {
        if (data != "false") {
          alert("Log in successfull!");
          console.log("logged in successfully");
          window.location.href = "/welcome.html";
        } else {
          console.log("failed to log in");
          alert("Incorrect Username or Password");
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
      }
    });
  });
  $("#update_btn").click(function (event) {
    event.preventDefault();
    $.ajax({
      url: "/guvi.php",
      type: "POST",
      data: {
        purpose: 'update',
        age: $('#age').val(),
        dob: $('#dob').val(),
        contact_no: $('#contact').val()
      },
      success: function (data, textStatus, jqXHR) {
        alert("Details updated successfully");
        console.log("updated successfully");
        window.location.href = "/welcome.html";
      },
      error: function (jqXHR, textStatus, errorThrown) {
      }
    });
  });
  $("#logout_btn").click(function (event) {
    event.preventDefault();
    $.ajax({
      url: "/guvi.php",
      type: "POST",
      data: {
        purpose: 'logout'
      },
      success: function (data, textStatus, jqXHR) {
        alert("Your are now logged out");
        console.log("user logged out");
        window.location.href = "/index.html";
      },
      error: function (jqXHR, textStatus, errorThrown) {
      }
    });
  });
});

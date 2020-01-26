$(document).ready(function () {
  $('#register_btn').click(function (event) {
    $('#login_modal').hide("explode");
    $('#register_modal').show("explode");
  });
  $('#login_btn').click(function (event) {
    $('#register_modal').hide("explode");
    $('#login_modal').show("explode");
  });
  $('#cnf_pwd').focusout(function (event){
     var password = $('#pwd').val();
     var confirmPassword = $('#cnf_pwd').val();
     if(password != confirmPassword){
       alert("Confirm password does not match with password entered. Please Re-enter your password");
       $('#cnf_pwd').val("");
      }
  });
  $("#registration").submit(function (event) {
    event.preventDefault();
    var $form = $(this),
      url = $form.attr('action');
    var posting = $.post(url, {
      name: $('#name').val(), password: $('#pwd').val(), email: $('#email').val(),
      age: $('#age').val(), dob: $('#dob').val(), contact_no: $('#contact').val()
    });
    posting.done(function (data) {
      alert('Registered Successfully');
      $('#register_modal').hide("explode");
      $('#login_modal').show("explode");
    });
  });
  $("login").submit(function (event) {
    event.preventDefault();
    var $form = $(this),
      url = $form.attr('action');
    var posting = $.post(url, { email: $('#login_email').val(), password: $('#login_pwd').val() }, function (data) {
    console.log("logged in successfully");
    });
  });
  $("update_form").submit(function (event) {
    event.preventDefault();
    var $form = $(this),
      url = $form.attr('action');
    var posting = $.post(url, { age: $('#age').val(), dob: $('#dob').val(), contact_no: $('#contact').val() }, function (data) {
    console.log("updated successfully");
    });
  });
  $("#logout").click(function (event) {
    event.preventDefault();
    var url = '/login.php';
    var posting = $.post(url, {purpose: 'logout'},function (data) {
    console.log("logged out");
    window.location.href = "/index.html";
    });
  });
  
});
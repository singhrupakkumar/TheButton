
    alert('sdferfherjkh');    
   $("#editform").validate({
            errorElement: 'span',
            rules: {
                "data[User][zip]": "required", 
                "data[User][lname]": "required",
                "data[User][email]": "required"
            },
            messages: {
                "data[User][fname]": "Please enter your First Name",
                "data[User][lname]": "Please enter your Last Name",
                "data[User][cor]": "Please enter your Country of residence",
                "data[User][currency]": "Please enter your currency",
                "data[User][email]": "Please enter your E-mail ID"
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    
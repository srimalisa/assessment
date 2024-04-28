<!-- JAVASCRIPT -->
<script src="{{ asset('assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('assets/libs/bootstrap/bootstrap.min.js')}}"></script>
<script src="{{ asset('assets/libs/metismenu/metismenu.min.js')}}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{ asset('assets/libs/node-waves/node-waves.min.js')}}"></script>
<script src="{{ asset('assets/libs/select2/select2.min.js')}}"></script>
<script src="{{ asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
<script src="{{ asset('assets/libs/moment/moment.min.js')}}"></script>
<script src="{{ asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/libs/dropzone/dropzone.min.js')}}"></script>
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{ asset('assets/libs/datatables/datatables.min.js')}}"></script>
<script src="{{ asset('assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js')}}"></script>


<script>
    $("form").attr('autocomplete', 'off');
    $('form').parsley({
        errorClass: 'is-invalid text-danger',
        successClass: 'is-valid',
        errorsWrapper: '<div class="invalid-feedback"></div>',
        errorTemplate: '<span></span>',
        trigger: 'change',
        errorsContainer: function(ParsleyField) {
            if(ParsleyField.$element.parent().get( 0 ).className.split(' ')[0] == 'input-group')
            return ParsleyField.$element.parents('.input-group');
            else if(ParsleyField.$element.parent().get( 0 ).className.split(' ')[0] == '')
            return ParsleyField.$element.closest('.form-group').children;
            else
            return ParsleyField.$element.closest('.form-group');
        }
    });
    $(".select2").select2();

    $(".select2-limiting").select2({
      maximumSelectionLength: 2
    });


    $(".select2-search-disable").select2({
      minimumResultsForSearch: Infinity
    });
</script>
<script>
    window.logout = function() {
      fetch('/api/logout', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
      })
      .then(response => response.json())
      .then(data => {
          localStorage.removeItem('token');
          window.location.href = `/login`;
      })
      .catch((error) => {
          console.error('Error:', error);
      });
    }

    $(document).on('click', 'a', function(event) {
        event.preventDefault();
        var url = $(this).attr('href');
        redirectToUrlWithToken(url);
    });

    window.redirectToUrlWithToken = function(url) {
        token = localStorage.getItem('token');
        var redirectUrl = url + '?token=' + encodeURIComponent(token);
        window.location.href = redirectUrl;
    }

    document.addEventListener('submit', function(event) {
        // Append token header on form submission
        var excludeForms = ['excludeForm'];
        var formClasses = Array.from(event.target.classList);
        var shouldExclude = formClasses.some(r=> excludeForms.includes(r));

        if (shouldExclude) {
            return;
        }
        if (event.target.tagName.toLowerCase() === 'form') {
            event.preventDefault();
            event.stopImmediatePropagation();

            var token = localStorage.getItem('token');
            var formData = new FormData(event.target);
            formData.append('Authorization', 'Bearer ' + token);

            var action = event.target.getAttribute('action');
            var xhr = new XMLHttpRequest();
            xhr.open(event.target.getAttribute('method'), action);
            xhr.setRequestHeader('Authorization', 'Bearer ' + token);

            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        alert(response.message);
                    }
                } else {
                    console.error('Request failed with status ' + xhr.status);
                }
            };

            xhr.onerror = function() {
                console.error('Error occurred while submitting the form');
            };

            xhr.send(formData);
        }
    });
    
    // window.onload = function() {
    //     // remove token from URL
    //     if (window.location.href.indexOf('token') !== -1) {
    //         const urlWithoutToken = window.location.protocol + "//" + window.location.host + window.location.pathname;
    //         window.history.replaceState({}, document.title, urlWithoutToken);
    //     }
    // }

    // window.addEventListener('beforeunload', function (event) {
    //     var token = localStorage.getItem('token');
    //     if (token) {
    //         window.location.href = window.location.protocol + "//" + window.location.host + window.location.pathname + '?token=' + token;
    //     }
    // });
</script>
@yield('script')

<!-- App js -->
<script src="{{ asset('assets/js/app.min.js')}}"></script>

@yield('script-bottom')

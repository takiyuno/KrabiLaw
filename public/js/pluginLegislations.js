
// --------- button-to-top --------------
  var btn = $('#button');
  $(window).scroll(function() {
    if ($(window).scrollTop() > 300) {
      btn.addClass('show');
    } else {
      btn.removeClass('show');
    }
  });

  btn.on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({scrollTop:0}, '300');
  });

// --------- Popup --------------
  $(function () {
    $("#modal-Popup").on("show.bs.modal", function (e) {
      var link = $(e.relatedTarget).data("link");
      $("#modal-Popup .modal-body").load(link, function(){
      });
    });
  });
  $(function () {
    $("#modal-default").on("show.bs.modal", function (e) {
      var link = $(e.relatedTarget).data("link");
      $("#modal-default .modal-body").load(link, function(){
      });
    });
  });
  $(function () {
    $("#modal-edit").on("show.bs.modal", function (e) {
      var link = $(e.relatedTarget).data("link");
      $("#modal-edit .modal-body").load(link, function(){
      });
    });
  });

// -------- data-mask ------------
  $(function () {
    $('[data-mask]').inputmask()
  })

// -------- prem ------------
  function blinker() {
    $('.prem').fadeOut(1500);
    $('.prem').fadeIn(1500);
  }
  setInterval(blinker, 1500);

// -------- DataTable ------------
  $(document).ready(function() {
      $('#table').DataTable( {
          "responsive": true,
          "autoWidth": false,
          "ordering": true,
          "lengthChange": true,
          "order": [[ 0, "asc" ]]
      });
      $('#tableD').DataTable( {
        "responsive": true,
        "autoWidth": false,
        "ordering": true,
        "lengthChange": true,
        "order": [[ 0, "desc" ]]
      });
      $('#table1,#table2').DataTable( {
        "searching" : true,
        "lengthChange" : false,
        "info" : false,
        "pageLength": 6,
        "order": [[ 0, "asc" ]]
      });
      $('#table11,#table22,#table33,#table44,#table55,#table66').DataTable( {
        "responsive": true,
        "autoWidth": false,
        "ordering": true,
        "lengthChange": true,
        "pageLength": 6,
        "order": [[ 0, "asc" ]]
      });
      $('#table111,#table222').DataTable( {
        "responsive": true,
        "autoWidth": false,
        "ordering": true,
        "lengthChange": true,
        "pageLength": 50,
        "order": [[ 0, "asc" ]]
      });
  });

// -------- FileInput ------------
  $(document).ready(function () {
    bsCustomFileInput.init();
  });


// -------- addCommas ------------
  function addCommas(nStr){
      nStr += '';
      x = nStr.split('.');
      x1 = x[0];
      x2 = x.length > 1 ? '.' + x[1] : '';
      var rgx = /(\d+)(\d{3})/;
      while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
      }
    return x1 + x2;
  }

//-------- ??????????????????????????????????????? -----------------
  $(document).ready(function () {
    $('.AlertDelete').click(function (evt) {
      var Contract_buyer = $(this).data("name");
      // var form = $(this).closest("form");
      var _this = $(this)
      
      evt.preventDefault();
      swal({
        title: `${Contract_buyer}`,
        icon: "warning",
        text: "????????????????????????????????????????????????????????????????????????????????????",
        buttons: true,
        dangerMode: true,
      }).then((isConfirm)=>{
        if (isConfirm) {
          window.location.href = _this.attr('href')
        }
      });
    });
  });

//-------- ??????????????????????????????????????????????????? -----------------
  $(document).ready(function () {
    $('.DeleteBook').click(function (evt) {
         var Contract_buyer = $(this).data("name");
         var form = $(this).closest("form");
         
         evt.preventDefault();
         swal({
             title: `${Contract_buyer}`,
             icon: "warning",
             text: "???????????????????????????????????????????????????????????????????????????????????? ?",
             buttons: true,
             dangerMode: true,
         })
         .then((isConfirm)=>{
             // console.log(isConfirm);
             if (isConfirm) {
                 swal("?????????????????????????????????????????? !", {
                     icon: "success",
                     timer: 15000,
                 })
                 form.submit();
             }
         });
 
     });
 });

//-------- Date Rang -----------------
  $(document).ready(function(){
    $('#dateSearch').daterangepicker({
      timePicker: true,
      timePicker24Hour: true,
      timePickerIncrement: 30,
      locale: {
          format: 'DD-MM-YYYY'
      }
    });
  });

//-------- Flag Tabs -----------------
    $(document).ready(function(){
      $("#vert-tabs-01-tab").on("click", function(){
          $("#FlagTab").val(1);
      });
      $("#vert-tabs-02-tab").on("click", function(){
        $("#FlagTab").val(2);
      });
      $("#vert-tabs-03-tab").on("click", function(){
          $("#FlagTab").val(3);
      });
      $("#vert-tabs-04-tab").on("click", function(){
          $("#FlagTab").val(4);
      });
      $("#vert-tabs-05-tab").on("click", function(){
          $("#FlagTab").val(5);
      });
      $("#vert-tabs-06-tab").on("click", function(){
          $("#FlagTab").val(6);
      });
  });

//-------- Div Radio -----------------

  function ShowDivRadio() {
    var x = document.getElementById("myDIV");
    var DivRadio1 = document.getElementById("DivRadio1");
    var DivRadio2 = document.getElementById("DivRadio2");

    if (DivRadio1.style.display === "none" || DivRadio2.style.display === "none" || x.style.display === "none") {
      x.style.display = "block";
      DivRadio1.style.display = "block";
      DivRadio2.style.display = "block";
    } else {
      x.style.display = "none";
      DivRadio1.style.display = "none";
      DivRadio2.style.display = "none";
    }
  }
  function hiddenDivRadio() {
    var x = document.getElementById("myDIV");
    var DivRadio1 = document.getElementById("DivRadio1");
    var DivRadio2 = document.getElementById("DivRadio2");

    x.style.display = "none";
    DivRadio1.style.display = "none";
    DivRadio2.style.display = "none";
  }

//----------- Validate Form ----------------
  $(function () {
    $('#quickForm').validate({
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.col-sm-4').append(error);
        element.closest('.col-sm-6').append(error);
        element.closest('.col-sm-8').append(error);
        element.closest('.col-sm-10').append(error);
        element.closest('.col-3').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });
  });

//----------- Tooltip ----------------
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
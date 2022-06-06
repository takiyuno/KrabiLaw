// --------- Modal Compro --------------
  $('#Convert-Cult').on('input', function() {
    var SetTotalPrice = $('#TotalPrice').val();
    var TotalPrice = SetTotalPrice.replace(",","");

    var SetTotalPaid = $('#TotalPaid').val();
    var TotalPaid = SetTotalPaid.replace(",","");

    var SetCompensation = $('#Compensation').val();
    var Compensation = SetCompensation.replace(",","");

    var SetPercentCompensation = $('#PercentCompensation').val();
    var PercentCompensation = SetPercentCompensation.replace(",","");

    var SetFeePrire = $('#FeePrire').val();
    var FeePrire = SetFeePrire.replace(",","");

    var SetPercentFeePrire = $('#PercentFeePrire').val();
    var PercentFeePrire = SetPercentFeePrire.replace(",","");

    var SetPercentfirstMoney = $('#PercentfirstMoney').val();
    var PercentfirstMoney = SetPercentfirstMoney.replace(",","");

    var SetInstallment = $('#Installment').val();
    var Installment = SetInstallment.replace(",","");

    var SetPercentInstallment = $('#PercentInstallment').val();
    var PercentInstallment = SetPercentInstallment.replace(",","");

    var SetTotalCost = $('#TotalCost').val();
    var TotalCost = SetTotalCost.replace(",","");

    var SumCap = 0;
    var SetFeePrire = 0;
    var SetSHowTotal = 0;
    var SetfirstMoney = 0;
    var SetInstallment = 0;
    var SetShowPeriod = 0;
    var SetProfit_1 = 0;
    var SetPercentProfit_1 = 0;
    
      if (TotalPrice == '') {
        var SetTotalPrice = 0;
      }else{
        var SetTotalPrice = parseFloat(TotalPrice);
      }

      if (TotalPaid == '') {
        var SetTotalPaid = 0;
      }else{
        var SetTotalPaid = parseFloat(TotalPaid);
      }

      if (Compensation == '') {
        var SetCompensation = 0;
      }else{
        var SetCompensation = parseFloat(Compensation);
      }

      if (TotalCost == '') {
        var SetTotalCost = 0;
      }else{
        var SetTotalCost = parseFloat(TotalCost);
      }

      var SumCap = (SetTotalPrice + SetCompensation);
      $('#TotalCapital').val(addCommas(SumCap.toFixed(2)));

      if (SumCap != 0) {
        var SetFeePrire = (SumCap * 0.05);
        var SetSHowTotal = ( (SetCompensation-(SetCompensation * (parseFloat(PercentCompensation / 100))))+ parseFloat(SetTotalPrice) +(SetFeePrire-(SetFeePrire * (parseFloat(PercentFeePrire / 100))) ));
        var SetfirstMoney = (SetSHowTotal * (parseFloat(PercentfirstMoney / 100)));

        console.log(SetSHowTotal);

        $('#FeePrire').val(addCommas(SetFeePrire.toFixed(2)));
        $('#SHowTotal').val(addCommas(SetSHowTotal.toFixed(2)));
        $('#firstMoney').val(addCommas(SetfirstMoney.toFixed(2)));
      }

      if (Installment != '') {
        SetInstallment = (parseFloat(Installment) * (parseFloat(PercentInstallment / 100)));
        $('#ShowDue').val(addCommas(SetInstallment.toFixed(2)));
      }

      var ShowPeriod = (((SetSHowTotal - SetfirstMoney) / SetInstallment) / 12);
      $('#ShowPeriod').val(ShowPeriod.toFixed(2));
      $('#CompoundTotal_1').val(addCommas(SetSHowTotal.toFixed(2)));

      var SetProfit_1 = (SetSHowTotal + SetTotalPaid - SetTotalCost);
      $('#Profit_1').val(addCommas(SetProfit_1.toFixed(2)));

      var SetPercentProfit_1 = ((SetProfit_1 * 100) / SetTotalCost)
      $('#PercentProfit_1').val(SetPercentProfit_1.toFixed(2));


      // var TotalPrice = TotalPrice.replace(",","");
      // var TotalPaid = TotalPaid.replace(",","");
      // var Compensation = Compensation.replace(",","");
      // var Installment = $('#Installment').val();
      // var Installment = Installment.replace(",","");
      // $('#TotalPrice').val(addCommas(TotalPrice));
      // $('#TotalPaid').val(addCommas(TotalPaid));
      // $('#Compensation').val(addCommas(Compensation));
      // $('#Installment').val(addCommas(Installment));
  });

  $('#Convert-Cult2').on('input', function() {
    var SetTotalPrice = $('#TotalPrice').val();
    var TotalPrice = SetTotalPrice.replace(",","");

    var SetDuePay = $('#Installment').val();
    var DuePay = SetDuePay.replace(",","");

    $('#TotalPrice').val(addCommas(TotalPrice));
    $('#Installment').val(addCommas(DuePay));
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
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
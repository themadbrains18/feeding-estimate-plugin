"use-strict"
window.onbeforeunload = function () {
  // Your Code here 
   return null;  // return null to avoid pop up
 }

jQuery(document).ready(function ($) {


  if (formulaObj.savedFields == null) {
    // hide all elemnts by default
    $('button#ProductRecommendation-btn, button#save_formula-btn, div#PageRecommendation, button#PageRecommendation-btn,  #RERformContent, #DERForm, #Feeding, #dailyIntake, #dailyIntakeBtn, #calculateFeeding, #derFormBtn, #addFeeding, div#ProductRecommendation').hide()
  } else {
    $('#RERformContent, #dailyIntake, div#ProductRecommendation, div#calculateFeeding, div#PageRecommendation, button#save_formula-btn').show()
    $(' #addRER, #dailyIntakeBtn, #derFormBtn, #addFeeding,  button#PageRecommendation-btn').hide()
  }


  //  step varibales intilization

  const step1 = $('#RERformContent .form_inner .form_items');
  const step2 = $('div[data-repeater-list="group-b"]');
  const step3 = $('#dailyIntake .form_inner .form_items');
  const step4 = $('#calculateFeeding  div#Feeding');

  // ******************* step 1 ************************ //
  step1.find('input').on('keyup', () => {
    var step1Complete = formStep1(step1)
  })
  // ******************* step 1 ************************ //


  // ******************* step 3 ************************ //
  step3.find('input').on('keyup', () => {
    var step3Complete = formStep3(step3)
  })
  // ******************* step 3 ************************ //

  // ******************* step 4 ************************ //
  step4.find('input').on('click', () => {
    $('button#addFeeding').hide()
    var step4Complete = formStep4(step4)
  })
  // ******************* step 4 ************************ //


  // Display Form Data Step By Step
  $('#addRER').on('click', () => {
    $('#addRER').hide()
    $('#RERformContent').slideDown()
  })
  $('#derFormBtn').on('click', () => {
    $('button#derFormBtn, button#derFormBtn').hide();
    $('#DERForm').slideDown()
  })

  $('#dailyIntakeBtn').on('click', () => {
    $('button#dailyIntakeBtn').hide();
    $('#dailyIntake').slideDown()
  })

  $('#addFeeding').on('click', () => {
    $('#calculateFeeding').slideDown()
    $('button#addFeeding').hide()
    $('#Feeding').slideDown()
  })



  // ******************* step 1 function ************************ //

  function formStep1(step1) {
    var fieldLegnth = step1.length
    var count = 0
    var flag = false
    step1.each((e, index) => {
      if ($(index).find('input').val() == '') {
        flag = false
        $('#RERoption').removeAttr('step', 'stepCompleted')
        $('#derFormBtn').hide()
      } else {
        count++
      }
      if (fieldLegnth == count) {
        flag = true
        $('#derFormBtn').show()
        // $('#dailyIntakeBtn').show()
        $('#RERoption').attr('step', 'stepCompleted')
        $('#addRER').hide()
      } else {
        flag = false
        $('#RERoption').removeAttr('step', 'stepCompleted')
        $('#derFormBtn').hide()
      }
    })
    return flag
  }

  // ******************* step 1 function ************************ //


  // ******************* step 2 function ************************ //

  function formStep2(step2) {
    var fieldLegnth = $(step2).find('.repeater_item').length * 2;
    var count = 0
    var flag = false
    step2.find('.repeater_item').each((e, index) => {
      $(index).find('.label_item').each((child_e, child_index) => {
        if ($(child_index).find('input').val() == '') {
          flag = false
          $('button#dailyIntakeBtn').hide()
        } else {
          count++
        }
        if (fieldLegnth == count) {
          flag = true
          $('#dailyIntakeBtn').show()
          $('#DERoption').attr('step', 'stepCompleted')
        } else {
          $('button#dailyIntakeBtn').hide()
          flag = false;
        }
      });
    })
    return flag
  }



  // ======= feild repeater js start ======= //
  $('.repeater').repeater({
    initEmpty: false,
    defaultValues: {
      // 'text-input': 'foo',
    },
    show: function () {
      formStep2(step2);
      $(this).slideDown()
    },
    hide: function (deleteElement) {
      if (confirm('Are you sure you want to delete this element?')) {
        formStep2(step2);
        $(this).slideUp(deleteElement)
      }
    },
    ready: function (setIndexes) {


    },
    isFirstItemUndeletable: true,
  })
  // ======= feild repeater js End ======= //


  // ******************* step 2 ************************ //

  let selectElement = document.querySelectorAll('div[data-repeater-list="group-b"] input[type="text"], div[data-repeater-list="group-b"] input[type="number"]');
  setInterval(() => {
    selectElement = document.querySelectorAll('div[data-repeater-list="group-b"] input[type="text"], div[data-repeater-list="group-b"] input[type="number"]');
    click2step(selectElement);
  }, 1000);

  function click2step(selectElement) {
    for (const button of selectElement) {
      button.addEventListener('keyup', function (event) {
        formStep2(step2);
      })
    }
  }
  click2step(selectElement);

  // selectElement.addEventListener('input', (e) => {
  // // step2.find('input').on('keyup', (e) => {
  //   console.log(e.target);
  //   console.log(step2);
  //   var step2Complete = formStep2(step2)
  // })
  // ******************* step 1 ************************ //


  // ******************* step 2 function ************************ //


  // ******************* step 3 function ************************ //

  function formStep3(step3) {
    var fieldLegnth = step3.length
    var count = 0
    var flag = false
    step3.each((e, index) => {
      if ($(index).find('input').val() == '') {
        flag = false
        $('button#dailyIntakeBtn').hide();
      } else {
        count++
      }
      if (fieldLegnth == count) {
        flag = true
        $('#dailyIntakeOption').attr('step', 'stepCompleted')
        $('#addFeeding').show()
      } else {
        flag = false
        $('button#dailyIntakeBtn').hide();
      }
    })
    return flag
  }

  // ******************* step 3 function ************************ //


  // ******************* step 4 function ************************ //

  function formStep4(step4) {
    var fieldLegnth = $(step4).find('.form-group').length

    var count = 1
    var flag = false
    step4.find('.form-group').each((e, index) => {
      if ($(index).find('input').is(":checked")) {
        count++
      } else {
        flag = false
        $('button#addFeeding').hide()
      }

      if (fieldLegnth == count) {
        flag = true
        $('#Feedingoption').attr('step', 'stepCompleted')

        $("#ProductRecommendation").show();
        $("button#ProductRecommendation-btn").show();
      } else {
        $('button#addFeeding').hide()
        flag = false
      }
    })
    return flag
  }

  // ******************* step 4 function ************************ //

  // ******************* step  function ************************ //


  // Get the modal
  var modal = document.getElementById("tmb-myModal");

  // Get the button that opens the modal
  var btn = document.getElementById("ProductRecommendation-btn");

  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("tmb-close")[0];

  // When the user clicks on the button, open the modal
  btn.onclick = function () {
    modal.style.display = "block";
  }

  // When the user clicks on <span> (x), close the modal
  span.onclick = function () {
    modal.style.display = "none";
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }


  // ********************************************************* //
  $(document).on('click', '.product-grid-loop', function () {
    var getID = $(this).data('product_id')

    if ($(this).hasClass('active')) {
      $(this).removeClass('active')
      $('select#ProductRecommendationData option[value="' + getID + '"]').removeAttr('selected');
    } else {
      $('select#ProductRecommendationData option[value="' + getID + '"]').attr('selected', 'selected');
      $(this).addClass('active')
    }

    var selected_products = $('select#ProductRecommendationData').val()
    
    console.log(selected_products);

    if (selected_products.length === 0) {
      $('div#PageRecommendation').hide()
      $('button#PageRecommendation-btn').hide()
      $('button#ProductRecommendation').removeAttr('step')

      var getNextElem = $('select[name="ProductRecommendation"]').parent().next();
      if ($(getNextElem).hasClass('error_msg2')) {
        $(getNextElem).remove();
      }

    } else {
      $('button#ProductRecommendation').attr('step', 'stepCompleted')
      $('div#PageRecommendation').show()
      $('button#PageRecommendation-btn').hide()
      var getNextElem = $('select[name="ProductRecommendation"]').parent().next();
      if ($(getNextElem).hasClass('error_msg2')) {
        $(getNextElem).remove();
      }
    }
  });
  // ********************************************************* //

  // ********** final step ************************************ //
  $('select[name="PageRecommendation"]').change((e) => {
    var selected_products = $('select[name="PageRecommendation"]').val()
    if (selected_products) {
      $('#save_formula-btn').show();
    } else {
      $('#save_formula-btn').hide();
    }
  })
  // ********** final step ************************************ //


  //  ***************** capture form values ********************* //


  const captureFormData = (fiels) => {
    var data = []
    var reptData = []
    fiels.each((index, elem) => {
      var innerData = {}
      var repeaterData = {}
      var name = $(elem).attr('name')
      innerData[name] = $(elem).val()
      if($(elem).attr('type') == 'checkbox'){
          if($(elem).prop('checked') == true){
          }else{
            return;
          }
      }
      // var str_pos = name.indexOf("group-b");
      // if (str_pos > -1) {
      //    repeaterData[] = 

      //    localStorage.setItem('previous',);
         

      //    reptData.push()
      // }

      data.push(innerData);
    })
    return data;
  }



  //  ***************** capture form values ********************* //

  // ****************** save formula data *********************** //


  $(document).on('click', 'button#save_formula-btn', (e) => {
    e.preventDefault();
    $('.error_msg, .error_msg2').remove();
    var errorMsg = '<p class="error_msg">Please enter valid data...</p>';
    var errorMsg2 = '<p class="error_msg2">Please enter valid data...</p>';

    // field validator
    var fiels = $('.hermesRaw_calculator_sec input[type="text"], .hermesRaw_calculator_sec input[type="number"], .hermesRaw_calculator_sec input[type="checkbox"], .hermesRaw_calculator_sec select')
    var falg = false;
    var count = 0;
    var error = 1;

    fiels.each((index, elem) => {
      if ($(elem).attr('type') == "text") {
        if (!$(elem).val()) { $(errorMsg).insertAfter($(elem)); error++ }
      } else if ($(elem).attr('type') == "number") {
        if (!$(elem).val()) { $(errorMsg).insertAfter($(elem)); error++ }
      } else if ($(elem).attr('type') == "checkbox") {
        if ($(elem).prop('checked') == true) {
          count++;
          //do something
        }
        if (count < 1) {
          $(errorMsg).insertAfter($(elem)); error++
        } else {
        }
      } else {
        if (!$(elem).val()) { $(errorMsg).insertAfter($(elem)); error++ }

      }
    })

    /// check error count if 0 then ok if number is grater than consider that error
    console.log(error);

    if (error === 1) {
      //  collection form data
      var el = document.getElementById('publish');
      el.click();

    } else {
      Swal.fire({
        title: 'Error!',
        text: 'All fields are required. Please check and try again.',
        icon: 'error',
        confirmButtonText: 'Cool'
      })
    }

  })



  // ****************** save formula data *********************** //



  let fiels = $('.hermesRaw_calculator_sec input[type="text"], .hermesRaw_calculator_sec input[type="number"], .hermesRaw_calculator_sec input[type="checkbox"], .hermesRaw_calculator_sec select')

  setInterval(() => {
    fiels.on('keyup change', (e) => {
      fiels = $('.hermesRaw_calculator_sec input[type="text"], .hermesRaw_calculator_sec input[type="number"], .hermesRaw_calculator_sec input[type="checkbox"], .hermesRaw_calculator_sec select')
      fieldErrorClear(fiels);
    });
  }, 1000);

  function fieldErrorClear(fiels) {
    fiels.on('keyup change', (e) => {
      var elem = e.target;
      var getElemType = $(elem).attr('type');

      if (getElemType == "text" || getElemType == "number" || getElemType == "checkbox") {
        var getNextElem = $(elem).next();
        if ($(getNextElem).hasClass('error_msg')) {
          $(getNextElem).remove();
        }
      } else {
        var getNextElem = $(elem).parent().next();
        if ($(getNextElem).hasClass('error_msg2')) {
          $(getNextElem).remove();
        }
      }
    });
  }

  fieldErrorClear(fiels);


});

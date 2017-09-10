$(document).ready(function() {
  initializeChosen();
});

function initializeChosen() {
  jQuery(".chosen").chosen();

  $('label').click(function() {
    var el = $(this).children('span:first-child');
    el.addClass('circle');
    var newone = el.clone(true);
    el.before(newone);
    $("." + el.attr("class") + ":last").remove();
  });

  function resizeChosen() {
    $(".chosen-container").each(function() {
      $(this).attr('style', 'width: 100%');
    });
  }

  resizeChosen();

  jQuery(window).on('resize', resizeChosen);
}

// doesn't work as of now
function validateForm() {
  console.log(isValidDate("#date_of_birth").val());
  return false;

  // validate Date of Birth
  if(!isValidDate("#date-of-birth").val()){
    $("#date-of-birth").setCustomValidity("Date must be valid date in format mm/dd/yyyy")
    return false;
  }

  console.log($("#choose-procedure option:selected").text());

  return true;
}

function isValidDate(date){
  return /^(0[1-9]|1[0-2])\/(0[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$/.test(date);
}

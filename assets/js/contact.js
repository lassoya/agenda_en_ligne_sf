import $ from 'jquery';

$('#add').click(() => {
  const firstInput = $('#container-number input').first().clone();
  firstInput.val('');
  $('#container-number').append(firstInput);
});

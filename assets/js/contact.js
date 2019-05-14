import $ from 'jquery';

$('#add').click(() => {
  const firstInput = $('#container-number input').first().clone();
  $('#container-number').append(firstInput);
});

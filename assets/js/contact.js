import $ from 'jquery';

$('#add').click(() => {
  // on clone le premier champ de type text qui est le numéro de téléphone
  // (input[type="text"])
  const firstInput = $('#container-number input[type="text"]').first().clone();
  // sur le champ cloné on vide sa valeur pour éviter de récuperer celle du
  // champ cloné
  firstInput.val('');
  // sur le champ cloné on redéfinit son nom pour éviter de récupérer le nom du premier
  // élement qui est phone[0][number]
  firstInput.attr('name', 'phone[][number]');
  $('#container-number').append(firstInput);
});

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

//on rajoute un evenement qui va écouter le click du bouton remove
$('.btn-remove').click(function(){
  //on masque la plus proche div parent qui a la classe row
  $(this).closest('div.row').hide();
  // on se position sur la plus proche div parent
  // dès qu'on est dessus on fait un find pour retrouver l'élement qui a la
  // classe remove et on indique que sa vauleur vaut true
  $(this).closest('div.row').find('.remove').val('true');
});

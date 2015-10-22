/**
 * Created by erwan on 21/10/15.
 */
function putIdValue($id){
    var textId = document.getElementById('form_id');
    var textSel = document.getElementById('form_sel')
    textId.value = $id;
    textSel.placeholder = 'Entre ton sel';
}
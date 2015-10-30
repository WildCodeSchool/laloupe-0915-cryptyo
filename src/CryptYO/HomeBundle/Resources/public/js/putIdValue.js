/**
 * Created by erwan on 21/10/15.
 */

//Ajout de l'id dans le champ de decryptage lors du clic sur le message

function putIdValue($id){
    var textId = document.getElementById('form_id');
    var textSel = document.getElementById('form_sel');
    textId.value = $id;
    textSel.placeholder = 'Entre ton sel';
}


// Pagination des messages

function plus() {
    [].forEach.call(document.getElementsByClassName('page1'), function(v, i, a){
        v.style.display = "table-row";
    });

    document.getElementById('voirPlus').style.display = "none";
    document.getElementById('plusPage').style.display = "inline-block";
}


var maxPage = document.getElementById('maxPage').getAttribute('data-value');
var maxPageFloor = Math.floor(maxPage/10);

var currentPage = 1; var goToPage;
function plusPage() {
    goToPage = currentPage + 1;

    [].forEach.call(document.getElementsByClassName('page'+goToPage), function(v, i, a){
        v.style.display = "table-row";
    });
    [].forEach.call(document.getElementsByClassName('page'+currentPage), function(v, i, a){
        v.style.display = "none";
    });
    currentPage++;

    document.getElementById('currentPage').innerHTML = goToPage;
    document.getElementById('moinsPage').style.display = "inline-block";

    if (goToPage > maxPageFloor) {
        document.getElementById('plusPage').style.display = "none";
    }
}

function moinsPage() {
    goToPage = currentPage - 1;

    [].forEach.call(document.getElementsByClassName('page'+goToPage), function(v, i, a){
        v.style.display = "table-row";
    });
    [].forEach.call(document.getElementsByClassName('page'+currentPage), function(v, i, a){
        v.style.display = "none";
    });
    currentPage--;

    document.getElementById('currentPage').innerHTML = goToPage;

    if (goToPage < 2) {
        document.getElementById('moinsPage').style.display = "none";
    }
    if (goToPage = maxPageFloor) {
        document.getElementById('plusPage').style.display = "inline-block";
    }
}

// Fermer la fenetre des messages

function closeMessage(){
    document.getElementById('messageTable').style.display = "none";
    document.getElementById('closeCross').style.display = "none";
    document.getElementById('openCross').style.display = "inline-block";
};
function openMessage(){
    document.getElementById('messageTable').style.display = "block";
    document.getElementById('closeCross').style.display = "inline-block";
    document.getElementById('openCross').style.display = "none";
}

function explode(){
    $( "#flashSendMessage" ).hide(1000);
    console.log('it work');
}setTimeout(explode, 5000);




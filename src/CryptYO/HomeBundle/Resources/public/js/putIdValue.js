/**
 * Created by erwan on 21/10/15.
 */
function putIdValue($id){
    var textId = document.getElementById('form_id');
    var textSel = document.getElementById('form_sel');
    textId.value = $id;
    textSel.placeholder = 'Entre ton sel';
}

/*function plus(){
    var hiddenTr = document.getElementsByClassName('display__none')[0];
    hiddenTr.style.display = "";
}*/
/*
function plusMessage (element, index, array) {
    console.log(element);
    console.log(index);
    console.log(array);
}
*/
function plus() {
    [].forEach.call(document.getElementsByClassName('page1'), function(v, i, a){
        v.style.display = "table-row";
    });

    document.getElementById('voirPlus').style.display = "none";
    document.getElementById('plusPage').style.display = "inline-block";
}

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

    document.getElementById('moinsPage').style.display = "inline-block";
    if (goToPage > 10) {
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

    if (goToPage < 2) {
        document.getElementById('moinsPage').style.display = "none";
    }
}